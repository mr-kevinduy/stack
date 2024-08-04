<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

abstract class AdminController extends Controller
{
    public function __construct()
    {
        $this->as = admin_as();
    }
}
