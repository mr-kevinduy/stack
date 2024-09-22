<?php

namespace App\Modules\VideoProcessing;

class FFmpegTranscodeHandler extends TranscodeHandler
{
    public function handle($filePath, $service)
    {
        if ($service === 'ffmpeg') {
            return $this->transcodeWithFFmpeg($filePath);
        }

        return parent::handle($filePath, $service);
    }

    private function transcodeWithFFmpeg($filePath)
    {
        // Logic FFmpeg transcode.
    }
}
