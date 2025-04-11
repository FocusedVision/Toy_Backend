<?php

namespace App\Nova\Uploads\Product;

use Laravel\Nova\Http\Requests\NovaRequest;

class ModelStore
{
    public function __invoke(NovaRequest $request, $model, $attribute, $request_attribute, $disk, $storage_path)
    {
        return [
            'model_url' => $request->model_url->storePublicly('products/models', $disk),
            'model_name' => $request->model_url->getClientOriginalName(),
            'model_size' => $request->model_url->getSize(),
        ];
    }
}
