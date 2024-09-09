<?php

namespace App\Http\Controllers\Web\Front;

class UploadController extends FrontController
{
    protected ?string $resource = 'uploads';

    public function index()
    {
        $compact = [];

        return $this->view('index', $compact);
    }

    public function uploadVideo()
    {
        $compact = [];

        return $this->view('upload-video', $compact);
    }

    public function uploadThumbnail()
    {
        $compact = [];

        return $this->view('upload-thumbnail', $compact);
    }

    public function confirm()
    {
        $compact = [];

        return $this->view('confirm', $compact);
    }

    public function store()
    {

    }
}
