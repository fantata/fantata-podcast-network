<?php

namespace App\Traits;

trait HasEnhancedDatabaseNotifications
{
    /**
     * Get the entity's unseennotifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function unseenNotifications()
    {
        return $this->notifications()->unseen();
    }
}
