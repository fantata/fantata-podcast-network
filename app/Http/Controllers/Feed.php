<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class Feed extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $show = Show::with('category')->find($id);
        return response()->view('feed', ['show' => $show])->header('Content-Type', 'application/xml');
    }
}
