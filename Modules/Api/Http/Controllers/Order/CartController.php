<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Modules\Api\Http\Requests\Order\AddCartRequest;
use Modules\Api\Http\Resources\Cart\CartResource;
use Modules\Api\Http\Traits\Order\CartTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class CartController extends Controller
{
    use CartTrait, ProductTrait;

    /**
     * @return JsonResponse
     */
    public function carts()
    {
        $carts = $this->getCartedData(); // Get carted data
        return $this->respondWithSuccessWithData(
            CartResource::collection($carts)
        );
    }

    /**
     * @param AddCartRequest $request
     * @return JsonResponse
     */
    public function store(AddCartRequest $request): JsonResponse
    {
        $this->addProductToCart($request); // Get carted data
        return $this->respondWithSuccess([
            'message' => 'Product added to cart successfully',
        ]);
    }

    /**
     * @param $sku
     * @return JsonResponse
     */
    public function removeCart($id)
    {
        $cart = $this->removeProductFromCart($id);
        if($cart){
            return $this->respondWithSuccess([
                'message' => 'Product removed from cart successfully',
            ]);
        }else{
            return $this->respondError('Product not found in cart');
        }
    }
}
