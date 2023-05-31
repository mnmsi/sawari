<?php

namespace App\Nova;

use App\Models\System\HomePageSection;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class HomeSection extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<HomePageSection>
     */
    public static $model = HomePageSection::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'section_title';
    public static $group = 'Custom Home Section';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'section_title'
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
//            title
            Text::make('Section Title', 'section_title')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter title',
                    ],
                ]),
//            sub title
            Text::make('Section Subtitle', 'section_subtitle')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter sub-title',
                    ],
                ]),
//            order
            Number::make('Order', 'section_order')
                ->min(0)
                ->step('any')
                ->rules('required'),
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
        return [];
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
}
