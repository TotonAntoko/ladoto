<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class wishlist extends Model
{
    //

    protected $table = "wishlists";

    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Order');
    }

    public function wishlist_products()
    {
        return $this->hasMany('App\WishlistProduct');
    }

    public static function active_wishlist_id()
    {
        $active_basket = DB::table('wishlist as w')
            ->leftJoin('orders as o', 'o.wishlist_id','=', 'w.id')
            ->where('w.user_id', Auth::id())
            ->whereNull('o.id')
            ->orderByDesc('w.created_at')
            ->select('w.id')
            ->first();
        if (!is_null($active_wishlist)) return $active_wishlist->id;
    }

    /*ublic function basket_product_qty()
    {
        return DB::table('basket_products')->where('basket_id', $this->id)->sum('quantity');
    }*/

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
