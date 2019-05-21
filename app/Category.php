<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = "categories";
    
    public function allProducts()
    {
        return $this->belongsToMany('App\Product','products','category_id');
    }
}
