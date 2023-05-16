<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Requests\Order\CreateOrderRequest;
use Modules\Api\Http\Traits\Order\OrderTrait;

class OrderController extends Controller
{
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
        $order = $this->storeOrder($request->validated());
        return $this->respondWithSuccessWithData(
            $order
        );
    }

//
}
