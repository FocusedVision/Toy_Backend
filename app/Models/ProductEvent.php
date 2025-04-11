<?php

namespace App\Models;

use App\Enums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'type',
        'seconds',
    ];

    protected $casts = [
        'type' => Enums\ProductEvent::class,
    ];

    public function scopeOpened($query)
    {
        return $query->where('type', Enums\ProductEvent::OPENED);
    }

    public function scopeModelLoaded($query)
    {
        return $query->where('type', Enums\ProductEvent::MODEL_LOADED);
    }

    public function scopeAnimationPlayed($query)
    {
        return $query->where('type', Enums\ProductEvent::ANIMATION_PLAYED);
    }

    public function scopeFullAnimationPlayed($query)
    {
        return $query->where('type', Enums\ProductEvent::FULL_ANIMATION_PLAYED);
    }

    public function scopeWishlistAdded($query)
    {
        return $query->where('type', Enums\ProductEvent::WISHLIST_ADDED);
    }

    public function scopeLikeAdded($query)
    {
        return $query->where('type', Enums\ProductEvent::LIKE_ADDED);
    }

    public function scopeOpenTimeSeconds($query)
    {
        return $query->where('type', Enums\ProductEvent::OPEN_TIME_SECONDS);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
