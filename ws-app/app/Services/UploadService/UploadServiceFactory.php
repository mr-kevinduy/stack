<?php

namespace App\Services\UploadService;

class UploadServiceFactory
{
    public static function make(?string $type = 'normal'): UploadService
    {
        switch ($type) {
            case 'normal':
                return new NormalUploadService();
                break;

            case 'chunk':
                return new ChunkUploadService();
                break;

            default:
                throw new \Exception("Invalid upload type.");
                break;
        }
    }
}
