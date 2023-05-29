<?php

namespace App\Nova;

use App\Nova\Filters\BikeSellStatusFilter;
use App\Nova\Metrics\BikeSellRequestPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Exceptions\HelperNotSupported;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableRelation;

class BikeSellRequest extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Sell\BikeSellRequest>
     */
    public static $model = \App\Models\Sell\BikeSellRequest::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';
    public static $group = 'Sell Module';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','registration_series'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     * @throws HelperNotSupported
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
//            user
            BelongsTo::make('User', 'user')
                ->rules('required')
                ->noPeeking(),
//            city
            BelongsTo::make('City', 'city','App\Nova\Others\City')
                ->rules('required')
                ->searchable()
                ->noPeeking(),
//            area
            BelongsTo::make('Area', 'area','App\Nova\Others\Area')
                ->rules('required')
                ->searchable()
                ->noPeeking(),
//            brand
            BelongsTo::make('Bike Brand', 'brand','App\Nova\Brand')
                ->rules('required')
                ->noPeeking(),
//            sell bike
            BelongsTo::make('Bike', 'bike','App\Nova\SellBike')
                ->rules('required')
                ->noPeeking(),
//            registration year
            Text::make('Registration year', 'registration_year')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter year',
                    ],
                ]),
//            duration
            Text::make('Registration duration', 'registration_duration')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter duration',
                    ],
                ]),
//            zone
            Text::make('Registration zone', 'registration_zone')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter zone',
                    ],
                ]),
//            series
            Text::make('Registration series', 'registration_series')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter series',
                    ],
                ]),
//            color
            Text::make('Bike Color', 'color')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter color',
                    ],
                ]),
//            mile range
            Text::make('Mileage range', 'mileage_range')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter range',
                    ],
                ]),
//            from us
            Select::make('Bought from us', 'bought_from_us')->options([
                'yes' => 'Yes',
                'no' => 'No',
            ])->rules('required'),
//            owner status
            Text::make('OwnerShip', 'ownership_status')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter owner level',
                    ],
                ]),
//            Engine condition
            Text::make('Engine Condition', 'engine_condition')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter condition',
                    ],
                ]),
//            Engine condition
            Select::make('Accident History', 'accident_history')->options([
                'Has Accident History' => 'Has Accident History',
                'no' => 'No',
            ])->rules('required'),
//            image
            Text::make('Images', 'bike_image')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->asHtml(),
//            status
            Select::make('Status', 'status')->options([
                '0' => 'Pending',
                '1' => 'Accepted',
                '2' => 'Rejected',
            ])->rules('required')
                ->displayUsing(function ($v) {
                    $text = "Pending";
                    if($v == 1) $text = "Accepted";
                    if($v == 2) $text = "Rejected";
                    return $text;
                }),

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new BikeSellRequestPerDay,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new BikeSellStatusFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function searchableColumns()
    {
        return ['id', new SearchableRelation('user', 'email')];
    }
}
