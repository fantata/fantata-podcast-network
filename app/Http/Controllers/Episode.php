<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class Episode extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $file = storage_path() . '/app/episodes-src/' . $id . '.mp3';
        $mime_type = "audio/mpeg";
        $headers = array(
            'Accept-Ranges: 0-' . (filesize($file) -1) ,
            'Content-Length:'.filesize($file),
            'Content-Type:' . $mime_type,
            'Content-Disposition: inline; filename="'.$id.'".mp3'

        );
        $fileContents = File::get($file);
        return Response::make($fileContents, 200, $headers);
    }
}
