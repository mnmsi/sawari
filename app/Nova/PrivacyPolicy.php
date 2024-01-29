<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class PrivacyPolicy extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\System\PrivacyPolicy>
     */
    public static $model = \App\Models\System\PrivacyPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $showColumnBorders = true;

    public static $clickAction = 'edit';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'privacy_policy',
    ];

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
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Trix::make('Policy html', 'privacy_policy')
                ->sortable()
                ->rules('required')
                ->alwaysShow(),

            DateTime::make('Created At', 'created_at')
                ->default(now())
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At', 'updated_at')
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

    public static function searchable()
    {
        return false;
    }
}
