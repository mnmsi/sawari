<?php

namespace App\Nova;

use App\Nova\Filters\ProductStatusFilter;
use App\Nova\Metrics\TotalProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableRelation;
use Outl1ne\NovaSimpleRepeatable\Row;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;

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
     * @param NovaRequest $request
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
                ->help("*For better view please use image height=52,width=52")
                ->disableDownload(),
            //              type
            Select::make('Type', 'type')->options([
                'bike'      => 'Bike',
                'accessory' => 'Accessory',
            ])->rules('required'),

            //            bike body type
            BelongsTo::make('Body Type', 'bodyType')
                ->dependsOn(['type'], function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    if ($formData->type == "bike") {
                        $field
                            ->rules('required');
                    }
                    else {
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
                    }
                    else {
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

            SimpleRepeatable::make('Product Color', 'colors', [
                Text::make('Name', 'name')
                    ->sortable()
                    ->rules('required', 'max:255')
                    ->withMeta([
                        'extraAttributes' => [
                            'placeholder' => 'Enter name',
                        ],
                    ]),

                /*Image::make('Image', 'image_url')
                    ->path('product_color')
                    ->disk('public')
                    ->creationRules('required')
                    ->updateRules('nullable')
                    ->help("*For better view pleas use image height=53,width=68")
                    ->disableDownload(),*/

                File::make("Image", 'image_url'),

                Number::make('Stock', 'stock')
                    ->min(0)
                    ->rules('required'),
            ])
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    if ($request->editMode === 'create') {
                        $model::saved(function ($model) use ($request, $requestAttribute) {
                            $data = json_decode($request->get($requestAttribute), true);
                            if ($data) {
                                foreach ($data as $key => $value) {
                                    $data[$key]['product_id'] = $model->id;
                                    $data[$key]['name']       = $value['name'];
                                    $data[$key]['image_url']  = $value['image_url'];
                                    $data[$key]['stock']      = $value['stock'];
                                }
                            }

                            $model->{$requestAttribute}()->createMany($data);
                        });
                    }
                    else {
                        $data = json_decode($request->get($requestAttribute), true);
                        if ($data) {
                            $productColors = $model->{$requestAttribute};
                            $newColors     = collect($data)->pluck('name')->toArray();
                            $prevColors    = $productColors->pluck('name')->toArray();
                            $deleteColors  = array_diff($prevColors, $newColors);
                            $productColors->whereIn('name', $deleteColors)->each(function ($item) {
                                $item->delete();
                            });

                            foreach ($data as $key => $value) {
                                if ($color = $productColors->where('name', $value['name'])->first()) {
                                    $color->update([
                                        'stock'     => $value['stock'],
                                        'image_url' => $value['image_url'],
                                    ]);
                                }
                                else {
                                    $model->{$requestAttribute}()->create([
                                        'product_id' => $model->id,
                                        'name'       => $value['name'],
                                        'stock'      => $value['stock'],
                                        'image_url'  => $value['image_url'],
                                    ]);
                                }
                            }
                        }
                    }
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
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
     * @param NovaRequest $request
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
     * @param NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function searchableColumns()
    {
        return [
            'id',
            new SearchableRelation('brand', 'name'),
            new SearchableRelation('bodyType', 'name'),
            new SearchableRelation('category', 'name'),
        ];
    }

//    public static function fill(NovaRequest $request, $model)
//    {
//        return static::fillFields(
//            $request, $model,
//            (new static($model))->creationFieldsWithoutReadonly($request)->reject(function ($field) use ($request) {
//                return in_array('ignoreOnSaving', $field->meta);
//            })
//        );
//    }
//
//    public static function afterCreate(NovaRequest $request, $model)
//    {
//        $formData = $request->only('product_color_name', 'product_stock', 'product_color_image');
//        $product_color = new ProductColor();
//        $product_color->product_id = $model->id;
//        $product_color->name = $formData['product_color_name'];
//        $product_color->image_url = $formData['product_color_image']->store('product_color', 'public');
//        $product_color->stock = $formData['product_stock'];
//        $product_color->save();
//    }
}
