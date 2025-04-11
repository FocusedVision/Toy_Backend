<?php

namespace App\Nova\Uploads\Product;

use Laravel\Nova\Http\Requests\NovaRequest;

class ImageStore
{
    public function __invoke(NovaRequest $request, $model, $attribute, $request_attribute, $disk, $storage_path)
    {
        return [
            'image_url' => $request->image_url->storePublicly('products/images', $disk),
            'image_name' => $request->image_url->getClientOriginalName(),
            'image_size' => $request->image_url->getSize(),
        ];
    }
}
