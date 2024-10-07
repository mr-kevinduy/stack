<?php

namespace App\Http\Controllers\Web\MyPage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class VideoController extends MyPageController
{
    protected ?string $resource = 'videos';

    public function index()
    {
        $compact = [];

        // return redirect()->route($this->routeName('upload.index'), $compact);
        return $this->view('index', $compact);
    }
}
