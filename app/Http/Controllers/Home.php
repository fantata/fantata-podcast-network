<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class Home extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $latest_episodes = Episode::with('show')->orderBy('created_at', 'desc')->take(5)->get();
        return response()->view('home', ['latest_episodes' => $latest_episodes]);

    }
}
