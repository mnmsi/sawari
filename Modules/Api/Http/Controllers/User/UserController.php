<?php

namespace Modules\Api\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        // Return response with user data
        return $this->respondWithSuccessWithData(Auth::user());
    }
}
