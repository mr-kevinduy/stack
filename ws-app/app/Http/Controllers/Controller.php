<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as AbstractController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends AbstractController
{
    use AuthorizesRequests, ValidatesRequests;

    protected ?string $as;

    protected ?string $resource;

    protected function view(?string $path = null, array $data = [])
    {
        $viewPath = [];

        if (! empty($this->as)) {
            $viewPath[] = $this->as;
        }

        if (! empty($this->resource)) {
            $viewPath[] = $this->resource;
        }

        if (! empty($path)) {
            $viewPath[] = $path;
        }

        return view(implode('.', $viewPath), $data);
    }
}
