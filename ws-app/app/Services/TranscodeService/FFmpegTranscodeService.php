<?php

namespace App\Services\TranscodeService;

/**
 * FFmpeg Transcoder Service.
 */
class FFmpegTranscodeService extends AbstractTranscodeService implements TranscodeService
{
    protected $client;

    public function __construct()
    {
        $this->client = ElasticTranscoderClient::factory([
            'profile' => '<profile in your aws credentials file>',
            'region'  => '<region name>',
        ]);
    }

    public function transcode()
    {

    }

    public function createJob(array $options)
    {
        $this->client->createJob($options);
    }

    public function getJob(string $jobId)
    {
        return $this->client->readJob([
            'Id' => $jobId,
        ]);
    }

    public function cancelJob(string $jobId)
    {
        return $this->client->cancelJob([
            'Id' => $jobId,
        ]);
    }
}
