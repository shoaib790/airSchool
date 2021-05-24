<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Jobs\ConvertVideoForStreaming;
use App\Video;
use Illuminate\Http\Request;


class VideoController extends Controller
{
    public function getVideos()
    {
        $videos = Video::orderBy('created_at', 'DESC')->get();

        return view('video/index',compact('videos'));
    }


    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video'       => 'required|mimes:mp4',
        ]);


        $video = Video::create([
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $request->video->store('videos', 'public'),
        ]);

        $this->dispatch(new ConvertVideoForStreaming($video));

        return redirect('/');
    }
}
