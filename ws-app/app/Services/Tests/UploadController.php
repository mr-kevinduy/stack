<?php

namespace App\Services\Tests;

class UploadController
{
    public function upload($request)
    {
        $uploader = UploaderFactory::make($request->input('upload_type'));

        $videoProcessor = new VideoProcessingFacade(
            $uploader,
            new AwsTranscoder(),
            new FFmpegTranscoder()
        );

        $result = $videoProcessor->process(
            $request->file('video'),
            $request->input('transcode_service')
        );

        return response()->json(['result' => $result]);
    }
}
