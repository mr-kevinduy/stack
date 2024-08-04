<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected ?string $as;
    protected ?string $resource;

    protected function view(?string $path, array $data = [])
    {
        $viewPath = [];

        if (! empty($this->as)) {
            $viewPath[] = $this->as;
        }

        if (! empty($this->resource)) {
            $viewPath[] = $this->resource;
        }

        return view(implode('.', array_merge($viewPath, [$path])), $data);
    }
}
