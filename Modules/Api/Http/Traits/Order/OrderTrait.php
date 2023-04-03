<?php

namespace Modules\Api\Http\Traits\Order;

use App\Models\Product\Product;
use App\Models\System\DeliveryOption;
use App\Models\System\PaymentMethod;

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
}
