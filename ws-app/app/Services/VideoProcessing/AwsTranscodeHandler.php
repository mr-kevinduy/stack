<?php

namespace App\Modules\VideoProcessing;

class AwsTranscodeHandler extends TranscodeHandler
{
    public function handle($filePath, $service)
    {
        if ($service === 'aws') {
            return $this->transcodeWithAws($filePath);
        }

        return parent::handle($filePath, $service);
    }

    private function transcodeWithAws($filePath)
    {
        // Logic Aws transcode.
    }
}
