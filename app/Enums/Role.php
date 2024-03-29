<?php

namespace App\Enums;

enum Role: int
{
    case ADMIN=1;
    case PERSONAL=2;
    case CUSTOMERS=3;
}
