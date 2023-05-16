<?php

namespace Modules\Api\Http\Traits\Order;

use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\System\DeliveryOption;
use App\Models\System\PaymentMethod;
use Illuminate\Support\Facades\Auth;

trait OrderTrait
{
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
//        get products  data from cart ids

        $cartIds = $data['cart_id'];
        $products = Cart::whereIn('id', $cartIds)
                           ->select('id','product_id','product_color_id','price','quantity')
                           ->get();
        dd($data);
        $user = Auth::id();
        $data['user_id'] = $user;
        $order = Order::create($data);
        return $order;
    }
}
