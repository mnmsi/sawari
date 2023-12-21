<?php

namespace App\Nova\Actions\Product;

use App\Models\Product\Product;
use Ayvazyan10\Imagic\Imagic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductColorImageAction extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Upload Color Image';
    public $onlyOnIndex = true;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        try {
            $images_list = json_decode($fields->images, true);
            foreach ($images_list as $m) {
                $fileName = basename($m);
                $image_name = explode('_', pathinfo($fileName, PATHINFO_FILENAME));

                if (count($image_name) > 1) {
                    $product = Product::where("product_code", $image_name[0])->first();
                    if ($product) {
                        $product_color = \App\Models\Product\ProductColor::where([
                            'product_id' => $product->id,
                            'name' => $image_name[1]
                        ])->first();
                        if ($product_color) {
                            $product_color->image_url = str_replace('/storage', '', $m);
                            $product_color->save();
                        } else {
                            return Action::danger('Product color not found with name ' . $image_name[1]);
                        }
                    } else {
                        return Action::danger('Product not found with code ' . $image_name[0]);
                    }
                } else {
                    return Action::danger('Select proper Image color name with productCode_productColorName');
                }
            }
        } catch (\Exception $e) {
            return Action::danger($e->getMessage());
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Heading::make("
                <div class='text-secondary m-0 font-bold'>
                    <span class='text-red-500 text-sm'>*</span>
                    Select Multiple Image with *product code and *color name.
                </div>
            ")->asHtml(),
            Imagic::make('Images', "images")
                ->multiple()
                ->help("Use .png, .jpg images only.")
                ->convert(false)
                ->required(),
        ];
    }
}
