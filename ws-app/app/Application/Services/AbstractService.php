<?php

namespace App\Application\Services;

abstract class AbstractService
{
    public function __construct(protected $repository = null) {}
}
