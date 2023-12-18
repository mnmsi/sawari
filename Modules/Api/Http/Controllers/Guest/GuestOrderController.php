<?php

namespace Modules\Api\Http\Controllers\Guest;

use App\Models\GuestCart;
use App\Models\GuestOrder;
use App\Models\GuestOrderDetails;
use App\Models\GuestUser;
use App\Models\Product\Product;
use App\Models\Product\ProductColor;
use App\Models\System\Area;
use App\Models\System\City;
use App\Models\System\DeliveryOption;
use App\Models\System\Division;
use App\Models\System\PaymentMethod;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Api\Http\Requests\Guest\GuestOrderRequest;
use Modules\Api\Http\Traits\Order\OrderTrait;
use Modules\Api\Http\Traits\Payment\PaymentTrait;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;

class GuestOrderController extends Controller
{
    use ApiResponseHelper, OrderTrait, PaymentTrait;

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
            $product = Product::where('id', $request->product_id)->first();
            $subtotal_price = $this->calculateDiscountPrice($product->price, $product->discount_rate) * $request->quantity;
            if (!empty($request->voucher_id)) {
                $calculateVoucher = $this->calculateVoucherDiscount($request->voucher_id, $subtotal_price);
                $subtotal_price = -$calculateVoucher;
            }
            if ($request->color_id) {
                $product_color = ProductColor::find($request->color_id);
                if ($product_color) {
                    if ($product_color->stock > 0) {
                        $subtotal_price += $product_color->price;
                        ProductColor::where('id', $request->color_id)->update([
                            'stock' => $product_color->stock - $request->quantity
                        ]);
                    } else {
                        return $this->respondError(
                            'Product is out of stock'
                        );
                    }
                }
            }

            $orderData = [
                'transaction_id' => uniqid(),
                'order_key' => uniqid(),
                'discount_rate' => $product->discount_rate ?? 0,
                'shipping_amount' => $request->shipping_amount,
                'subtotal_price' => $subtotal_price,
                'total_price' => $subtotal_price + $request->shipping_amount,
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
            ];

            $order = GuestOrder::create($orderData);
            $orderDetails = [
                'guest_order_id' => $order->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'product_color_id' => $request->product_color_id ?? null,
                'feature' => $request->feature_id ?? null,
                'price' => $product->price,
                'discount_rate' => $product->discount_rate ?? 0,
                'subtotal_price' => $subtotal_price,
            ];
            if ($order) {
                GuestOrderDetails::create($orderDetails);
                if ($request->payment_method_id == 2) {
//                    $sslc = new AmarPayController();
//                    if ($isProcessPayment = $sslc->payment($orderData)) {
                    if ($isProcessPayment = $this->processPayment($orderData)) {
                        DB::commit();
                        return [
                            'status' => 'success',
                            'message' => 'Payment Successful',
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
                    return [
                        'status' => true,
                        'message' => 'Payment Successful',
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
//        buy now from cart session
            $guest = GuestUser::where('uuid', $request->guest_user_id)->first();
            $carts = GuestCart::select('id', 'product_id', 'product_color_id', 'product_data', 'quantity')
                ->where('guest_user_id', $guest->id)->where('status', 1)->whereIn('id', $request->guest_cart_id)->get();
            $subtotal_price = 0;

            foreach ($carts as $cartItem) {
                $product = Product::find($cartItem['product_id']);
                $subtotal_price = $this->calculateDiscountPrice($product->price, $product->discount_rate) * $cartItem['quantity'];
//            product color price
                $product_color = ProductColor::find($cartItem['product_color_id']);
                if ($product_color) {
                    $subtotal_price += $product_color->price * $cartItem['quantity'];
                    if ($product_color->stock < $cartItem['quantity']) {
                        throw new \Exception('Product color out of stock.');
                    }
                    $product_color->stock = $product_color->stock - $cartItem['quantity'];
                    $product_color->save();
                }
            }
            if (!empty($request['voucher_id'])) {
                $voucher_dis = $this->calculateVoucherDiscount($request['voucher_id'], $subtotal_price);
                $subtotal_price = $subtotal_price - $voucher_dis;
            }
            $orderData = [
                'transaction_id' => uniqid(),
                'order_key' => uniqid(),
                'discount_rate' => $product->discount_rate ?? 0,
                'shipping_amount' => $request->shipping_amount,
                'subtotal_price' => $subtotal_price,
                'total_price' => $subtotal_price + $request->shipping_amount,
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
            ];
            $order = GuestOrder::create($orderData);

            $orderDetails = [];
            foreach ($carts as $p) {
                $product_p = Product::find($p['product_id']);
                $subtotal_p = $product_p->price;
                $product_color_p = ProductColor::find($p['product_color_id']);
                $subtotal_p += $product_color_p->price * $p['quantity'];
                $orderDetails[] = [
                    'guest_order_id' => $order->id,
                    'product_id' => $product_p->id,
                    'product_color_id' => $p['product_color_id'],
                    'feature' => $p['product_data_id'] ?? null,
                    'price' => $product_p->price,
                    'quantity' => $p['quantity'],
                    'discount_rate' => $product_p->discount_rate,
                    'subtotal_price' => $subtotal_p,
                ];
            }
            if ($order) {
                GuestOrderDetails::insert($orderDetails);
                GuestCart::whereIn('id', $request->guest_cart_id)->delete();
                if ($request->payment_method_id == 2) {
//                    $sslc = new AmarPayController();
//                    if ($isProcessPayment = $sslc->payment($orderData)) {
                    if ($isProcessPayment = $this->processPayment($orderData)) {
                        DB::commit();
                        return [
                            'status' => 'success',
                            'message' => 'Payment Successful',
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
                    return [
                        'status' => true,
                        'message' => 'Payment Successful',
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
