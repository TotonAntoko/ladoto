<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public $timestamps = false;

    // public function user(){
    //     return $this->belongsToMany('App\Post','roles_user','role_id','user_id');
    // }

    
}
