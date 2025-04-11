<?php

namespace App\Http\Controllers\Api;

use App\Enums;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product as ProductRequests;
use App\Http\Resources\Pagination;
use App\Http\Resources\Product as ProductResources;
use App\Models;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Response;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $product_service
    ) {
    }

    public function getProducts(Request $request)
    {
        $result = $this->product_service->getProducts();

        $pagination = new Pagination($result, ProductResources\DefaultView::class);

        return Response::send($pagination);
    }

    public function getProduct(Request $request, Models\Product $product)
    {
        $result = $this->product_service->getProduct($product);

        return Response::send(
            $this->makeProductView($result)
        );
    }

    public function addProductLike(Request $request, Models\Product $product)
    {
        $user = $request->user();

        $result = $this->product_service->addProductLike(
            $user,
            $product
        );

        return Response::send(
            $this->makeProductView($result)
        );
    }

    public function deleteProductLike(Request $request, Models\Product $product)
    {
        $user = $request->user();

        $result = $this->product_service->deleteProductLike(
            $user,
            $product
        );

        return Response::send(
            $this->makeProductView($result)
        );
    }

    private function makeProductView(Models\Product $product)
    {
        return new ProductResources\DefaultView($product);
    }

    public function createProductEvent(ProductRequests\Event\CreateRequest $request, Models\Product $product)
    {
        $user = $request->user();

        $result = $this->product_service->createProductEvent($user, $product, Enums\ProductEvent::tryFrom($request->type), $request->seconds);

        return Response::send(true);
    }

    public function getProductInfo(Request $request, Models\Product $product)
    {
        $info_data = $product->info_data;

        return response($info_data)->header('Content-Type', 'text/html');
    }
}
