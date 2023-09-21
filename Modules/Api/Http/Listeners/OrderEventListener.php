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
        $user = $event->user;

        if ($user->phone_number) {
            match ($event->status) {
                'pending'    => $this->sendOtp($user->phone_number, "Your order has been placed!"),
                'processing' => $this->sendOtp($user->phone_number, "Your order is being processed!"),
                'completed'  => $this->sendOtp($user->phone_number, "Your order has been completed!"),
                'cancelled'  => $this->sendOtp($user->phone_number, "Your order has been cancelled!"),
                default      => null,
            };
        }

        $phoneNumbersForNotification = Notification::whereStatus(1)
            ->pluck('phone')
            ->all();

        if (count($phoneNumbersForNotification)) {
            $this->sendOtp(implode(',', $phoneNumbersForNotification), "A new order has been placed!");
        }
    }
}
