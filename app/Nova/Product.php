<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
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
                ->rules('required')
                ->disableDownload(),
//            badge
            Image::make('Badge Image', 'badge_url')
                ->path('product_badge')
                ->disk('public')
                ->nullable()
                ->disableDownload(),
//            bike body type
            BelongsTo::make('Body Type', 'bodyType')
                ->nullable()
                ->noPeeking(),
//              type
            Select::make('Type', 'type')->options([
                'bike' => 'Bike',
                'accessory' => 'Accessory',
            ])->rules('required'),
//            category
            BelongsTo::make('Category', 'category')
                ->nullable()
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
                ->rules('required')
                ->min(0)
                ->step('any')
                ->nullable(),
//            shipping charge
            Number::make('Shipping charge', 'shipping_charge')
                ->min(0)
                ->step('any')
                ->rules('required'),
//            total stock
            Number::make('Total stock', 'total_stock')
                ->min(0)
                ->rules('required'),
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
                    return $v ? "Active" : "Inactive";
                }),
//              short description
            Textarea::make('Short description','short_description')
                ->sortable()
                ->nullable()
                ->rows(2)
                ->alwaysShow(),
//            description
            Textarea::make('Description','description')
                ->sortable()
                ->rules('required')
                ->rows(4)
                ->alwaysShow(),
//            date
            DateTime::make('Created At', 'created_at')
                ->hideFromIndex()
                ->default(now())
                ->hideWhenUpdating(),

            DateTime::make('Updated At', 'updated_at')
                ->hideFromIndex()
                ->hideWhenCreating()
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
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
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
