<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Web\WebController;

abstract class FrontController extends WebController
{
    public function __construct()
    {
        $this->as = front_as();
    }
}
