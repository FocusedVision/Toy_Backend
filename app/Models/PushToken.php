<?php

namespace App\Models;

use App\Facades\CloudMessaging\Contracts\RecipientContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushToken extends Model implements RecipientContract
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'failures_count',
    ];

    public function getDestination(): string
    {
        return $this->token;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
