<?php

use Modules\Api\Http\Controllers\Payment\PaymentController;

Route::prefix("payment")->as("payment")->controller(PaymentController::class)->group(function () {
    Route::get('test','test')->name('.test');
    Route::get('success','success')->name('.success');
    Route::get('failure','failure')->name('.failure');
    Route::get('cancel','cancel')->name('.cancel');
    Route::get('ipn','ipn')->name('.ipn');
});

