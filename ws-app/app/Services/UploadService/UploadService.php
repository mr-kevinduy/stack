<?php

namespace App\Services\UploadService;

interface UploadService
{
    public function upload($file): string;
}
