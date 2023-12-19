<?php

namespace Modules\Api\Http\Controllers\Cart;

use App\Models\GuestCart;
use App\Models\GuestUser;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Api\Http\Requests\Order\AddCartRequest;
use Modules\Api\Http\Resources\Cart\CartResource;
use Modules\Api\Http\Resources\Cart\GuestCartResource;
use Modules\Api\Http\Traits\Product\ProductTrait;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;

class GuestCartController extends Controller
{
    use ApiResponseHelper, ProductTrait;

    public function store(AddCartRequest $request)
    {
        $guestUser = GuestUser::where('uuid', $request->guest_user_id)->first();
        $checkCart = GuestCart::where('guest_user_id', $guestUser->id)
            ->where('product_id', $request->product_id)
            ->where('product_color_id', $request->product_color_id)
            ->first();

        if ($checkCart) {
            return $this->respondError('Product already added to cart');
        } else {
            $cart = GuestCart::create([
                'guest_user_id' => $guestUser->id,
                'product_id' => $request->product_id,
                'product_color_id' => $request->product_color_id,
                'quantity' => $request->quantity,
            ]);
        }
        if ($cart) {
            return $this->respondWithSuccess(['message' => 'Product added to cart']);
        }

        return $this->respondError('Something went wrong.');
    }

    public function getCartProduct($guest_user_id)
    {
        $guest_user = GuestUser::where('uuid', $guest_user_id)->first();
        $guestCart = GuestCart::wherehas('productColor', function ($q) {
            $q->where('stock', '>', 0);
        })->with(['product'])->where('guest_user_id', $guest_user->id)->get();
//        $result_date = GuestCartResource::collection($guestCart);
        if ($guestCart) {
            return $this->respondWithSuccess([
                'data' => CartResource::collection($guestCart),
//                'total_price' => collect($result_date)->sum("total")
            ]);
        }

        return $this->respondError('Something went wrong.');
    }

    public function getSelectedCartProduct($guest_user_id)
    {
        $guest_user = GuestUser::where('uuid', $guest_user_id)->first();
        $cart = GuestCart::wherehas('productColor', function ($q) {
            $q->where('stock', '>', 0);
        })->where('guest_user_id', $guest_user->id)->with('product')->where('status', '1')->get();
        $result_date = GuestCartResource::collection($cart);
        return $this->respondWithSuccess([
//            'data' => CartResource::collection($cart),
            'data' => $result_date,
            'total_price' => collect($result_date)->sum("total")
        ]);
    }

    public function updateCart(Request $request)
    {
        try{
            $guest_user = GuestUser::where('uuid', $request->guest_user_id)->first();
            $cart = GuestCart::where('id', $request->cart_id)->where('guest_user_id', $guest_user->id)->first();
            if ($cart) {
                $cart->status = $request->status ;
                $cart->quantity = $request->quantity;
                $cart->save();
            }
            return $this->respondWithSuccess([
                'message' => 'Product updated in cart successfully',
            ]);
        }catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function removeProductFromCart(Request $request)
    {
        $guest_user = GuestUser::where('uuid', $request->guest_user_id)->first();
        $cart = GuestCart::where('id', $request->cart_id)->where('guest_user_id', $guest_user->id)->first();
        if ($cart) {
            $cart->delete();
            return $this->respondWithSuccess([
                'message' => 'Product removed from cart successfully',
            ]);
        } else {
            return $this->respondError('Product not found in cart');
        }
    }

    public function createGuestUser(Request $request)
    {
        $guestUser = GuestUser::create([
            'uuid' => $request->uuid,
        ]);
        if ($guestUser) {
            return $this->respondWithSuccess(['message' => 'Guest user created successfully']);
        } else {
            return $this->respondError('Something went wrong');
        }
    }
}
