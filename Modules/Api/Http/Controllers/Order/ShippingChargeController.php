<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Models\ShippingCharge;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShippingChargeController extends \App\Http\Controllers\Controller
{
    public function shippingCharges($name = null)
    {
        $text = strtolower($name);

        $shippingCharge = Cache::rememberForever('shipping_charges.' . $text, function () use ($text) {
            if ($text == 'dhaka') {
                return ShippingCharge::where('title', '=', 'Inside Dhaka')->where('active', 1)->get();
            }
            else {
                return ShippingCharge::whereNotIn('title', ['Inside Dhaka'])->where('active', 1)->get();
            }
        });

        return response()->json([
            'status' => 'success',
            'data'   => $shippingCharge,
        ]);
    }
}
