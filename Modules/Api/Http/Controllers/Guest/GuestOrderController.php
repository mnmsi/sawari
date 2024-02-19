<?php

namespace Modules\Api\Http\Controllers\Guest;

use App\Models\GuestCart;
use App\Models\GuestOrder;
use App\Models\GuestOrderDetails;
use App\Models\GuestUser;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Product\ProductColor;
use App\Models\System\Area;
use App\Models\System\City;
use App\Models\System\DeliveryOption;
use App\Models\System\Division;
use App\Models\System\Notification;
use App\Models\System\PaymentMethod;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Api\Http\Requests\Guest\GuestOrderRequest;
use Modules\Api\Http\Traits\Order\OrderTrait;
use Modules\Api\Http\Traits\OTP\OtpTrait;
use Modules\Api\Http\Traits\Payment\PaymentTrait;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;
use Str;

class GuestOrderController extends Controller
{
    use ApiResponseHelper, OrderTrait, PaymentTrait, OtpTrait;

    public function guestOrder(GuestOrderRequest $request)
    {
        if (isset($request->guest_cart_id)) {
            $order = $this->buyNowFromCart($request);
        } else {
            $order = $this->buyNow($request);
        }
        return $order;
    }

    public function buyNow($request)
    {
        DB::beginTransaction();
        try {
            $product = Product::with('colors')->where('id', $request->product_id)->first();
            $price = $product->price + $product->colors->whereIn('id', $request->product_color_id)->sum('price');
            $subtotal_price = $this->calculateDiscountPrice($price, $product->discount_rate) * $request->quantity;

//            if (!empty($request->voucher_id)) {
//                $calculateVoucher = $this->calculateVoucherDiscount($request->voucher_id, $subtotal_price);
//                $subtotal_price = -$calculateVoucher;
//            }

            if ($request->product_color_id) {
                $product_color = ProductColor::find($request->product_color_id);
                if ($product_color) {
                    if ($product_color->stock > 0) {
                        ProductColor::where('id', $request->product_color_id)->update([
                            'stock' => $product_color->stock - $request->quantity
                        ]);
                    } else {
                        return $this->respondError(
                            'Product is out of stock'
                        );
                    }
                }
            }


            $orderKey = str_replace(' ', '', 'SAWBD-' . now()->format('dmY') . '-' . GuestOrder::count() + 1);
            if (isset($data['showroom_id']) && $data['showroom_id'] == 6) {
                $orderKey = str_replace(' ', '', 'HPS-' . now()->format('dmY') . '-' . GuestOrder::count() + 1);
            }


            $totalPrice = $subtotal_price + $request->shipping_amount;


            $orderData = [
                'transaction_id' => $orderKey,
                'order_key' => $orderKey,
                'discount_rate' => $product->discount_rate ?? 0,
                'shipping_amount' => $request->shipping_amount,
                'subtotal_price' => $subtotal_price,
                'total_price' => $totalPrice,
                'name' => $request->name,
                'phone_number' => $request->phone,
                'email' => $request->email ?? null,
                'city' => City::where('id', $request->city_id)->first()->name,
                'division' => Division::where('id', $request->division_id)->first()->name,
                'area' => Area::where('id', $request->area_id)->first()->name,
                'address_line' => $request->address_line,
                'delivery_option' => DeliveryOption::where('id', $request->delivery_option_id)->first()->name,
                'payment_method' => PaymentMethod::where('id', $request->payment_method_id)->first()->name,
                'order_note' => $request->order_note ?? null,
                'voucher_code' => $request->voucher_code ?? null,
                'showroom_id' => $request->showroom_id ?? null,
            ];

            $order = GuestOrder::create($orderData);
            $orderDetails = [
                'guest_order_id' => $order->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'product_color_id' => $request->product_color_id ?? null,
                'feature' => $request->feature_id ?? null,
                'price' => $price,
                'discount_rate' => $product->discount_rate ?? 0,
                'subtotal_price' => $subtotal_price,
            ];
            if ($order) {
                GuestOrderDetails::create($orderDetails, $request);
                if ($request->payment_method_id == 2) {
                    if ($isProcessPayment = $this->processPayment($orderData, $request)) {
                        DB::commit();
                        $numbers = Notification::where('status', 1)->get();
                        foreach ($numbers as $number) {
                            $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed with the order number: " . $order->order_key . "  Please check your dashboard");
                        }
                        return [
                            'status' => 'success',
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
                        $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed with the order number: " . $order->order_key . "  Please check your dashboard");
                    }
                    return [
                        'order_key' => $order->order_key,
                        'transaction_id' => $order->transaction_id,
                        'status' => true,
                        'message' => 'Order Successful',
                    ];
                }
            } else {
                DB::rollBack();
                return $this->respondError(
                    'Something went wrong'
                );
            }
        } catch (\Exception $e) {
            return $this->respondError(
                $e->getMessage()
            );
        }
    }

    public function buyNowFromCart($request)
    {
        DB::beginTransaction();
        try {
            $guest = GuestUser::where('uuid', $request->guest_user_id)->first();
            $guestCarts = GuestCart::where('guest_user_id', $guest->id)->where('status', 1);
            $carts = $guestCarts->get();
            $orderDetails = [];

            if ($carts->isEmpty()) {
                throw new \Exception('Cart is empty.');
            }

            foreach ($carts as $cartItem) {
                $product = Product::with('colors')->where('id', $cartItem['product_id'])->first();
                $price = $product->price + $product->colors->whereIn('id', $cartItem->product_color_id)->sum('price');
                $subtotal_price = $this->calculateDiscountPrice($product->price, $product->discount_rate) * $cartItem['quantity'];

                $product_color = $product->colors->whereIn('id', $cartItem->product_color_id)->first();
                if ($product_color) {
                    if ($product_color->stock < $cartItem['quantity']) {
                        throw new \Exception('Product color out of stock.');
                    }
                    $product_color->stock = $product_color->stock - $cartItem['quantity'];
                    $product_color->save();
                }

                $orderDetails[] = [
                    'product_id' => $cartItem['product_id'],
                    'product_color_id' => $cartItem['product_color_id'],
                    'price' => $price,
                    'quantity' => $cartItem['quantity'],
                    'discount_rate' => $product->discount_rate,
                    'subtotal_price' => $subtotal_price,
                ];
            }

            $subtotal_price = collect($orderDetails)->sum('subtotal_price');
            $totalPrice = $subtotal_price + $request->shipping_amount;

            $orderKey = str_replace(' ', '', 'SAWBD-' . now()->format('dmY') . '-' . GuestOrder::count() + 1);
            if (isset($data['showroom_id']) && $data['showroom_id'] == 6) {
                $orderKey = str_replace(' ', '', 'HPS-' . now()->format('dmY') . '-' . GuestOrder::count() + 1);
            }

            $orderData = [
                'transaction_id' => $orderKey,
                'order_key' => $orderKey,
                'discount_rate' => $product->discount_rate ?? 0,
                'shipping_amount' => $request->shipping_amount,
                'subtotal_price' => $subtotal_price,
                'total_price' => $totalPrice,
                'name' => $request->name,
                'phone_number' => $request->phone,
                'email' => $request->email ?? null,
                'city' => City::where('id', $request->city_id)->first()->name,
                'division' => Division::where('id', $request->division_id)->first()->name,
                'area' => Area::where('id', $request->area_id)->first()->name,
                'address_line' => $request->address_line,
                'delivery_option' => DeliveryOption::where('id', $request->delivery_option_id)->first()->name,
                'payment_method' => PaymentMethod::where('id', $request->payment_method_id)->first()->name,
                'order_note' => $request->order_note ?? null,
                'voucher_code' => $request->voucher_code ?? null,
                'showroom_id' => $request->showroom_id ?? null,
            ];
            $order = GuestOrder::create($orderData);
            if ($order) {
                $orderDetails = array_map(function ($item) use ($order) {
                    $item['guest_order_id'] = $order->id;
                    return $item;
                }, $orderDetails);

                GuestOrderDetails::insert($orderDetails);
                $guestCarts->delete();

                if ($request->payment_method_id == 2) {
                    if ($isProcessPayment = $this->processPayment($orderData, $request)) {
                        DB::commit();
                        $numbers = Notification::where('status', 1)->get();
                        foreach ($numbers as $number) {
                            $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed with the order number: " . $order->order_key . "  Please check your dashboard");
                        }
                        return [
                            'status' => 'success',
                            'message' => 'Order Successful',
                            'data' => json_decode($isProcessPayment)
                            //                            'data' => $isProcessPayment->getTargetUrl()
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
                        $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed with the order number: " . $order->order_key . "  Please check your dashboard");
                    }
                    return [
                        'order_key' => $order->order_key,
                        'transaction_id' => $order->transaction_id,
                        'status' => true,
                        'message' => 'Order Successful',
                    ];
                }
            } else {
                DB::rollBack();
                return $this->respondError(
                    'Something went wrong'
                );
            }
        } catch (\Exception $e) {
            return (
            [
                $e->getMessage(),
                $e->getLine(),
            ]
            );
        }
    }
}
