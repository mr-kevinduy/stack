<?php

namespace App\Modules\VideoProcessing;

abstract class TranscodeHandler
{
    protected $nexthandler;

    public function setNext(TranscodeHandler $handler): TranscodeHandler
    {
        $this->nexthandler = $handler;

        return $handler;
    }

    public function handle($filePath, $service)
    {
        if ($this->nexthandler) {
            return $this->nexthandler->handle($filePath, $service);
        }
    }
}
