<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class SeoSetting extends Resource
{
    public static function authorizedToViewAny(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Check if the authenticated user's ID is 2
        if ($user && $user->role_id === 3) {
            return false; // Hide the resource
        }

        return true; // Allow all other users to view the resource
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\System\SeoSetting>
     */
    public static $model = \App\Models\System\SeoSetting::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'page_title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'page_title'
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
//            page title
            Text::make('Page Tile', 'page_title')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter page title',
                    ],
                ]),
//          page description
            Text::make('Page Description', 'page_description')
                ->sortable()
                ->rules('required')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter description',
                    ],
                ]),
//            page keywords
            Text::make('Page Keywords', 'page_keywords')
                ->sortable()
                ->rules('required')
                ->help("use coma between words for SEO purpose.")
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter seo keywords',
                    ],
                ]),
//            page url
            Text::make('Page url', 'page_url')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter url',
                    ],
                ]),
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

    public static function searchable()
    {
        return false;
    }
}
