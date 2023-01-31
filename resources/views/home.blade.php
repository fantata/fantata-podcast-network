<x-guest-layout>


        <h2 class='text-gray-200 mx-4 my-6 text-2xl font-bold'>Latest Episodes</h2>

        @foreach($latest_episodes as $ep)

            <div class="m-4">

                <x-laravel-audio-player
                    audioUrl="/dummy.mp3"
                    imgUrl="https://podnews.net/cache/r/t/396/267354-52bfbc79.webp"
                    :epId="$ep->id"
                    :epTitle="$ep->title"
                    :epDate="$ep->pub_date"
                    :showTitle="$ep->show->title"
                />

            </div>

        @endforeach


</x-guest-layout>