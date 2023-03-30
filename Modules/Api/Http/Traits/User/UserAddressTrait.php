<?php

namespace Modules\Api\Http\Traits\User;

use Illuminate\Support\Facades\Auth;

trait UserAddressTrait
{
    public function getAddresses()
    {
        return Auth::user()->addresses;
    }
}
