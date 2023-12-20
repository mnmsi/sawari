<?php

namespace App\Imports\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductSpecification;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductSpecificationImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \ErrorException
     */
    public function model(array $row)
    {
        $product = Product::where("product_code", $row[0])->first();
        if (!$product) {
            throw new \ErrorException('Product ' . $row[0] . " missing. Please add first.");
        }
        return new ProductSpecification([
            'product_id' => $product->id,
            'title' => $row[1],
            'value' => $row[2],
            'is_key_feature' => Str::upper($row[3]) == "YES" ? 1 : 0,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
