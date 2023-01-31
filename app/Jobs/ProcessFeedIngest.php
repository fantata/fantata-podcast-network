<?php

namespace App\Jobs;

use App\Models\Show;
use App\Models\User;
use App\Models\Episode;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\FeedIngestComplete;
use Vedmant\FeedReader\Facades\FeedReader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessFeedIngest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $feed_url, $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($feed_url, $user_id)
    {
        $this->feed_url = $feed_url;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $f = FeedReader::read($this->feed_url);

        // iTunes namespace attributes
        $subtitle   = $f->get_channel_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'subtitle');
        $owner      = $f->get_channel_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'owner');
        $explicit   = $f->get_channel_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'explicit');
        $category   = $f->get_channel_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'category');
        $ch_image   = $f->get_channel_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'image');
        $ch_image   = array_shift($ch_image[0]['attribs'])['href'];

        $email      = $owner[0]['child']['http://www.itunes.com/dtds/podcast-1.0.dtd']['email'];
        $category   = Category::where('name', array_shift($category[0]['attribs'])['text'])->first();

        $vals = [
            'title'         => $f->get_title(),
            'description'   => $f->get_description(),
            'subtitle'      => $subtitle[0]['data'],
            'email'         => $email[0]['data'],
            'explicit'      => $explicit[0]['data'] == 'yes' ? 1 : 0,
            'category_id'   => $category->id,
            'user_id'       => $this->user_id,
            'status'        => Show::STATUS_IMPORTING
        ];
        $show = Show::create($vals);

        foreach ($f->get_items() as $item) {
            // iTunes namespace attributes
            $duration = $item->get_item_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'duration');
            $explicit = $item->get_item_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'explicit');
            $subtitle = $item->get_item_tags('http://www.itunes.com/dtds/podcast-1.0.dtd', 'subtitle');

            // get mp3
            $enclosure = $item->get_enclosure();

            $vals = [
                'title'         => $item->get_title(),
                'description'   => $item->get_description(),
                'pub_date'      => date('Y-m-d H:i:s',strtotime($item->get_date())),
                'duration'      => $duration[0]['data'],
                'explicit'      => $explicit[0]['data'] == 'yes' ? 1 : 0,
                'subtitle'      => $subtitle[0]['data'],
                'show_id'       => $show->id,
                'bytes'         => $enclosure->length,
                'status'        => Episode::STATUS_IMPORTING
            ];

            $episode = Episode::create($vals);

            // download and store media
            $contents = file_get_contents($enclosure->link);
            Storage::disk('episodes-src')->put($episode->id . '.mp3', $contents);

            $contents = file_get_contents($ch_image);
            Storage::disk('show-img')->put($episode->id . '.jpg', $contents);

            $contents = file_get_contents($item_image);
            Storage::disk('episode-img')->put($episode->id . '.jpg', $contents);

            $episode->status = Episode::STATUS_ACTIVE;

        }

        $show->status = Show::STATUS_DRAFT;
        $show->save();

        $user = User::find($this->user_id);

        $user->notify(new FeedIngestComplete($show->id));

    }
}
