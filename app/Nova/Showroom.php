<?php

namespace App\Nova;

use App\Models\System\Area;
use App\Models\System\City;
use App\Models\System\Country;
use App\Models\System\Division;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Showroom extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Showroom>
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
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
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
            Select::make('Country', 'country_id')->options(
                Country::pluck('name', 'id')
            )->rules('required')
                ->searchable()
                ->displayUsingLabels(),
//            division
            Select::make('Division', 'division_id')->options(
                Division::pluck('name', 'id')
            )->rules('required')
                ->searchable()
                ->displayUsingLabels(),
//            city
            Select::make('City', 'city_id')->options(
                City::pluck('name', 'id')
            )->rules('required')
                ->searchable()
                ->displayUsingLabels(),
//            area
            Select::make('Area', 'area_id')->options(
                Area::pluck('name', 'id')
            )->rules('required')
                ->searchable()
                ->displayUsingLabels(),
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
            Image::make('Google Map Image', 'location_image_url')
                ->help("*For better view use image height=225, width=500")
                ->disk('public')
                ->nullable()
                ->disableDownload(),
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
