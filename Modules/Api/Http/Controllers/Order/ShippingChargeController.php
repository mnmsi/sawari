<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Models\ShippingCharge;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
class ShippingChargeController extends \App\Http\Controllers\Controller
{
    public function shippingCharges($name=null)
    {
        $text = strtolower($name);
        if($text == 'dhaka'){
            $shipping_charge = ShippingCharge::where('title', '=', 'Inside Dhaka')->where('active', 1)->get();
        }else{
            $shipping_charge = ShippingCharge::whereNotIn('title', ['Inside Dhaka'])->where('active', 1)->get();
        }
        return response()->json([
            'status' => 'success',
            'data' => $shipping_charge
        ]);
    }
}
