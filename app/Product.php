<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "products";

    protected $guarded = [];


    protected $appends = ["thumbs"];


    public function categories()
    {
        return $this->belongsTo('App\Category','category_id','id');
    }



    public function images()
    {
        return $this->morphMany("App\Images","imageable");
    }

    public function getThumbsAttribute()
    {
        $images = asset("frontEnd/images/".$this->images()->first()->name);
        $name = $this->product_name;
        return '<img src="' .$images.'" class="img-thumbnail" width="250" title="'.$name.'" />';
    }


}
