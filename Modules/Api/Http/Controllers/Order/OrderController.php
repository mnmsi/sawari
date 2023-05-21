<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Requests\Order\CreateOrderRequest;
use Modules\Api\Http\Traits\Order\OrderTrait;
use Modules\Api\Http\Traits\Payment\PaymentTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class OrderController extends Controller
{
    use ProductTrait;
    use PaymentTrait;
    use OrderTrait;

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

//
}
