<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Brands extends Authenticatable
{
    use Notifiable;
        
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

    public function roles()
    {
        return $this->belongsToMany("App\Role","roles_user", 'brand_id', 'role_id')->withTimeStamps();
    }

    public function isItAuthorized($authorization)
    {
        foreach ($this->roles()->get() as $role) {
                if ($role->name == $authorization)
            {
                return true;
                break;
            }
        }
        return false;
    }
}
