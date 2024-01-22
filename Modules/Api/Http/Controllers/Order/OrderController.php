<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\GuestOrder;
use App\Models\Order\Order;
use App\Models\System\Notification;
use App\Models\System\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Requests\Order\AddCartRequest;
use Modules\Api\Http\Requests\Order\CreateOrderRequest;
use Modules\Api\Http\Resources\Order\OrderResource;
use Modules\Api\Http\Traits\Order\OrderTrait;
use Modules\Api\Http\Traits\OTP\OtpTrait;
use Modules\Api\Http\Traits\Payment\PaymentTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class OrderController extends Controller
{
    use ProductTrait;
    use PaymentTrait;
    use OrderTrait;
    use OtpTrait;

    /**
     * Get Delivery Options
     *
     * @return JsonResponse
     */
    public function deliveryOptions(): JsonResponse
    {
        return $this->respondWithSuccessWithData(
            $this->getDeliveryOptions()
        );
    }

    /**
     * Get Payment Methods
     *
     * @return JsonResponse
     */
    public function paymentMethods(): JsonResponse
    {
        return $this->respondWithSuccessWithData(
            $this->getPaymentMethods()
        );
    }

    public function order(CreateOrderRequest $request)
    {
        $order = $this->storeOrder($request);
        if ($order) {
            $numbers = Notification::get();
            foreach ($numbers as $number) {
                $this->sendSms(trim($number->phone), "New order has been placed");
            }
            return $this->respondWithSuccessWithData(
                $order
            );
        } else {
            return $this->respondError(
                "Something went wrong"
            );
        }

    }

    public function orderList()
    {
        $orders = $this->getUserOrderList();
        if ($orders) {
            return $this->respondWithSuccessWithData(
                $orders
            );
        } else {
            return $this->respondError(
                "Something went wrong"
            );
        }
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_color_id' => 'required|exists:product_colors,id',
        ]);
        $cart = $this->buyNowProduct($request);
        if ($cart) {
            return $this->respondWithSuccess([
                'data' => [new OrderResource($cart)],
                'total_price' => $this->buyNowProductPrice($request),
            ]);
        } else {
            return $this->respondError(
                "Something went wrong"
            );
        }
    }

    public function makeOrderFromBuyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_color_id' => 'required|exists:product_colors,id',
        ]);
        $order = $this->buyNowRequest($request);
        if ($order) {
            $numbers = Notification::get();
            foreach ($numbers as $number) {
                $this->sendSms(trim($number->phone), "New order has been placed");
            }
//            send sms if order success
            return $this->respondWithSuccessWithData(
                $order
            );
        } else {
            return $this->respondError(
                "Something went wrong!"
            );
        }
    }

    public function orderInvoiceGenerate(Request $request, $id)
    {
        try {
            $order = Order::with("orderDetails", "orderDetails.product", "orderDetails.product_color")->find($id);
            $site = SiteSetting::first();
            $discount = null;

//            return view('pdf.invoice', [
//                'order' => $order,
//                'site' => $site,
//                'discount' => $discount,
//                'data' => $request->all()
//            ]);

            $pdf = Pdf::loadView('pdf.invoice', [
                'order' => $order,
                'site' => $site,
                'discount' => $discount,
                'data' => $request->all()
            ]);
//            return $pdf->stream('invoice.pdf');
            return $pdf->download($order->transaction_id . '_invoice.pdf');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function guestOrderInvoiceGenerate(Request $request, $id)
    {
        try {
            $order = GuestOrder::with("orderItems", "orderItems.product", "orderItems.productColor")->find($id);
            $site = SiteSetting::first();
            $discount = null;

            $pdf = Pdf::loadView('pdf.guest_invoice', [
                'order' => $order,
                'site' => $site,
                'discount' => $discount,
                'data' => $request->all()
            ]);

//            return $pdf->stream('invoice.pdf');
            return $pdf->download($order->transaction_id . '_invoice.pdf');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
