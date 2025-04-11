<?php

namespace App\Nova\Uploads\Product;

use Laravel\Nova\Http\Requests\NovaRequest;

class GridImageStore
{
    public function __invoke(NovaRequest $request, $model, $attribute, $request_attribute, $disk, $storage_path)
    {
        return [
            'grid_image_url' => $request->grid_image_url->storePublicly('products/grid-images', $disk),
            'grid_image_name' => $request->grid_image_url->getClientOriginalName(),
            'grid_image_size' => $request->grid_image_url->getSize(),
        ];
    }
}
