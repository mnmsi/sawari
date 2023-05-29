<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Attachments\Attachment;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webparking\BelongsToDependency\BelongsToDependency;

class ProductMedia extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product\ProductMedia>
     */
    public static $model = \App\Models\Product\ProductMedia::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';
    public static $group = 'Product';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
//            product
            BelongsTo::make('Product', 'product')
                ->rules('required')
                ->noPeeking(),
//            color

            BelongsTo::make('Color', 'color', 'App\Nova\ProductColor')
                ->rules('required')
                ->noPeeking(),

//            BelongsTo::make('Color', 'color', 'App\Nova\ProductColor')
//                ->dependsOn(['product'], function (BelongsTo $field, NovaRequest $request, FormData $formData) {
//                    if ($formData->product) {
//                        $field
//                            ->show()
//                            ->rules('required');
//                    } else {
//                        $field
//                            ->hide();
//                    }
//                }),

//            type
            Select::make('Type', 'type')->options([
                'image' => 'Image',
                'video' => 'Video',
                'youtube' => 'Youtube',
            ])->rules('required'),
//            url
            File::make('Url', 'url')
                ->path('media')
                ->disk('public')
                ->dependsOn(['type'], function (File $field, NovaRequest $request, FormData $formData) {
                    if ($formData->type == "youtube") {
                        $field->hide();
                    }
                })
                ->disableDownload(),
            Text::make('Url', 'url')
                ->sortable()
                ->dependsOn(['type'], function (Text $field, NovaRequest $request, FormData $formData) {
                    if ($formData->type != "youtube") {
                        $field->hide();
                    } else {
                        $field->rules('required', 'max:255');
                    }
                })
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter active url',
                    ],
                ]),
//            thumb url
            Image::make('Thumb url', 'thumbnail_url')
                ->path('media')
                ->disk('public')
                ->dependsOn(['type'], function (Image $field, NovaRequest $request, FormData $formData) {
                    if ($formData->type === "video") {
                        $field->nullable();
                    } else {
                        $field
                            ->nullable()
                            ->hide();
                    }
                })
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter thumb url(optional)',
                    ],
                ])
                ->help("*Optional upload video thumb image.")
                ->disableDownload(),
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
