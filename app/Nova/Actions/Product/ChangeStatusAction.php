<?php

namespace App\Nova\Actions\Product;

use App\Enums;
use App\Repositories;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ChangeStatusAction extends Action
{
    use InteractsWithQueue, Queueable;

    public function name()
    {
        return __('Change status');
    }

    public function handle(Fields\ActionFields $fields, Collection $models)
    {
        $product_repository = new Repositories\ProductRepository();

        $status = Enums\ProductStatus::tryFrom($fields->status);

        foreach ($models as $model) {
            if ($status === Enums\ProductStatus::DRAFT) {
                $product_repository->makeDraft($model);
            } elseif ($status === Enums\ProductStatus::LIVE) {
                $product_repository->makeLive($model);
            }
        }
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Fields\Select::make(__('Status'), 'status')
                ->options([
                    Enums\ProductStatus::DRAFT->value => __('Draft'),
                    Enums\ProductStatus::LIVE->value => __('Live'),
                ])
                ->displayUsingLabels()
                ->rules('required'),
        ];
    }
}
