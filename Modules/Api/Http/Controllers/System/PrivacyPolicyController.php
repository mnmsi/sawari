<?php
    namespace Modules\Api\Http\Controllers\System;
    use App\Http\Controllers\Controller;
    use App\Models\System\PrivacyPolicy;

    class PrivacyPolicyController extends Controller{
        public function privacyPolicy()
        {
            $privacy = PrivacyPolicy::first();
            return response()->json([
                'status' => 200,
                'data' => $privacy
            ]);
        }
    }
