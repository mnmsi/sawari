<?php

namespace Modules\Api\Http\Traits\Payment;

use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\User\User;
use Illuminate\Http\Request;

trait PaymentTrait
{
    public function processPayment($orderData,$req)
    {
//        $user                          = User::where('id', $orderData['user_id'])->first();
        $sslc                          = new SslCommerzNotification();
        $orderData['cus_email']        = $req->email ?? "";
        $orderData['cus_phone']        = $req->phone ?? "";
        $orderData['request']  = $req;
        $orderData['shipping_method']  = "NO";
        $orderData['product_name']     = "Sawari Product";
        $orderData['product_category'] = "Ecommerce";
        $orderData['product_profile']  = "general";
        $orderData['success_url']      = url('/payment/success');
        return $sslc->makePayment($orderData, 'checkout', 'json');

    }

    public function success(Request $request)
    {
        return view('api::payment.success');
    }

    public function failure()
    {
        return view('api::payment.failure');
    }

    public function cancel()
    {
        return view('api::payment.cancel');
    }

    public function ipn()
    {
        return view('api::payment.ipn');
    }
}
