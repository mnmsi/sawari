<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\TermsCondition;

class TermsConditionController extends Controller
{
    public function terms()
    {
        $terms = TermsCondition::first();
        return response()->json([
            'status' => 200,
            'data' => $terms,
        ]);
    }
}
