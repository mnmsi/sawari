<?php

namespace Modules\Api\Http\Traits\Order;

use App\Models\Order\Cart;
use Closure;
use Illuminate\Support\Arr;
use Modules\Api\Http\Resources\Product\BrandResource;
use Modules\Api\Http\Resources\Product\ColorResource;
use Modules\Api\Http\Traits\Product\ProductTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait CartTrait
{
    /**
     * @param $product
     * @param $data
     * @return array|Closure|mixed|object
     */
    public function addProductToCart($product, $data)
    {
        $cartData = request()->cookie('cart');
        $cart     = json_decode($cartData, true) ?: [];

        if ($this->checkExistingCartProduct($cart, $data)) {
            $cart = $this->updateExistingCartProductQuantity($cart, $data);
        } else {
            $cart[] = $this->addNewProduct($data);
        }

        return $cart;
    }

    /**
     * @param $cart
     * @param $data
     * @return bool
     */
    public function checkExistingCartProduct($cart, $data)
    {
        return count($this->getExistingCartProduct($cart, $data)) > 0;
    }

    /**
     * @param $cart
     * @param $data
     * @return array
     */
    public function getExistingCartProduct($cart, $data)
    {
        return Arr::where($cart, function ($value) use ($data) {
            return $value['product_id'] == $data['product_id'] && $value['product_color_id'] == $data['product_color_id'];
        });
    }

    /**
     * @param $data
     * @return array
     */
    public function addNewProduct($data)
    {
        return [
            'product_id'       => $data['product_id'],
            'product_color_id' => $data['product_color_id'],
            'quantity'         => $data['quantity'],
        ];
    }

    public function updateExistingCartProductQuantity($cart, $data)
    {
        foreach ($this->getExistingCartProduct($cart, $data) as $key => $item) {
            $cart[$key]['quantity'] = $item['quantity'] + $data['quantity'];
        }

        return $cart;
    }

    /**
     * @param $carts
     * @return array
     */
    public function getCartedProductDetails($carts)
    {
        $cartedProdDetails = [];
        foreach ($carts as $cart) {
            // Get product details
            $product = $this->getProductDetails($cart['product_id']);
            $product->load('brand', 'colors');

            // Calculate discount price
            $discountPrice = $this->calculateDiscountPrice($product->price, $product->discount_rate);
            $color         = $product->colors->first();

            // Push product details to cartedProdDetails array
            $cartedProdDetails[] = [
                'product_id'      => $product->id,
                'product_name'    => $product->name,
                'brand'           => new BrandResource($product->brand),
                'color'           => new ColorResource($color),
                'quantity'        => $cart['quantity'],
                'price'           => $product->price,
                'discount_rate'   => $product->discount_rate,
                'discount_price'  => $discountPrice,
                'total_price'     => $discountPrice * $cart['quantity'],
                'shipping_charge' => $product->shipping_charge,
                'stock'           => $color->stock,
            ];
        }

        // Return carted product details
        return $cartedProdDetails;
    }
}
