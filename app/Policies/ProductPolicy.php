<?php

namespace App\Policies;

use App\Brands;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function updateApi(Brands $brand, Product $product)
    {
        return $brand->ownsProduct($product);
    }

    public function deleteApi(Brands $brand, Product $product)
    {
        return $brand->ownsProduct($product);
    }
}
