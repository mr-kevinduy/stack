<?php

namespace App\Http\Controllers\Web\MyPage;

use App\Http\Controllers\Web\WebController;

abstract class MyPageController extends WebController
{
    public function __construct()
    {
        $this->as = 'mypage';
    }
}
