<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;

trait ProductTrait
{
    public function getBikeProducts($filters)
    {
        // ith('brand', 'bodyType', 'category', 'colors', 'media')
        return Product::where('type', 'bike')
                      ->where('is_active', 1)
                      ->when($filters['brand_id'], function ($query) use ($filters) {
                          $query->where('brand_id', $filters['brand_id']);
                      })
                      ->when($filters['body_type_id'], function ($query) use ($filters) {
                          $query->where('body_type_id', $filters['body_type_id']);
                      })
                      ->when($filters['category_id'], function ($query) use ($filters) {
                          $query->where('category_id', $filters['category_id']);
                      })
                      ->when($filters['is_used'], function ($query) use ($filters) {
                          $query->where('is_used', $filters['is_used']);
                      })
                      ->when($filters['color'], function ($query) use ($filters) {
                          $query->whereHas('colors', function ($query) use ($filters) {
                              $query->where('name', '%' . $filters['color'] . '%');
                          });
                      })
                      ->when($filters['price'], function ($query) use ($filters) {
                          $query->whereBetween('price', $filters['price']);
                      })
                      ->when($filters['discount_rate'], function ($query) use ($filters) {
                          $query->whereBetween('discount_rate', $filters['discount_rate']);
                      })
                      ->when($filters['search'], function ($query) use ($filters) {
                          $query->where('name', 'like', '%' . $filters['search'] . '%');
                      })
                      ->orderBy($filters['sort_by'] ?? 'id', $filters['sort_type'] ?? 'desc')
                      ->paginate($filters['per_page'] ?? 10);
    }
}
