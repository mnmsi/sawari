<?php

namespace App\Nova;

use App\Nova\Filters\ShowroomStatusFilter;
use Laravel\Nova\Exceptions\HelperNotSupported;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Showroom extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\System\Showroom>
     */
    public static $model = \App\Models\System\Showroom::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    public static $group = 'System';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'phone'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     * @throws HelperNotSupported
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter showroom name',
                    ],
                ]),

            Text::make('Phone', 'phone')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter number',
                    ],
                ]),

            Text::make('Address', 'address')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter address',
                    ],
                ]),
            //  country
            BelongsTo::make('Country', 'country', 'App\Nova\Others\Country')
                ->searchable()
                ->rules('required'),
//            division
            BelongsTo::make('Division', 'division', 'App\Nova\Others\Division')
                ->searchable()
                ->rules('required'),
//            city
            BelongsTo::make('City', 'city', 'App\Nova\Others\City')
                ->searchable()
                ->rules('required'),
//            area
            BelongsTo::make('Area', 'area', 'App\Nova\Others\Area')
                ->searchable()
                ->rules('required'),
//            postal code
            Text::make('Postal code', 'postal_code')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter code',
                    ],
                ]),
//            image

            Text::make('Google Map Image', 'location_image_url')
                ->help("*use google map shareable iframe link")
                ->nullable()
                ->hideFromIndex()
                ->asHtml(),
//            phone
            Text::make('Support number', 'support_number')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter support number',
                    ],
                ]),
//            status
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
            //             date
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
     * @param NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
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
            new ShowroomStatusFilter,
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

    /**
     * @throws HelperNotSupported
     */
//    public function detailFields(Request $request)
//    {
//        $iframeUrl = $this->location_image_url; // Assuming your model has a field named 'iframe_url' containing the URL
//
//        return [
//            Text::make('Google Map Image', 'location_image_url')->asHtml(function () use ($iframeUrl) {
//                return '<iframe src="' . $iframeUrl . '" frameborder="0"></iframe>';
//            }),
//        ];
//    }
}
