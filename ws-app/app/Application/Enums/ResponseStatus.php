<?php

namespace App\Application\Enums;

enum ResponseStatus: int
{
    case FAIL = 0;
    case SUCCESS = 1;
    case START = 2;
    case INPROCESS = 3;
    case DONE = 4;
}
