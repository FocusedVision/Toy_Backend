<?php

namespace App\Services\Product;

use App\Enums;
use App\Jobs;
use App\Models;
use App\Repositories\ProductEventRepository;
use App\Repositories\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Response;

class ProductService
{
    public function __construct(
        private ProductRepository $product_repository,
        private ProductEventRepository $product_event_repository
    ) {
    }

    public function getProducts(): LengthAwarePaginator
    {
        $products = $this->product_repository->getCreatedOrderedPagination();

        return $products;
    }

    public function getProduct(Models\Product $product): Models\Product
    {
        $product = $this->product_repository->getProductInformation($product);

        return $product;
    }

    public function addProductLike(Models\User $user, Models\Product $product): Models\Product
    {
        $this->product_repository->addProductLike($user, $product);

        return $this->getProduct($product);
    }

    public function deleteProductLike(Models\User $user, Models\Product $product): Models\Product
    {
        $this->product_repository->deleteProductLike($user, $product);

        return $this->getProduct($product);
    }

    public function handleLinkClick(string $link): void
    {
        $products = $this->product_repository->getProductsByLink($link);

        if ($products->count() > 0) {
            Jobs\Product\HandleLinkClickJob::dispatch($products);
        }
    }

    public function createProductEvent(Models\User $user, Models\Product $product, Enums\ProductEvent $event, int $seconds = null): Models\ProductEvent|bool
    {
        abort_if(
            $event === Enums\ProductEvent::OPEN_TIME_SECONDS && $seconds === null,
            Response::INTERNAL_ERROR,
            __('Product open time seconds event must be provided with seconds')
        );

        return match ($event) {
            Enums\ProductEvent::OPENED => $this->product_event_repository->createProductOpenedEvent($user, $product),
            Enums\ProductEvent::MODEL_LOADED => $this->product_event_repository->createProductModelLoadedEvent($user, $product),
            Enums\ProductEvent::ANIMATION_PLAYED => $this->product_event_repository->createProductAnimationPlayedEvent($user, $product),
            Enums\ProductEvent::FULL_ANIMATION_PLAYED => $this->product_event_repository->createProductFullAnimationPlayedEvent($user, $product),
            Enums\ProductEvent::WISHLIST_ADDED => $this->product_event_repository->createProductWishlistAddedEvent($user, $product),
            Enums\ProductEvent::LIKE_ADDED => $this->product_event_repository->createProductLikeAddedEvent($user, $product),
            Enums\ProductEvent::OPEN_TIME_SECONDS => $this->product_event_repository->createProductOpenTimeSecondsEvent($user, $product, $seconds),
            default => false
        };
    }
}
