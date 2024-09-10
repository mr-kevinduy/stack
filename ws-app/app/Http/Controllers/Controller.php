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
        $viewPath = $this->routeName($path);

        return view($viewPath, $data);
    }

    protected function routeName(?string $path = null)
    {
        $routePath = [];

        if (! empty($this->as)) {
            $routePath[] = $this->as;
        }

        if (! empty($this->resource)) {
            $routePath[] = $this->resource;
        }

        if (! empty($path)) {
            $routePath[] = $path;
        }

        return implode('.', $routePath);
    }

    protected function sessionKey(?string $key = 'session')
    {
        return ! empty($this->resource) ? $this->resource.'_'.$key : 'uploads_'.$key;
    }
}
