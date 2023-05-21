<?php

use Modules\Api\Http\Controllers\Payment\PaymentController;

Route::prefix("payment")->as("payment")->controller(PaymentController::class)->group(function () {
    Route::get('test','test');
    Route::post('success','success');
    Route::post('failure','failure');
    Route::post('cancel','cancel');
    Route::post('ipn','ipn');
});

