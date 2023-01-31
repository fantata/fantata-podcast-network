<?php

namespace App\Traits;

use App\Traits\HasEnhancedDatabaseNotifications;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Notifications\RoutesNotifications;

trait EnhancedNotifiable
{
    use HasDatabaseNotifications, RoutesNotifications, HasEnhancedDatabaseNotifications;
}
