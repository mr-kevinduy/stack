<?php

namespace App\Services\TranscodeService;

use Exception;

class TranscodeServiceFactory
{
    public static function make(string $provider): TranscodeService
    {
        switch ($provider) {
            case 'aws':
                return new AwsTranscodeService();

            case 'ffmpeg':
                return new FFmpegTranscodeService();

            default:
                throw new Exception("Invalid translation provider");

        }
    }
}
