<?php

namespace Modules\Api\Http\Traits\Order;

use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Models\OrderDetails;
use App\Models\Product\Product;
use App\Models\Product\ProductColor;
use App\Models\System\Area;
use App\Models\System\City;
use App\Models\System\DeliveryOption;
use App\Models\System\Division;
use App\Models\System\Notification;
use App\Models\System\PaymentMethod;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Api\Http\Traits\Payment\PaymentTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

trait OrderTrait
{
    use productTrait;

    public function getDeliveryOptions()
    {
        return DeliveryOption::where('is_active', 1)
            ->select('id', 'name', 'bonus')
            ->get();
    }

    public function getPaymentMethods()
    {
        return PaymentMethod::where('is_active', 1)
            ->select('id', 'name')
            ->get();
    }

    public function storeOrder($data)
    {
        DB::beginTransaction();
        try {
            $newPrice = 0;
            $cartIds = $data['cart_id'];
            $carts = Cart::whereIn('id', $cartIds)
                ->select('id', 'product_id', 'product_color_id')->get();
            $products = Product::whereIn('id', $carts->pluck('product_id'))->with('colors')->get();
            $total_discountRate = $products->sum('discount_rate');
            $subtotal_price = $this->calculateDiscountPrice($products->sum('price'), $total_discountRate);
//            $newPrice =
            $carts->map(function ($value, $key) {
                return $value['product_id'] == 1;
            });
//            color check
            //calculateDiscountPrice
            foreach ($carts as $c) {
//                $newProduct = Product::find($c["product_id"]);
                $product_color = ProductColor::find($c['product_color_id']);
                if ($product_color) {
                    if ($product_color->stock < $c['quantity']) {
                        throw new \Exception('Product color out of stock.');
                    }
                    $product_color->stock = $product_color->stock - $c['quantity'];
                    $product_color->save();
                }
            }

            $orderData = [
                'user_id' => Auth::id(),
                'transaction_id' => uniqid(),
                'order_key' => uniqid(),
                'delivery_option_id' => $data['delivery_option_id'],
                'payment_method_id' => $data['payment_method_id'],
                'user_address_id' => $data['user_address_id'],
                'showroom_id' => $data['showroom_id'],
                'shipping_amount' => $data['shipping_amount'],
                'subtotal_price' => $subtotal_price,
                'discount_rate' => $total_discountRate,
                'total_price' => $subtotal_price + $data['shipping_amount'] ?? 0,
                'status' => 1,
//                new
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'voucher_id' => $data['voucher_id'] ?? null,
                'division' => Division::where('id', $data['division_id'])->first()->name,
                'city' => City::where('id', $data['city_id'])->first()->name,
                'area' => Area::where('id', $data['area_id'])->first()->name,
                'address_line' => $data['address_line'],
            ];
            $order = Order::create($orderData);
            $orderDetails = [];
            foreach ($products as $product) {
                $discountRate = $product->discount_rate;
                $subtotal = $product->price * count($products);
                $orderDetails[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_color_id' => collect($carts)->filter(function ($value, $key) use ($product) {
                        return $value['product_id'] == $product->id;
                    })->first()->product_color_id,
                    'price' => $product->price,
                    'discount_rate' => $discountRate,
                    'subtotal_price' => $subtotal,
                    'quantity' => count($products),
                    'total' => $subtotal + $data['shipping_amount'] ?? 0,
                ];
                if ($order) {
                    Cart::whereIn('id', $cartIds)->delete();
                    OrderDetails::insert($orderDetails);
                    if ($data['payment_method_id'] == 2) {
                        if ($isProcessPayment = $this->processPayment($orderData)) {
                            DB::commit();
                            $numbers = Notification::where('status', 1)->get();
                            foreach ($numbers as $number) {
                                $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed  Please check your dashboard");
                            }
                            return [
                                'status' => true,
                                'message' => 'Payment Successful',
                                'data' => json_decode($isProcessPayment)
                            ];
                        } else {
                            return [
                                'status' => false,
                                'message' => 'Order Unsuccessful',
                            ];
                        }
                    } else {
                        DB::commit();
                        $numbers = Notification::where('status', 1)->get();
                        foreach ($numbers as $number) {
                            $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed  Please check your dashboard");
                        }
                        return [
                            'data' => [
                                'order_key' => $order->order_key,
                                'transaction_id' => $order->transaction_id,
                                'status' => true,
                                'message' => 'Order Successful',
                            ]
                        ];
                    }
                } else {
                    return [
                        'status' => false,
                        'message' => 'Order Unsuccessful',
                    ];
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function getUserOrderList()
    {
        return Order::where('user_id', Auth::id())->get();
    }

    public function buyNowProduct($request)
    {
        try {
            $buyNowProduct = Product::with(['colors'=>function($q) use ($request){
                return $q->where('id',$request->product_color_id)->first();
            }])->find($request->product_id);
            if ($buyNowProduct) {
                return $buyNowProduct;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function buyNowRequest($data)
    {
        DB::beginTransaction();
        try {
            $products = Product::where('id', $data->product_id)->first();
            // color
            $newPrice = 0;
            $newPrice = $this->calculateDiscountPrice($products->price, $products->discount_rate);
            $product_color_check = ProductColor::find($data['product_color_id']);
            if ($product_color_check) {
                if ($product_color_check->stock < 1) {
                    throw new \Exception('Product color out of stock.');
                }
                $product_color_check->stock = $product_color_check->stock - 1;
                $product_color_check->save();
                $newPrice +=  $product_color_check->price * 1;
            }

            $total_discountRate = $products->discount_rate;
//            $subtotal_price = $this->calculateDiscountPrice($products->price, $products->discount_rate);
            $subtotal_price = $newPrice;
            $orderData = [
                'user_id' => Auth::id(),
                'transaction_id' => uniqid(),
                'order_key' => uniqid(),
                'delivery_option_id' => $data['delivery_option_id'],
                'payment_method_id' => $data['payment_method_id'],
                'user_address_id' => $data['user_address_id'] ?? null,
                'showroom_id' => $data['showroom_id'] ?? null,
                'shipping_amount' => $data['shipping_amount'] ?? 0,
                'subtotal_price' => $subtotal_price,
                'discount_rate' => $total_discountRate,
                'total_price' => $subtotal_price + $data['shipping_amount'] ?? 0,
                'status' => 1,
                'division' => Division::where('id', $data['division_id'])->first()->name,
                'city' => City::where('id', $data['city_id'])->first()->name,
                'area' => Area::where('id', $data['area_id'])->first()->name,
                'address_line' => $data['address_line'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'voucher_id' => $data['voucher_id'] ?? null,
            ];
            $order = Order::create($orderData);
            $orderDetails = [
                'order_id' => $order->id,
                'product_id' => $products->id,
                'product_color_id' => $data['product_color_id'],
                'price' => $products->price,
                'discount_rate' => $total_discountRate,
                'subtotal_price' => $subtotal_price,
                'quantity' => 1,
                'total' => $subtotal_price + $data['shipping_amount'] ?? 0,
            ];
            if ($order) {
                OrderDetails::create($orderDetails);
                if ($data['payment_method_id'] == 2) {
                    if ($isProcessPayment = $this->processPayment($orderData)) {
                        DB::commit();
                        $numbers = Notification::get();
                        foreach ($numbers as $number) {
                            $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed  Please check your dashboard");
                        }
                        return [
                            'status' => true,
                            'message' => 'Payment Successful',
                            'data' => json_decode($isProcessPayment)
                        ];
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Order Unsuccessful',
                        ];
                    }
                } else {
                    DB::commit();
                    $numbers = Notification::get();
                    foreach ($numbers as $number) {
                        $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed  Please check your dashboard");
                    }
                    return [
                        'order_key' => $order->order_key,
                        'transaction_id' => $order->transaction_id,
                        'status' => true,
                        'message' => 'Order Successful',
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'message' => 'Order Unsuccessful',
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function buyNowProductPrice($request)
    {

//        $buyNowProduct = $this->buyNowProduct($request);
//        dd($buyNowProduct->toArray());
        $buyNowProduct = Product::with(['colors'=>function($q) use ($request){
            return $q->where('id',$request->product_color_id);
        }])->find($request->product_id);
//        dd($buyNowProduct->price,$buyNowProduct->colors[0]->price);
        return $this->calculateDiscountPrice($buyNowProduct->price , $buyNowProduct->discount_rate) + $buyNowProduct->colors[0]->price ?? 0;
    }

    public function calculateVoucherDiscount($id, $amount)
    {
        return 0;
//        $value = $amount;
//        $voucher = Voucher::where('id', $id)
//            ->where('expires_at', '>', Carbon::parse(now()->addHours(6))->format('Y-m-d H:i:s'))
//            ->where('status', 1)
//            ->first();
//        if ($voucher) {
//            if ($voucher->type == "percentage") {
//                $value = (($value * $voucher->value) / 100);
//            } else {
//                $value = $voucher->value;
//            }
//            return $value;
//        } else {
//            return 0;
//        }
    }

}
