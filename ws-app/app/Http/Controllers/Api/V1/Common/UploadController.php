<?php

namespace App\Http\Controllers\Api\V1\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\V1\V1Controller;
use App\Http\Responses\ApiResponse;

class UploadController extends V1Controller
{
    /**
     * Upload service.
     */
    protected $uploadService;

    public function __construct()
    {
    }

    /**
     * Upload file to s3.
     *
     * @param  Request  $request
     * @return ApiSuccessResponse|ApiErrorResponse
     */
    public function uploadS3(Request $request)
    {
        $fileName = $request->input('filename');
        $outDir = storage_path('app/uploads/videos').'/';

        Storage::disk('s3-input')->put($fileName, file_get_contents($outDir.$fileName));

        return ApiResponse::success();
    }
}
