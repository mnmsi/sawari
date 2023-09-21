<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\PreOrder;
use Modules\Api\Http\Requests\Product\PreOrderRequest;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;

class PreOrderController extends Controller
{

    use ApiResponseHelper;
    public function store(PreOrderRequest $request)
    {
        try {
            $data = [
                'product_name' => $request->product_name,
                'name' => $request->name,
                'phone' => $request->phone,
                'product_quantity' => $request->product_quantity,
                'email' => $request->email ?? null,
                'address' => $request->address ?? null,
            ];
            if ($request->hasFile('product_image')) {
                $data['product_image'] = $request->product_image->store('pre_order', 'public');
            }else{
                $data['product_image'] = $request->product_image;
            }
            PreOrder::create($data);
            return $this->respondWithSuccess(['message' => 'Pre Order Created Successfully']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
