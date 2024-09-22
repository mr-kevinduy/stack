<?php

namespace App\Services\VideoProcessing;

use App\Services\UploadService\UploadService;
use App\Services\TranscodeService\TranscodeService;

class VideoProcessingFacade
{
    protected $uploadService;
    protected $transcodeService;

    public function __construct(
        UploadService $uploadService,
        TranscodeService $transcodeService
    )
    {
        $this->uploadService = $uploadService;
        $this->transcodeService = $transcodeService;
    }

    public function process($file, ?string $transcodeType = 'aws')
    {
        $filePath = $this->uploadService->upload($file);

        if ($transcodeType === 'aws') {
            $this->transcodeService->transcode($filePath);
        } elseif ($transcodeType === 'ffmpeg') {
            $this->transcodeService->transcode($filePath);
        } else {
            throw new \Exception("Invalid transcode service.")
        }
    }
}
