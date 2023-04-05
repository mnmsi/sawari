<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Requests\Order\AddCartRequest;
use Modules\Api\Http\Traits\Order\CartTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    use CartTrait, ProductTrait;

    public function cart(AddCartRequest $request): JsonResponse
    {
        $product           = $this->getProductDetails($request->product_id);
        $carts             = $this->addProductToCart($product, $request->all());
        $cartedProdDetails = $this->getCartedProductDetails($carts);

        /*return response()
            ->json([
                'status' => 'success',
                'data'   => [],
            ])
            ->withCookie(cookie()->forget('cart'));*/

        return response()
            ->json([
                'status' => true,
                'data'   => $cartedProdDetails,
            ])->withCookie(
                cookie()
                    ->forever('cart', json_encode($carts)));
    }
}
