<?php

namespace App\Domain\Enums\Roles;

enum Roles: int
{
    case admin = 1;
    case employee = 2;
    case user = 3;
}
