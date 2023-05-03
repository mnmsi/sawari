<?php

    namespace Modules\Api\Http\Traits\Product;

    use App\Models\User\UserWishlist;

    trait WIshListTrait
    {
        public function wishListStore($request)
        {
            $wishlist = UserWishlist::where('user_id', auth()->user()->id)
                ->where('product_id', $request->product_id)
                ->first();
            if ($wishlist) {
                return $wishlist->delete();
            } else {
                return UserWishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $request->product_id,
                ]);
            }
        }
    }
