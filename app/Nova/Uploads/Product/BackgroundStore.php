<?php

namespace App\Nova\Uploads\Product;

use Laravel\Nova\Http\Requests\NovaRequest;

class BackgroundStore
{
    public function __invoke(NovaRequest $request, $model, $attribute, $request_attribute, $disk, $storage_path)
    {
        return [
            'background_url' => $request->background_url->storePublicly('products/backgrounds', $disk),
            'background_name' => $request->background_url->getClientOriginalName(),
            'background_size' => $request->background_url->getSize(),
        ];
    }
}
