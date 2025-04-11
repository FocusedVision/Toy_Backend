<?php

namespace App\Repositories;

use App\Enums;
use App\Models;

class ProductEventRepository
{
    public function createProductOpenedEvent(Models\User $user, Models\Product $product): Models\ProductEvent
    {
        return Models\ProductEvent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => Enums\ProductEvent::OPENED,
        ]);
    }

    public function createProductModelLoadedEvent(Models\User $user, Models\Product $product): Models\ProductEvent
    {
        return Models\ProductEvent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => Enums\ProductEvent::MODEL_LOADED,
        ]);
    }

    public function createProductAnimationPlayedEvent(Models\User $user, Models\Product $product): Models\ProductEvent
    {
        return Models\ProductEvent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => Enums\ProductEvent::ANIMATION_PLAYED,
        ]);
    }

    public function createProductFullAnimationPlayedEvent(Models\User $user, Models\Product $product): Models\ProductEvent
    {
        return Models\ProductEvent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => Enums\ProductEvent::FULL_ANIMATION_PLAYED,
        ]);
    }

    public function createProductWishlistAddedEvent(Models\User $user, Models\Product $product): Models\ProductEvent
    {
        return Models\ProductEvent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => Enums\ProductEvent::WISHLIST_ADDED,
        ]);
    }

    public function createProductLikeAddedEvent(Models\User $user, Models\Product $product): Models\ProductEvent
    {
        return Models\ProductEvent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => Enums\ProductEvent::LIKE_ADDED,
        ]);
    }

    public function createProductOpenTimeSecondsEvent(Models\User $user, Models\Product $product, int $seconds): Models\ProductEvent
    {
        return Models\ProductEvent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => Enums\ProductEvent::OPEN_TIME_SECONDS,
            'seconds' => $seconds,
        ]);
    }
}
