<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationCard extends Component
{

    public $notification;

    public function render()
    {
        $this->notification = DatabaseNotification::where('notifiable_type', 'App\Models\User')->where('notifiable_id', Auth::user()->id)->where('seen', 0)->first();

        if (!empty($this->notification)) {
            $this->notification->seen = true;
            $this->notification->save();
        }

        return view('livewire.notification-card');
    }
}
