<?php

namespace App\Enums;

use Storage;

enum UserAvatar: string
{
    case BOY_0 = 'boy.svg';
    case BOY_1 = 'boy-1.svg';
    case BOY_2 = 'boy-2.svg';
    case BOY_3 = 'boy-3.svg';
    case BOY_4 = 'boy-4.svg';
    case BOY_5 = 'boy-5.svg';
    case BOY_6 = 'boy-6.svg';
    case BOY_7 = 'boy-7.svg';
    case BOY_8 = 'boy-8.svg';
    case BOY_9 = 'boy-9.svg';
    case BOY_10 = 'boy-10.svg';
    case BOY_11 = 'boy-11.svg';
    case BOY_12 = 'boy-12.svg';
    case BOY_13 = 'boy-13.svg';
    case BOY_14 = 'boy-14.svg';
    case BOY_15 = 'boy-15.svg';
    case BOY_16 = 'boy-16.svg';
    case BOY_17 = 'boy-17.svg';
    case BOY_18 = 'boy-18.svg';
    case BOY_19 = 'boy-19.svg';
    case BOY_20 = 'boy-20.svg';
    case BOY_21 = 'boy-21.svg';
    case BOY_22 = 'boy-22.svg';

    case GIRL_0 = 'girl.svg';
    case GIRL_1 = 'girl-1.svg';
    case GIRL_2 = 'girl-2.svg';
    case GIRL_3 = 'girl-3.svg';
    case GIRL_4 = 'girl-4.svg';
    case GIRL_5 = 'girl-5.svg';
    case GIRL_6 = 'girl-6.svg';
    case GIRL_7 = 'girl-7.svg';
    case GIRL_8 = 'girl-8.svg';
    case GIRL_9 = 'girl-9.svg';
    case GIRL_10 = 'girl-10.svg';
    case GIRL_11 = 'girl-11.svg';
    case GIRL_12 = 'girl-12.svg';
    case GIRL_13 = 'girl-13.svg';
    case GIRL_14 = 'girl-14.svg';
    case GIRL_15 = 'girl-15.svg';
    case GIRL_16 = 'girl-16.svg';
    case GIRL_17 = 'girl-17.svg';
    case GIRL_18 = 'girl-18.svg';
    case GIRL_19 = 'girl-19.svg';
    case GIRL_20 = 'girl-20.svg';
    case GIRL_21 = 'girl-21.svg';
    case GIRL_22 = 'girl-22.svg';
    case GIRL_23 = 'girl-23.svg';
    case GIRL_24 = 'girl-24.svg';
    case GIRL_25 = 'girl-25.svg';
    case GIRL_26 = 'girl-26.svg';

    public function relativeUrl(): string
    {
        return 'avatars/'.$this->value;
    }

    public function absoluteUrl(): string
    {
        return Storage::url($this->relativeUrl());
    }

    public static function all(): array
    {
        $items = [];

        $collection = cache()->rememberForever('avatars', function () {
            return collect(self::cases())->shuffle();
        });

        foreach ($collection as $item) {
            $items[] = [
                'key' => $item->value,
                'url' => $item->absoluteUrl(),
            ];
        }

        return $items;
    }
}
