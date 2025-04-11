<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications;
use Laravel\Sanctum\HasApiTokens;
use Storage;
use Str;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifications\RoutesNotifications;

    protected $fillable = [
        'device_id',
        'name',
        'image',
    ];

    public function generateDeviceId(): void
    {
        if ($this->device_id === null) {
            $this->device_id = (string) Str::uuid();
        }
    }

    public function publicDeviceId(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return Str::of($attributes['device_id'])->substr(-8, 8)->upper()->prepend('****');
            }
        );
    }

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                if ($this->image === null) {
                    return null;
                }

                return Storage::url($this->image);
            }
        );
    }

    public function routeNotificationForPush(Notifications\Notification $notification = null): mixed
    {
        return $this->pushTokens;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'user_products')->withTimestamps();
    }

    public function draftProductsAccessed()
    {
        return $this->belongsToMany(Product::class, 'user_product_draft_accesses')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany(Product::class, 'product_likes')->withTimestamps();
    }

    public function pushTokens()
    {
        return $this->hasMany(PushToken::class);
    }
}
