<?php

namespace App\Transformers;

use App\Brands;
use App\Transformers\ProductTransformer;
use League\Fractal\TransformerAbstract;

class BrandTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'products'
    ];
    public function transform(Brands $brand)
    {
        return[
            'name' => $brand->name,
            'email' => $brand->email,
            'registered' => $brand->created_at->diffForHumans()
        ];
    }

    public function includeProducts(Brands $brand)
    {
        $products = $brand->product()->latestFirst()->get();
        return $this->collection($products, new ProductTransformer);
    }
}