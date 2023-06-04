<?php

namespace Modules\Api\Http\Listeners;

use App\Models\System\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Api\Http\Traits\OTP\OtpTrait;

class OrderEventListener implements ShouldQueue
{
    use InteractsWithQueue, OtpTrait;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $phoneNumbersForNotification = Notification::whereStatus(1)
            ->pluck('phone')
            ->all();

        if (count($phoneNumbersForNotification)) {
            $this->sendOtp(implode(',', $phoneNumbersForNotification));
        }
    }
}
