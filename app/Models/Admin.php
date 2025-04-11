<?php

namespace App\Models;

use App\Enums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => Enums\AdminRole::class,
    ];

    protected $attributes = [
        'role' => Enums\AdminRole::VIEWER,
    ];

    public function isViewer()
    {
        return $this->role->value >= Enums\AdminRole::VIEWER->value;
    }

    public function isEditor()
    {
        return $this->role->value >= Enums\AdminRole::EDITOR->value;
    }

    public function isModerator()
    {
        return $this->role->value >= Enums\AdminRole::MODERATOR->value;
    }
}
