<?php

namespace App\Jobs;

use App\Video;
use Carbon\Carbon;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))
                            ->setKiloBitrate(500);


        $converted = $this->video->id.'/'.$this->getCleanFileName($this->video->path);

        /** converting file to m3u8 */
        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->export()
            ->toDisk($this->video->disk)
            ->inFormat($lowBitrateFormat)
            ->save($converted);

        /** updating the converted details */
        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
            'stream_path' => $converted
        ]);
    }

    private function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';
    }
}
