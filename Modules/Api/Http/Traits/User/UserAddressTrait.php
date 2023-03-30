<?php

namespace Modules\Api\Http\Traits\User;

use Illuminate\Support\Facades\Auth;

trait UserAddressTrait
{
    /**
     * @return mixed
     */
    public function getAddresses()
    {
        return Auth::user()->addresses;
    }

    /**
     * @return mixed
     */
    public function storeAddress($data)
    {
        return Auth::user()
                   ->addresses()
                   ->create($data);
    }

    /**
     * @return mixed
     */
    public function updateAddress($id, $data)
    {
        return Auth::user()
                   ->addresses()
                   ->where('id', $id)
                   ->update($data);
    }
}
