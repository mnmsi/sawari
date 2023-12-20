<?php

namespace App\Imports\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductColor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductColorImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return ProductColor
     * @throws \ErrorException
     */
    public function model(array $row): ProductColor
    {
        $product = Product::where("product_code", $row[0])->first();
        if (!$product) {
            throw new \ErrorException('Product ' . $row[0] . " missing. Please add first.");
        }
        return new ProductColor([
            'product_id' => $product->id,
            'name' => $row[1],
            'image_url' => "product_image/gtu1P52sVj8gzp6LBvH7Oto0fj6sPkOyREOOZD6X.png",
            'price' => $row[2],
            'stock' => $row[3],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
