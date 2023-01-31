<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use App\Models\Episode;
use App\Models\Show;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Episodes extends Component
{

    use WithFileUploads;

    public $show, $episodes = [], $title, $description, $file, $episode_id;
    public $showModal = false;

    public function mount($id)
    {
        $this->show = Show::find($id);
        $this->episodes = Episode::where('show_id', $id)->get();
    }

    public function render()
    {
        return view('livewire.episodes');
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
        $this->title = '';
        $this->description = '';
    }

    public function store()
    {

        $this->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($this->episode) {
            $ep = Episode::updateOrCreate(['id' => $this->episode_id], [
                'title' => $this->title,
                'description' => $this->description
            ]);
        } else {
            $ep = Episode::insert([
                'title' => $this->title,
                'description' => $this->description,
                'show_id' => $this->show->id
            ]);
        }

        session()->flash('message', $this->episode_id ? 'Episode updated.' : 'Episode created.');

        $this->hideModal();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $episode = Episode::findOrFail($id);
        $this->episode_id = $id;
        $this->title = $episode->title;
        $this->description = $episode->description;
        $this->goModal();
    }

    public function add()
    {
        $this->episode_id = null;
        $this->title = null;
        $this->description = null;
        $this->goModal();
    }

    public function delete($id)
    {
        Episode::find($id)->delete();
        session()->flash('message', 'Episode deleted.');
    }
}
