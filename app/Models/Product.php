<?php

namespace App\Models;

use App\Enums;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'image_name',
        'image_size',
        'model_url',
        'model_name',
        'model_size',
        'background_url',
        'background_name',
        'background_size',
        'brand_id',
        'external_link',
        'external_link_clicks_count',
        'grid_image_url',
        'grid_image_name',
        'grid_image_size',
        'status',
        'is_y_axis_locked',
        'default_zoom_level',
        'info_data',
        'is_info_enabled',
    ];

    protected $casts = [
        'status' => Enums\ProductStatus::class,
        'is_y_axis_locked' => 'boolean',
        'is_info_enabled' => 'boolean',
    ];

    protected $attributes = [
        'status' => Enums\ProductStatus::DRAFT,
        'is_y_axis_locked' => false,
        'is_info_enabled' => false,
    ];

    public function image(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return $this->makeStorageUrl($attributes['image_url']);
            }
        );
    }

    public function background(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return $this->makeStorageUrl($attributes['background_url']);
            }
        );
    }

    public function model(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return $this->makeStorageUrl($attributes['model_url']);
            }
        );
    }

    public function gridImage(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return $this->makeStorageUrl($attributes['grid_image_url']);
            }
        );
    }

    public function brandImage(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return $this->makeStorageUrl($attributes['brand_image_url']);
            }
        );
    }

    public function isInUserProducts(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                if ($this->relationLoaded('currentUserRelation')) {
                    return ($this->currentUserRelation[0] ?? null) !== null;
                }

                return null;
            }
        );
    }

    public function isLiked(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                if ($this->relationLoaded('currentUserLike')) {
                    return ($this->currentUserLike[0] ?? null) !== null;
                }
            }
        );
    }

    public function externalLinkProxy(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                if ($this->external_link === null) {
                    return null;
                } else {
                    return route('away', [
                        'link' => base64_encode($this->external_link),
                    ]);
                }
            }
        );
    }

    public function hasInfoBlock(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return $this->info_data !== null && $this->is_info_enabled;
            }
        );
    }

    private function makeStorageUrl($value): ?string
    {
        if ($value === null) {
            return null;
        }

        return Storage::url($value);
    }

    public function scopeIsLive(Builder $query, bool $live = true)
    {
        if ($live) {
            return $query->where('status', Enums\ProductStatus::LIVE);
        } else {
            return $query->where('status', '!=', Enums\ProductStatus::LIVE);
        }
    }

    public function scopeCurrentUserHasDraftAccess(Builder $query, bool $has = true)
    {
        $user = Auth::guard('api')->user();

        if ($has) {
            return $query->whereHas('usersWithDraftAccess', function ($query) use ($user) {
                $query->where('user_id', $user?->id);
            });
        } else {
            return $query->whereHas('usersWithDraftAccess', function ($query) use ($user) {
                $query->where('user_id', '!=', $user?->id);
            });
        }
    }

    public function scopeAvailable(Builder $query, bool $available = true)
    {
        if ($available) {
            return $query->where(function ($query) {
                $query->isLive();
            })->orWhere(function ($query) {
                $query->currentUserHasDraftAccess();
            });
        } else {
            return $query->where(function ($query) {
                $query->isLive(false);
            })->where(function ($query) {
                $query->currentUserHasDraftAccess(false);
            });
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_products')->withTimestamps();
    }

    public function usersWithDraftAccess()
    {
        return $this->belongsToMany(User::class, 'user_product_draft_accesses')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'product_likes')->withTimestamps();
    }

    public function currentUserRelation()
    {
        $user = Auth::guard('api')->user();

        return $this->users()->whereUserId($user?->id);
    }

    public function currentUserLike()
    {
        $user = Auth::guard('api')->user();

        return $this->likes()->whereUserId($user?->id);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function eventOpened()
    {
        return $this->hasMany(ProductEvent::class)->where('type', Enums\ProductEvent::OPENED);
    }

    public function eventModelLoaded()
    {
        return $this->hasMany(ProductEvent::class)->where('type', Enums\ProductEvent::MODEL_LOADED);
    }

    public function eventAnimationPlayed()
    {
        return $this->hasMany(ProductEvent::class)->where('type', Enums\ProductEvent::ANIMATION_PLAYED);
    }

    public function eventFullAnimationPlayed()
    {
        return $this->hasMany(ProductEvent::class)->where('type', Enums\ProductEvent::FULL_ANIMATION_PLAYED);
    }

    public function eventWishlistAdded()
    {
        return $this->hasMany(ProductEvent::class)->where('type', Enums\ProductEvent::WISHLIST_ADDED);
    }

    public function eventLikeAdded()
    {
        return $this->hasMany(ProductEvent::class)->where('type', Enums\ProductEvent::LIKE_ADDED);
    }

    public function eventOpenTimeSeconds()
    {
        return $this->hasMany(ProductEvent::class)->where('type', Enums\ProductEvent::OPEN_TIME_SECONDS);
    }
}
