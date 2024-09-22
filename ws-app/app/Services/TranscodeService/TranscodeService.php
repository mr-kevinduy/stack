<?php

namespace App\Services\TranscodeService;

interface TranscodeService
{
    public function transcode(string $input, string $output);
}
