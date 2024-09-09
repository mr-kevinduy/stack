<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Web\WebController;

abstract class AdminController extends WebController
{
    public function __construct()
    {
        $this->as = admin_as();
    }
}
