<?php

namespace App\Services\DTO\User;

use App\Enums;
use Spatie\LaravelData\Data;

class UpdateData extends Data
{
    public ?string $name;

    public ?Enums\UserAvatar $image;

    public function getFillable(): array
    {
        $fillable = [];

        if ($this->name !== null) {
            $fillable['name'] = $this->name;
        }

        if ($this->image !== null) {
            $fillable['image'] = $this->image->relativeUrl();
        }

        return $fillable;
    }
}
