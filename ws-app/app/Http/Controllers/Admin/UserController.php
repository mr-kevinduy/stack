<?php

namespace App\Http\Controllers\Admin;

class UserController extends AdminController
{
    protected ?string $resource = 'users';

    public function index()
    {
        $compact = [];

        return $this->view('index', $compact);
    }
}
