<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User as UserRequests;
use App\Http\Resources\Pagination;
use App\Http\Resources\Product as ProductResources;
use App\Http\Resources\User as UserResources;
use App\Models;
use App\Models\NotificationSetting;
use App\Services\DTO;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Response;

class UserController extends Controller
{
    public function __construct(
        private UserService $user_service
    ) {
    }

    public function getCurrentUser(Request $request)
    {
        $user = $request->user();
        $user->loadCount([
            'likes' => function ($query) {
                $query->available();
            },
            'products' => function ($query) {
                $query->available();
            },
        ]);

        return Response::send(new UserResources\DefaultView($user));
    }

    public function updateCurrentUser(UserRequests\UpdateRequest $request)
    {
        $user = $request->user();

        $data = DTO\User\UpdateData::from($request->all());

        $user = $this->user_service->update($user, $data);

        return Response::send(new UserResources\DefaultView($user));
    }

    public function getProducts(Request $request)
    {
        $user = $request->user();

        $result = $this->user_service->getProducts($user);

        $pagination = $this->makeProductsPagination($result);

        return Response::send($pagination);
    }

    public function addProduct(Request $request, Models\Product $product)
    {
        $user = $request->user();

        $result = $this->user_service->addProduct(
            $user,
            $product
        );

        $pagination = $this->makeProductsPagination($result);

        return Response::send($pagination);
    }

    public function deleteProduct(Request $request, Models\Product $product)
    {
        $user = $request->user();

        $result = $this->user_service->deleteProduct(
            $user,
            $product
        );

        $pagination = $this->makeProductsPagination($result);

        return Response::send($pagination);
    }

    private function makeProductsPagination(LengthAwarePaginator $products)
    {
        return new Pagination($products, ProductResources\DefaultView::class);
    }

    public function getAvatars()
    {
        $result = $this->user_service->getAvatars();

        return Response::send($result);
    }

    public function createPushToken(UserRequests\PushToken\CreateRequest $request)
    {
        $user = $request->user();

        $result = $this->user_service->createPushToken($user, $request->token);

        return Response::send($result);
    }

    public function getNotification(Request $request)
    {
        $settings = $request->user()->notificationSettings;
        
        if (!$settings) {
            $settings = $request->user()->notificationSettings()->create([
                'is_enabled' => true,
                'notification_type' => \App\Enums\NotificationType::NEW_PRODUCT_LIVE,
            ]);
        }

        return Response::send([
            'is_enabled' => $settings->is_enabled,
        ]);
    }

    public function updateNotification(Request $request)
    {
        $request->validate([
            'is_enabled' => 'required|boolean',
        ]);

        $settings = $request->user()->notificationSettings;
        
        if (!$settings) {
            $settings = $request->user()->notificationSettings()->create([
                'is_enabled' => $request->is_enabled,
                'notification_type' => \App\Enums\NotificationType::NEW_PRODUCT_LIVE,
            ]);
        } else {
            $settings->update([
                'is_enabled' => $request->is_enabled,
            ]);
        }

        return Response::send([
            'is_enabled' => $settings->is_enabled,
        ]);
    }

    public function getWishlistShare(Request $request)
    {
        $user = $request->user();
        $products = $user->products()
            ->available()
            ->get();
            
        $shareData = [
            'id' => $user->id,
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'external_link' => $product->external_link
                ];
            })
        ];
        
        // Generate a unique hash for this wishlist
        $hash = base64_encode(json_encode($shareData));
        
        return Response::send([
            'share_url' => config('app.url') . '/wishlist/' . $hash,
            'products_count' => $products->count()
        ]);
    }
}
