<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class ProductSpecificationCategory extends Resource
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

    public static function label()
    {
        return 'Product Specification';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductSpecificationCategory>
     */
    public static $model = \App\Models\ProductSpecificationCategory::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
     * @throws \Exception
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Product', 'product', 'App\Nova\Product')
                ->rules('required')
                ->searchable()
                ->noPeeking(),
            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter name here'
                    ]
                ]),

            Flexible::make('Add Product specification', 'specification_list')
                ->button('Add specification')
                ->addLayout('Select specification', 'video', [
                    Hidden::make('Id', 'specification_id')
                        ->hideFromDetail()
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->readonly(),
//                    title
                    Text::make('Title', 'specification_title')
                        ->sortable()
                        ->rules('required', 'max:255')
                        ->withMeta([
                            'extraAttributes' => [
                                'placeholder' => 'Enter specification title',
                            ],
                        ]),
//                    details
                    Text::make('Value', 'specification_value')
                        ->sortable()
                        ->rules('required', 'max:255')
                        ->withMeta([
                            'extraAttributes' => [
                                'placeholder' => 'Enter specification value',
                            ],
                        ]),
                ])->hideFromIndex()->required()
                ->hideFromDetail(),
            HasMany::make('Product Specifications', 'specifications', ProductSpecification::class)->show(),
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

    protected static function fillFields(NovaRequest $request, $model, $fields)
    {
        if ($request->isCreateOrAttachRequest()) {
            $fields = $fields->reject(function ($field) {
                return in_array($field->attribute, ['specification_list']);
            });
        }

        if ($request->isUpdateOrUpdateAttachedRequest()) {
            $fields = $fields->reject(function ($field) {
                return in_array($field->attribute, ['specification_list']);
            });
        }

        return parent::fillFields($request, $model, $fields);
    }

    public static function afterCreate(NovaRequest $request, $model)
    {
        $specification_data = $request->only('specification_list');

        if (isset($specification_data['specification_list'])) {
            foreach ($specification_data['specification_list'] as $s) {
                $specification = new \App\Models\Product\ProductSpecification();
                $specification->product_specification_category_id = $model->id;
                $specification->title = $s['attributes']['specification_title'];
                $specification->value = $s['attributes']['specification_value'];
                $specification->save();
            }
        }
    }

    public static function afterUpdate(NovaRequest $request, Model $model)
    {
        $specification_data = $request->only('specification_list');

        if (isset($specification_data['specification_list'])) {
            foreach ($specification_data['specification_list'] as $s) {
                if (isset($s['attributes']['specification_id'])) {
                    $specification = \App\Models\Product\ProductSpecification::find($s['attributes']['specification_id']);
                    $specification->title = $s['attributes']['specification_title'];
                    $specification->value = $s['attributes']['specification_value'];
                    $specification->save();
                } else {
                    $specification = new \App\Models\Product\ProductSpecification();
                    $specification->product_specification_category_id = $model->id;
                    $specification->title = $s['attributes']['specification_title'];
                    $specification->value = $s['attributes']['specification_value'];
                    $specification->save();
                }
            }
        }
    }
}
