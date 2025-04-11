<?php

namespace App\Services\User;

use App\Enums;
use App\Models;
use App\Repositories\ProductRepository;
use App\Repositories\PushTokenRepository;
use App\Repositories\UserRepository;
use App\Services\DTO;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        private UserRepository $user_repository,
        private ProductRepository $product_repository,
        private PushTokenRepository $push_token_repository
    ) {
    }

    public function update(Models\User $user, DTO\User\UpdateData $data): Models\User
    {
        return $this->user_repository->update(
            $user,
            $data->getFillable()
        );
    }

    public function getProducts(Models\User $user): LengthAwarePaginator
    {
        $products = $this->product_repository->getUserProductsPagination($user);

        return $products;
    }

    public function addProduct(Models\User $user, Models\Product $product): LengthAwarePaginator
    {
        $this->product_repository->addUserProduct($user, $product);

        return $this->getProducts($user);
    }

    public function deleteProduct(Models\User $user, Models\Product $product): LengthAwarePaginator
    {
        $this->product_repository->deleteUserProduct($user, $product);

        return $this->getProducts($user);
    }

    public function getAvatars(): array
    {
        return Enums\UserAvatar::all();
    }

    public function createPushToken(Models\User $user, string $token): bool
    {
        $this->push_token_repository->upsert([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        return true;
    }
}
