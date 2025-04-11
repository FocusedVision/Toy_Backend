<?php

namespace App\Nova\Uploads\Product;

use Laravel\Nova\Http\Requests\NovaRequest;

class BrandImageStore
{
    public function __invoke(NovaRequest $request, $model, $attribute, $request_attribute, $disk, $storage_path)
    {
        return [
            'brand_image_url' => $request->brand_image_url->storePublicly('products/brand-images', $disk),
            'brand_image_name' => $request->brand_image_url->getClientOriginalName(),
            'brand_image_size' => $request->brand_image_url->getSize(),
        ];
    }
}
