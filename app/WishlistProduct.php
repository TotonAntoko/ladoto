<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishlistProduct extends Model
{
    //
    protected $table = "wishlist_products";
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}