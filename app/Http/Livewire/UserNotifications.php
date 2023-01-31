<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserNotifications extends Component
{

    public $user;

    public function render()
    {
        $this->user = User::find(Auth::user()->id);
        return view('livewire.user-notifications');
    }
}
