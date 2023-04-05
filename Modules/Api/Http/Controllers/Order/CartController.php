<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Requests\Order\AddCartRequest;
use Modules\Api\Http\Traits\Order\CartTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class CartController extends Controller
{
    use CartTrait, ProductTrait;

    public function cart(AddCartRequest $request): JsonResponse
    {
        /*return response()
            ->json([
                'status' => 'success',
                'data'   => [],
            ])
            ->withCookie(cookie()->forget('cart'));*/

        // Add product to cart
        $carts = $this->addProductToCart($request->all());

        // Check if there is any error
        if (isset($carts['error'])) {
            return $this->respondFailedValidation($carts['error']);
        }

        // Get carted product details
        $cartedProdDetails = $this->getCartedProductDetails($carts);

        return response()
            ->json([
                'status' => true,
                'data'   => $cartedProdDetails,
            ])->withCookie(
                cookie()
                    ->forever('cart', json_encode($carts)));
    }
}
