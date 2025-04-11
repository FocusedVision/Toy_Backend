<?php

namespace App\Enums;

enum AdminRole: int
{
    case VIEWER = 0;
    case EDITOR = 1;
    case MODERATOR = 2;
}
