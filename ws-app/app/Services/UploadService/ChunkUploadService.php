<?php

namespace App\Services\UploadService;

class ChunkUploadService implements UploadService
{
    public function upload($file): string
    {
        // Upload
        $filePath = $this->processChunkUpload($file);

        return $filePath;
    }

    public function processChunkUpload($file)
    {

    }
}
