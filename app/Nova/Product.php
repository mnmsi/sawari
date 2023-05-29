<?php

namespace App\Nova;

use App\Nova\Filters\ProductStatusFilter;
use App\Nova\Metrics\TotalProduct;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    public static $group = 'Product';
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
//            brand
            BelongsTo::make('Brand', 'brand')
                ->rules('required')
                ->noPeeking(),
//            image
            Image::make('Image', 'image_url')
                ->path('product_image')
                ->disk('public')
                ->creationRules('required')
                ->updateRules('nullable')
                ->help("*For better view pleas use image height=200,width=282")
                ->disableDownload(),
//            badge
            Image::make('Badge Image', 'badge_url')
                ->path('product_badge')
                ->disk('public')
                ->nullable()
                ->help("*For better view pleas use image height=52,width=52")
                ->disableDownload(),
            //              type
            Select::make('Type', 'type')->options([
                'bike' => 'Bike',
                'accessory' => 'Accessory',
            ])->rules('required'),

//            bike body type
            BelongsTo::make('Body Type', 'bodyType')
                ->dependsOn(['type'], function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    if ($formData->type == "bike") {
                        $field
                            ->rules('required');
                    } else {
                        $field
                            ->hideWhenCreating()
                            ->hideWhenUpdating()
                            ->hide()
                            ->nullable();
                    }
                })
                ->noPeeking(),

//            category
            BelongsTo::make('Category', 'category')
                ->dependsOn(['type'], function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    if ($formData->type == "accessory") {
                        $field
                            ->rules('required');
                    } else {
                        $field
                            ->hide()
                            ->nullable();
                    }
                })
                ->noPeeking(),
//            name
            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter name',
                    ],
                ]),
//            code
            Text::make('Product code', 'product_code')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter code',
                    ],
                ]),
//            price
            Number::make('price')
                ->min(1)
                ->step('any')
                ->rules('required'),
//            discount
            Number::make('Discount', 'discount_rate')
                ->default(0)
                ->min(0)
                ->step('any')
                ->nullable(),
//            used or not
            Select::make('Is Used', 'is_used')->options([
                '1' => 'Yes',
                '0' => 'No',
            ])->rules('required')
                ->resolveUsing(function ($value) {
                    if (!$value) {
                        return 0;
                    }
                    return 1;
                })
                ->displayUsing(function ($v) {
                    return $v ? "Used" : "New";
                }),
//            feature
            Select::make('Featured', 'is_featured')->options([
                '1' => 'Yes',
                '0' => 'No',
            ])->rules('required')
                ->resolveUsing(function ($value) {
                    if (!$value) {
                        return 0;
                    }
                    return 1;
                })
                ->displayUsing(function ($v) {
                    return $v ? "Yes" : "No";
                }),
//              status
            Select::make('Status', 'is_active')->options([
                '1' => 'Yes',
                '0' => 'No',
            ])->rules('required')
                ->resolveUsing(function ($value) {
                    if (!$value) {
                        return 0;
                    }
                    return 1;
                })
                ->displayUsing(function ($v) {
                    return $v ? "Active" : "Inactive";
                }),
//              short description
            Textarea::make('Short description', 'short_description')
                ->sortable()
                ->nullable()
                ->rows(2)
                ->alwaysShow(),
//            description
            Trix::make('Description', 'description')
                ->sortable()
                ->rules('required')
                ->alwaysShow(),
//            date
            DateTime::make('Created At', 'created_at')
                ->hideFromIndex()
                ->default(now())
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At', 'updated_at')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->default(now()),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new TotalProduct,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new ProductStatusFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
