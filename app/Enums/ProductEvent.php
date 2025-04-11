<?php

namespace App\Enums;

enum ProductEvent: int
{
    case OPENED = 0;
    case MODEL_LOADED = 1;
    case ANIMATION_PLAYED = 2;
    case FULL_ANIMATION_PLAYED = 3;
    case WISHLIST_ADDED = 4;
    case LIKE_ADDED = 5;
    case OPEN_TIME_SECONDS = 6;
}
