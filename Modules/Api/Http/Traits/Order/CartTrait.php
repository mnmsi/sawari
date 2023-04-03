<?php

namespace Modules\Api\Http\Traits\Order;

use App\Models\Order\Cart;
use Closure;
use Illuminate\Support\Arr;
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

            $data['price'] = $this->calculateDiscountPrice($product->price, $product->discount_rate);

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
        return Arr::where($cart, function ($value, $key) use ($data) {
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
            'price'            => $data['price'],
            'total'            => $data['price'] * $data['quantity'],
        ];
    }

    public function updateExistingCartProductQuantity($cart, $data)
    {
        foreach ($this->getExistingCartProduct($cart, $data) as $key => $item) {
            $cart[$key]['quantity'] = $item['quantity'] + $data['quantity'];
            $cart[$key]['total']    = $cart[$key]['quantity'] * $cart[$key]['price'];
        }

        return $cart;
    }
}
