<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SingleUpload extends Component
{
    use WithFileUploads;

    public $file;
    public $episode_id;
    protected $listeners = ['newFile' => 'uploadFile'];
    public $uploaded = false;

    public function render()
    {
        return view('livewire.single-upload');
    }

    public function uploadFile($file = null)
    {
        Storage::disk('episodes')->put($this->episode_id . '.mp3', base64_decode($file));
        $this->uploaded = true;
    }
}
