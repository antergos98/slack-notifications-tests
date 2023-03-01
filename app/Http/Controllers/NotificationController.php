<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Requests\NotificationRequest;
use Spatie\SlackAlerts\Facades\SlackAlert;

class NotificationController
{
    public function __invoke(NotificationRequest $request)
    {
        switch($request->enum('Type', NotificationType::class)) {
            case NotificationType::HardBounce:
                // Handle hard bounce...
                break;
            case NotificationType::SpamNotification:
                SlackAlert::message(
                    sprintf('Spam triggered by %s', $request->string('Email'))
                );
        }

        return response('ok');
    }
}
