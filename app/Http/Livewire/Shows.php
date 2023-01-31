<?php

namespace App\Http\Livewire;

use App\Models\Show;
use App\Models\User;
use App\Models\Episode;
use Livewire\Component;
use App\Models\Category;
use App\Jobs\ProcessFeedIngest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\FeedIngestComplete;
use Vedmant\FeedReader\Facades\FeedReader;

class Shows extends Component
{
    public $shows = [], $title, $description, $show_id = null;
    public $showModal = false;
    public $feed = "https://feeds.soundcloud.com/users/soundcloud:users:346302839/sounds.rss";

    public function render()
    {
        $this->shows = Show::all();
        return view('livewire.shows');
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

    public function import()
    {
        $this->validate([
            'feed' => 'required'
        ]);

        // dispatch feed process job
        ProcessFeedIngest::dispatch($this->feed, Auth::id());
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($this->show_id) {
            Show::updateOrCreate(['id' => $this->show_id], [
                'title' => $this->title,
                'description' => $this->description,
            ]);
        } else {
            Show::insert([
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => Auth::id(),
                'status' => 0
            ]);
        }

        session()->flash('message', $this->show_id ? 'Show updated.' : 'Show created.');

        $this->hideModal();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $show = Show::findOrFail($id);
        $this->show_id = $id;
        $this->title = $show->title;
        $this->description = $show->description;
        $this->goModal();
    }

    public function add()
    {
        $this->show_id = null;
        $this->title = null;
        $this->description = null;
        $this->goModal();
    }

    public function delete($id)
    {
        Show::find($id)->delete();
        session()->flash('message', 'Show deleted.');
    }
}
