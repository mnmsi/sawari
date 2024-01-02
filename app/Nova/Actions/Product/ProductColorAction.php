<?php

namespace App\Nova\Actions\Product;

use App\Imports\Product\ProductColorImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ProductColorAction extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Import Product Color';
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
            Excel::import(new ProductColorImport(),$fields->products);
            return Action::message("Product Upload done!");
        } catch (\Exception $e)
        {
            return Action::danger($e->getMessage());
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Heading::make("
                <div class='text-secondary m-0 text-danger'>
                    <span class='text-red-500 text-sm'>*</span>
                    <span class='font-bold text-sm'>FORMAT:</span>
                    Product Code <span class='text-red-500 text-sm'>|</span>
                    Color Name <span class='text-red-500 text-sm'>|</span>
                    Price <span class='text-red-500 text-sm'>|</span>
                    Stock <span class='text-red-500 text-sm'></span>
            ")->asHtml(),
            File::make("Product Colors","products")->required(),
        ];
    }
}
