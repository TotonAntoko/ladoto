<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

use App\Product;

class Brands extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;
        
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    protected $appends = ["thumbs"];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function allProduct()
    // {
    //     return $this->belongsToMany('App\Product','products','brand_id');
    // }
    public function product()
    {
        return $this->hasMany('App\Product','brand_id','id');
    }


    public function images()
    {
        return $this->morphMany("App\Images","imageable");
    }

    public function getThumbsAttribute()
    {
        // $coba = Images::first()->name;
        $images = asset("uploads/thumb_".$this->images()->first()->name);
        return '<img src="' .$images.'" class="img-thumbnail" width="100" />';
    }

    public function ownsProduct(Product $product)
    {
        return auth()->id() == $product->brand->id;
    }
}
