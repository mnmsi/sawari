<?php

namespace Modules\Api\Http\Traits\Order;

use App\Models\Order\Cart;
use Closure;
use Illuminate\Support\Arr;
use Modules\Api\Http\Resources\Cart\CartResource;
use Modules\Api\Http\Resources\Product\BrandResource;
use Modules\Api\Http\Resources\Product\ColorResource;

trait CartTrait
{
    /**
     * @return array|mixed
     */
    public function getCartedData()
    {
        return Cart::with(['product', 'productColor'])->where('user_id', auth()->id())->get();
    }

    /**
     * @param $data
     * @return array|Closure|mixed|object
     */
    public function addProductToCart($request): mixed
    {
        $request->merge(['user_id' => auth()->id()]);
        $cart = Cart::where('product_id',$request->product_id)->where('product_color_id',$request->product_color_id)->where('user_id',auth()->id())->first();
        if ($cart) {
            $cart->update($request->all());
            return $cart;
        } else {
            return Cart::create($request->all());
        }
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

    /**
     * @param $data
     * @return array
     */

    /**
     * @param $cart
     * @param $data
     * @return mixed|string[]
     */


    public function removeProductFromCart($id)
    {
        $cart = Cart::where('id',$id)->where('user_id',auth()->id())->first();
        if ($cart) {
            $cart->delete();
            return true;
        } else {
            return false;
        }
    }


}
