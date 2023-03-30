<?php

namespace Modules\Api\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Api\Http\Requests\User\UserAddressRequest;
use Modules\Api\Http\Resources\User\UserAddressResource;
use Modules\Api\Http\Resources\User\UserResource;
use Modules\Api\Http\Traits\User\UserAddressTrait;

class UserAddressController extends Controller
{
    use UserAddressTrait;

    /**
     * @return JsonResponse
     */
    public function addresses()
    {
        // Return response with user addresses
        return $this->respondWithSuccessWithData(
            UserAddressResource::collection($this->getAddresses())
        );
    }

    /**
     * @return JsonResponse
     */
    public function store(UserAddressRequest $request)
    {
        // Store new address
        $address = $this->storeAddress($request->validated());

        // Return response with user addresses
        return $this->respondWithSuccessWithData(
            UserAddressResource::collection($this->getAddresses())
        );
    }

    /**
     * @return JsonResponse
     */
    public function update(UserAddressRequest $request, $id)
    {
        // Update address
        $address = $this->updateAddress($id, $request->validated());

        // Return response with user addresses
        return $this->respondWithSuccessWithData(
            UserAddressResource::collection($this->getAddresses())
        );
    }
}
