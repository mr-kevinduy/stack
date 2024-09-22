<?php

namespace App\Services\UploadService;

class NormalUploadService implements UploadService
{
    public function upload($file): string
    {
        // Upload
        $filePath = $this->uploadToStorage($file);

        return $filePath;
    }

    public function uploadToStorage($file)
    {

    }
}
