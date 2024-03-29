<?php

namespace App\Enums;

enum Status:int
{
    case DISABLE = 0;
    case ENABLE = 1;
    case FAILLED = 2;
}
