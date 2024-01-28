<?php

namespace App\Nova;

use App\Nova\Filters\BannerStatusFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Banner extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\System\Banner>
     */
    public static $model = \App\Models\System\Banner::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'page';
    public static $group = 'System';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'page',
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
            //          page
            Select::make('Display Page', 'page')->options([
                'home' => 'Home',
                'all-bikes' => 'All Bike',
                'popular-brands' => 'Popular Brand',
                'bike-accessories' => 'Bike Accessories',
                'our-showrooms' => 'Our Showrooms',
            ])->rules('required'),
            //            show on type
            Select::make('Page Place', 'show_on')->options([
                'all' => 'All',
                'top' => 'Top',
                'bottom' => 'Bottom',
            ])->dependsOn(['page'], function (Select $field, NovaRequest $request, FormData $formData) {
                if (in_array($formData->page, ['all-bikes', 'popular-brands', 'bike-accessories', 'our-showrooms'])) {
                    $field
                        ->rules('required');
                } else {
                    $field
                        ->hide()
                        ->nullable();
                }
            }),
            //            for home
            //            show on type
            Select::make('Home Banner Place', 'home_show_on')->options([
                'top' => 'Top Slider',
                'all' => 'All Banner',
            ])->dependsOn(['page'], function (Select $field, NovaRequest $request, FormData $formData) {
                if ($formData->page == 'home') {
                    $field
                        ->rules('required');
                } else {
                    $field
                        ->hide()
                        ->nullable();
                }
            }),
            //            image
            Image::make('Image', 'image_url')
                ->path('banner')
                ->disk('public')
                ->disableDownload()
                ->dependsOn(['home_show_on'], function (Image $field, NovaRequest $request, FormData $formData) {
                    if ($formData->home_show_on != "all") {
                        $field
                            ->creationRules('required')
                            ->updateRules('nullable');
                    } else {
                        $field
                            ->hide()
                            ->nullable();
                    }
                }),
            //            home page
            Flexible::make('Banner Images', 'home_image')
                ->dependsOn(['home_show_on', 'page'], function (Flexible $field, NovaRequest $request, FormData $formData) {
                    if ($formData->home_show_on == "all") {
                        $field
                            ->rules('required');
                    } else {
                        $field
                            ->hide()
                            ->nullable();
                    }
                })
                ->button('Add banner Images* (Max 3)')
                ->addLayout('Select image', 'video', [
                    //                    image
                    Image::make('Image', 'home_image')
                        ->path('banner')
                        ->disk('public')
                        ->help("*use respected ratio on view")
                        ->creationRules('required')
                        ->updateRules('nullable'),
                    // url
                    URL::make('Url', 'image_url')
                        ->rules('required')
                        ->withMeta([
                            'extraAttributes' => [
                                'placeholder' => 'Enter promotional url',
                            ],
                        ]),
                ])->hideFromIndex()
                ->hideFromDetail()
                ->limit(3),
            //            order no
            Number::make('Banner Position', 'order_no')
                ->rules('required'),
            //            status
            Select::make('Status', 'is_active')->options([
                '1' => 'Yes',
                '0' => 'No',
            ])->rules('required')
                ->resolveUsing(function ($value) {
                    if ($value === false) {
                        return 0;
                    }
                    return 1;
                })
                ->displayUsing(function ($v) {
                    return $v ? "Active" : "Inactive";
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
        return [
            new BannerStatusFilter,
        ];
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
                return ($field->attribute == 'home_image' || $field->attribute == 'home_show_on');
            });
        }

        if ($request->isUpdateOrUpdateAttachedRequest()) {
            $fields = $fields->reject(function ($field) {
                return ($field->attribute == 'home_image' || $field->attribute == 'home_show_on');
            });
        }

        return parent::fillFields($request, $model, $fields);
    }

    public static function afterCreate(NovaRequest $request, $model): void
    {
        $formData = $request->all();

        if (!empty($formData['home_show_on']) && $formData['home_show_on'] === "top") {
            $banner_item = \App\Models\System\Banner::find($model->id);
            $banner_item->show_on = $formData['home_show_on'];
            $banner_item->save();
        }

        if (isset($formData['home_image'])) {
            $result = [];
            foreach ($formData['home_image'] as $b) {
                $result[] = [
                    "url" => $b["attributes"]["image_url"],
                    "image" => Env::get("APP_URL") . "/storage/" . $request->all()[$b["attributes"]["home_image"]]->store("banner", "public"),
                ];
                $banner_item = \App\Models\System\Banner::find($model->id);
                $banner_item->show_on = $formData['home_show_on'];
                $banner_item->home_images = json_encode($result);
                $banner_item->save();
            }
        }
    }

    public static function afterUpdate(NovaRequest $request, $model): void
    {
        $formData = $request->all();

        if (!empty($formData['home_show_on']) && $formData['home_show_on'] === "top") {
            $banner_item = \App\Models\System\Banner::find($model->id);
            $banner_item->show_on = $formData['home_show_on'];
            $banner_item->save();
        }

        if (isset($formData['home_image'])) {
            $banner_item = \App\Models\System\Banner::find($model->id);
            $result = json_decode($banner_item->home_images, true);
            $update_data = [];
            foreach ($formData['home_image'] as $k => $b) {
                if (!empty($b["attributes"]["home_image"])) {
                    $update_data[] = [
                        "url" => $b["attributes"]["image_url"],
                        "image" => Env::get("APP_URL") . "/storage/" . $request->all()[$b["attributes"]["home_image"]]->store("banner", "public")
                    ];
                } else {
                    $update_data[] = [
                        "url" => $b["attributes"]["image_url"],
                        "image" => $result[$k]["image"],
                    ];
                }
            }
            $banner_item->home_images = json_encode($update_data);
            $banner_item->show_on = $formData['home_show_on'];
            $banner_item->save();
        }
    }

    public static function searchableColumns()
    {
        return [
            'id',
            'page',
        ];
    }
}
