<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require_once(__DIR__.'/auth.php');
require_once(__DIR__.'/admin.php');
