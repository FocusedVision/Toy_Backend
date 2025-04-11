<?php

namespace App\Repositories;

use App\Enums;
use App\Models\Product;
use App\Models\User;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function getRandomOrderedPagination(?int $per_page = 15): LengthAwarePaginator
    {
        $seed = now()->hour;

        return Product::with([
            'currentUserRelation',
            'currentUserLike',
            'brand',
            'tags',
        ])->available()->orderBy(DB::raw("RAND($seed)"))->paginate($per_page);
    }

    public function getCreatedOrderedPagination(?int $per_page = 15): LengthAwarePaginator
    {
        return Product::with([
            'currentUserRelation',
            'currentUserLike',
            'brand',
            'tags',
        ])->available()->orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getUserProductsPagination(User $user, ?int $per_page = 15): LengthAwarePaginator
    {
        return $user->products()->available()->orderByPivot('created_at', 'desc')->paginate($per_page);
    }

    public function getProductsByLink(string $link): Collection
    {
        return Product::whereExternalLink($link)->get();
    }

    public function getProductInformation(Product $product): Product
    {
        $product->load([
            'currentUserRelation',
            'currentUserLike',
            'brand',
            'tags',
        ]);

        return $product;
    }

    public function addUserProduct(User $user, Product $product): bool
    {
        try {
            $user->products()->attach($product);

            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function deleteUserProduct(User $user, Product $product): void
    {
        $user->products()->detach($product);
    }

    public function addProductLike(User $user, Product $product): bool
    {
        try {
            $product->likes()->attach($user);

            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function deleteProductLike(User $user, Product $product): void
    {
        $product->likes()->detach($user);
    }

    public function makeLive(Product $product): void
    {
        $product->status = Enums\ProductStatus::LIVE;

        if ($product->isDirty()) {
            $product->save();
        }
    }

    public function makeDraft(Product $product): void
    {
        $product->status = Enums\ProductStatus::DRAFT;

        if ($product->isDirty()) {
            $product->save();
        }
    }
}
