<?php

namespace App\Repositories;

use App\Models\BadWord;
use Illuminate\Support\Collection;
use Str;

class BadWordRepository
{
    public function findLike(string $string): Collection
    {
        $string = Str::lower($string);

        return BadWord::where('word', 'like', $string)->get();
    }
}
