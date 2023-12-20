<?php

namespace App\Imports\Product;

use App\Models\products;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return null;
//        return new products([
//            //
//        ]);
    }
}
