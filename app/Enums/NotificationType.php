<?php

namespace App\Enums;

enum NotificationType: string
{
    case HardBounce = 'HardBounce';
    case SpamNotification = 'SpamNotification';
}
