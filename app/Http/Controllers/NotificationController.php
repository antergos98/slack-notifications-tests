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
            case NotificationType::SpamNotification:
                SlackAlert::message(
                    sprintf('Email in payload: %s', $request->string('Email'))
                );
                break;
            default:
                // Handle default ...
                break;
        }

        return response('ok');
    }
}
