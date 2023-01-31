<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;


class Users extends Component
{
    public $users=[], $name, $email;
    public $showModal = false;

    public function render()
    {
        $this->users = User::all();
        return view('livewire.users');
    }

    public function goModal()
    {
        $this->showModal = true;
    }

    public function hideModal()
    {
        $this->showModal = false;
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    private function resetCreateForm()
    {
        $this->name = '';
        $this->email = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($this->user_id) {
            User::updateOrCreate(['id' => $this->user_id], [
                'name' => $this->name,
                'email' => $this->email,
            ]);
        } else {
            User::insert([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make('badger')
            ]);
        }

        session()->flash('message', $this->user_id ? 'User updated.' : 'User created.');

        $this->hideModal();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->goModal();
    }

    public function add()
    {
        $this->user_id = null;
        $this->name = null;
        $this->email = null;

        $this->goModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User deleted.');
    }
}
