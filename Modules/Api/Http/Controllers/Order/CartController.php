<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Modules\Api\Http\Requests\Order\AddCartRequest;
use Modules\Api\Http\Traits\Order\CartTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class CartController extends Controller
{
    use CartTrait, ProductTrait;

    /**
     * @param AddCartRequest $request
     * @return JsonResponse
     */
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

        // Return response with cookie
        return $this->returnResponseWithCookie($carts);
    }

    public function removeCart($sku)
    {
        $cartedData = $this->getCartedData();                           // Get carted data
        $isExits    = $this->getExistingCartProduct($cartedData, $sku); // Check if product exists in cart

        // Check if product doesn't exist in cart
        if (count($isExits) == 0) {
            return $this->respondFailedValidation('Product not found in cart');
        }

        // Remove product from cart
        $carts = $this->removeProductFromCart($cartedData, array_key_first($isExits));

        // Return response with cookie
        return $this->returnResponseWithCookie($carts);
    }
}
