<?php

namespace App\Models;

use App\Enums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_type',
        'is_enabled',
    ];

    protected $casts = [
        'notification_type' => Enums\NotificationType::class,
        'is_enabled' => 'boolean',
    ];
}
