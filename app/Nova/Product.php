<?php

namespace App\Nova;

use App\Enums;
use App\Models;
use App\Nova\Fields as CustomFields;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Storage;
use Str;

class Product extends Resource
{
    public static $model = Models\Product::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static function group()
    {
        return __('Product');
    }

    public static function label()
    {
        return __('Products');
    }

    public static function singularLabel()
    {
        return __('Product');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with('tags')->withCount('likes', 'users');
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->with('tags')->withCount('likes', 'users');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Fields\Badge::make(__('Status'), 'status')->map([
                Enums\ProductStatus::LIVE->value => 'success',
                Enums\ProductStatus::DRAFT->value => 'danger',
            ])->labels([
                Enums\ProductStatus::LIVE->value => 'Live',
                Enums\ProductStatus::DRAFT->value => 'Draft',
            ])->exceptOnForms(),

            CustomFields\Enum::make(__('Status'), 'status', Enums\ProductStatus::class)
                ->rules('required')
                ->onlyOnForms()
                ->help('<b>Live</b> - the product is shown to all users, <b>Draft</b> - only to selected users'),

            Fields\BelongsTo::make(__('Brand'), 'brand', Brand::class)
                ->nullable()
                ->showCreateRelationButton()
                ->sortable()
                ->filterable(),

            Fields\URL::make(__('External link'), 'external_link')
                ->rules('nullable', 'string', 'url', 'max:255')
                ->displayUsing(function () {
                    return Str::limit($this->external_link, 25);
                }),

            Fields\Boolean::make(__('Is Y axis locked'), 'is_y_axis_locked')
                ->rules('required')
                ->sortable()
                ->filterable(),

            Fields\Number::make(__('Default zoom level'), 'default_zoom_level')
                ->rules('nullable', 'numeric', 'min:0')
                ->sortable()
                ->filterable()
                ->min(0)
                ->max(100)
                ->step(0.1),

            new Panel(__('Info block'), $this->infoFields()),

            new Panel(__('Statistics'), $this->statisticsFields()),

            Fields\Text::make(__('Tags'), function () {
                $tags = $this->tags->map(function ($tag) {
                    return $tag->name;
                })->toArray();

                if (count($tags) > 0) {
                    return Str::limit(implode(', ', $tags), 30);
                } else {
                    return null;
                }
            })->onlyOnIndex(),

            new Panel(__('Product image'), $this->imageFields()),

            new Panel(__('Background image'), $this->backgroundFields()),

            new PaneL(__('Grid background image'), $this->gridImageFields()),

            new Panel(__('Brand logo'), $this->brandImageFields()),

            new Panel(__('3D Model file'), $this->modelFields()),

            ...$this->getTimestampsFields(),

            Fields\BelongsToMany::make(__('Tags'), 'tags', Tag::class)
                ->showCreateRelationButton()
                ->filterable(),

            Fields\BelongsToMany::make(__('Users with draft access'), 'usersWithDraftAccess', User::class),
        ];
    }

    private function infoFields()
    {
        return [
            Fields\Code::make(__('Info block data'), 'info_data')
                ->language('html')
                ->rules('nullable', 'max:16777214')
                ->hideFromIndex(),

            Fields\Boolean::make(__('Is info block enabled'), 'is_info_enabled')
                ->rules('required')
                ->sortable()
                ->filterable(),
        ];
    }

    private function statisticsFields()
    {
        return [
            Fields\Number::make(__('Likes count'), 'likes_count')
                ->exceptOnForms()
                ->sortable(),

            Fields\Number::make(__('Wish lists count'), 'users_count')
                ->exceptOnForms()
                ->sortable(),

            Fields\Number::make(__('External link clicks count'), 'external_link_clicks_count')
                ->exceptOnForms()
                ->sortable(),
        ];
    }

    private function imageFields()
    {
        return [
            Fields\Image::make(__('Product image'), 'image_url')
                ->store(new Uploads\Product\ImageStore)
                ->download(function ($request, $model, $disk, $value) {
                    return Storage::disk($disk)->download($value, $model->image_name);
                })
                ->creationRules('required')
                ->deletable(false)
                ->hideFromIndex(),

            Fields\Text::make(__('Product image name'), 'image_name')
                ->onlyOnDetail(),

            Fields\Text::make(__('Product image size'), 'image_size')
                ->exceptOnForms()
                ->hideFromIndex()
                ->displayUsing(function ($value) {
                    return $this->convertFileSize($value);
                }),
        ];
    }

    private function backgroundFields()
    {
        return [
            Fields\Image::make(__('Background image'), 'background_url')
                ->nullable()
                ->store(new Uploads\Product\BackgroundStore)
                ->download(function ($request, $model, $disk, $value) {
                    return Storage::disk($disk)->download($value, $model->background_name);
                })
                ->hideFromIndex(),

            Fields\Text::make(__('Background image name'), 'background_name')
                ->nullable()
                ->onlyOnDetail(),

            Fields\Text::make(__('Background image size'), 'background_size')
                ->nullable()
                ->exceptOnForms()
                ->hideFromIndex()
                ->displayUsing(function ($value) {
                    return $this->convertFileSize($value);
                }),
        ];
    }

    private function gridImageFields()
    {
        return [
            Fields\Image::make(__('Grid background image'), 'grid_image_url')
                ->store(new Uploads\Product\GridImageStore)
                ->download(function ($request, $model, $disk, $value) {
                    return Storage::disk($disk)->download($value, $model->grid_image_name);
                })
                ->creationRules('required')
                ->deletable(false)
                ->hideFromIndex(),

            Fields\Text::make(__('Grid background image name'), 'grid_image_name')
                ->onlyOnDetail(),

            Fields\Text::make(__('Grid background image size'), 'grid_image_size')
                ->exceptOnForms()
                ->hideFromIndex()
                ->displayUsing(function ($value) {
                    return $this->convertFileSize($value);
                }),
        ];
    }

    private function brandImageFields()
    {
        return [
            Fields\Image::make(__('Brand logo'), 'brand_image_url')
                ->nullable()
                ->store(new Uploads\Product\BrandImageStore)
                ->download(function ($request, $model, $disk, $value) {
                    return Storage::disk($disk)->download($value, $model->brand_image_name);
                })
                ->deletable(false)
                ->hideFromIndex(),

            Fields\Text::make(__('Brand logo name'), 'brand_image_name')
                ->nullable()
                ->onlyOnDetail(),

            Fields\Text::make(__('Brand logo size'), 'brand_image_size')
                ->nullable()
                ->exceptOnForms()
                ->hideFromIndex()
                ->displayUsing(function ($value) {
                    return $this->convertFileSize($value);
                }),
        ];
    }

    private function modelFields()
    {
        return [
            Fields\File::make(__('3D Model file'), 'model_url')
                ->store(new Uploads\Product\ModelStore)
                ->download(function ($request, $model, $disk, $value) {
                    return Storage::disk($disk)->download($value, $model->model_name);
                })
                ->creationRules('required')
                ->deletable(false)
                ->hideFromIndex(),

            Fields\Text::make(__('3D Model file name'), 'model_name')
                ->onlyOnDetail(),

            Fields\Text::make(__('3D Model file size'), 'model_size')
                ->exceptOnForms()
                ->hideFromIndex()
                ->displayUsing(function ($value) {
                    return $this->convertFileSize($value);
                }),
        ];
    }

    private function convertFileSize($size)
    {
        if (! is_int($size) || $size == 0) {
            return '0 B';
        }

        $base = log($size, 1024);
        $suffixes = ['B', 'kB', 'MB', 'GB', 'TB'];

        return round(pow(1024, $base - floor($base)), 2).' '.$suffixes[floor($base)];
    }

    public function filters(NovaRequest $request)
    {
        return [
            Filters\Product\StatusFilter::make(),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            Actions\Product\ChangeStatusAction::make()->showInline()->canSee(function ($request) {
                if ($request instanceof ActionRequest) {
                    return true;
                }

                return $request->user()->can('update', $this->resource);
            }),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
            Metrics\Product\Trend\OpeningsTrend::make()->onlyOnDetail()->width('1/3'),
            Metrics\Product\Trend\ModelLoadingsTrend::make()->onlyOnDetail()->width('1/3'),
            Metrics\Product\Trend\AnimationPlaysTrend::make()->onlyOnDetail()->width('1/3'),

            Metrics\Product\Trend\FullAnimationPlaysTrend::make()->onlyOnDetail()->width('1/3'),
            Metrics\Product\Trend\WishlistAddingTrend::make()->onlyOnDetail()->width('1/3'),
            Metrics\Product\Trend\LikesTrend::make()->onlyOnDetail()->width('1/3'),

            Metrics\Product\Value\AverageOpenTimeValue::make()->onlyOnDetail()->width('1/2'),
            Metrics\Product\Value\MaxOpenTimeValue::make()->onlyOnDetail()->width('1/2'),
        ];
    }
}
