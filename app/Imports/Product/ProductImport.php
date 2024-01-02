<?php

namespace App\Imports\Product;

use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\System\BikeBodyType;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return Product
     * @throws \ErrorException
     */
    public function model(array $row)
    {
        $brand = Brand::where("name", $row[0])->first();
        $category = Category::where("name", $row[1])->first();
        $body_type = BikeBodyType::where("name", $row[3])->first();
        if ($brand == null || !empty($row[0])) {
            throw new \ErrorException('Brand ' . $row[0] . " missing. Please add brand first.");
        }
        if ($category == null || !empty($row[1])) {
            throw new \ErrorException('Category ' . $row[1] . " missing. Please add category first.");
        }

        return new Product([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'type' => $row[2],
            'body_type_id' => !empty($body_type->id) ? $body_type->id : null,
            'name' => $row[4],
            'product_code' => $row[5],
            'price' => (integer)$row[6],
            'discount_rate' => !empty($row[7]) ? (integer)$row[7] : 0,
            'order_no' => $row[8] ?? null,
            'category_order_no' => $row[9] ?? null,
            'is_used' => Str::upper($row[10]) == "YES" ? 1 : 0,
            'is_featured' => Str::upper($row[11]) == "YES" ? 1 : 0,
            'is_scooter' => Str::upper($row[12]) == "YES" ? 1 : 0,
            'is_upcoming' => Str::upper($row[13]) == "YES" ? 1 : 0,
            'used_bike_type' => Str::upper($row[14]) == "YES" ? 1 : 0,
            'image_url' => "product_image/gtu1P52sVj8gzp6LBvH7Oto0fj6sPkOyREOOZD6X.png",
            'short_description' => !empty($row[15]) ? $row[15] : "",
            'description' => $row[16],
        ]);
//        return null;
    }

    public function startRow(): int
    {
        return 2;
    }
}
