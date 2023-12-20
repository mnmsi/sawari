<?php

namespace App\Nova\Actions\Product;

use App\Imports\Product\ProductImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ProductUpload extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Import Product';
    public $onlyOnIndex = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        try {
            Excel::import(new ProductImport(),$fields->products);
            return Action::message("Product Upload done!");
        } catch (\Exception $e)
        {
            return Action::danger($e->getMessage());
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Heading::make("
                <div class='text-secondary m-0 text-danger'>
                    <span class='text-red-500 text-sm'>*</span>
                    <span class='font-bold text-sm'>FORMAT:</span>
                    Brand <span class='text-red-500 text-sm'>|</span>
                    Category <span class='text-red-500 text-sm'>|</span>
                    Type(bike/accessory) <span class='text-red-500 text-sm'>|</span>
                    Bike Body Type <span class='text-red-500 text-sm'>|</span>
                    Name <span class='text-red-500 text-sm'>|</span>
                    Product Code <span class='text-red-500 text-sm'>|</span>
                    Price <span class='text-red-500 text-sm'>|</span>
                    Discount Percent <span class='text-red-500 text-sm'>|</span>
                    Product serial number <span class='text-red-500 text-sm'>|</span>
                    Product Category serial number <span class='text-red-500 text-sm'>|</span>
                    Is used <span class='text-red-500 text-sm'>|</span>
                    Is featured <span class='text-red-500 text-sm'>|</span>
                    Is scooter <span class='text-red-500 text-sm'>|</span>
                    Is Upcoming <span class='text-red-500 text-sm'>|</span>
                    Is Used Bike <span class='text-red-500 text-sm'>|</span>
                    Short description <span class='text-red-500 text-sm'>|</span>
                    Description <span class='text-red-500 text-sm'>|</span>
            ")->asHtml(),
            File::make("Products","products")->required(),
        ];
    }
}
