<?php

namespace App\Rules;

use App\Repositories;
use Illuminate\Contracts\Validation\Rule;

class ValidNameRule implements Rule
{
    private Repositories\BadWordRepository $bad_word_repository;

    public function __construct()
    {
        $this->bad_word_repository = app()->make(Repositories\BadWordRepository::class);
    }

    public function passes($attribute, $value)
    {
        $entities = $this->bad_word_repository->findLike($value);

        return $entities->count() === 0;
    }

    public function message()
    {
        return __('Invalid name');
    }
}
