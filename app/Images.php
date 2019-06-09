<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //
    protected $table = "images";

    protected $fillable = ["name","imageable_id","imageable_type"];

    public function imageable()
    {
        return $this->morphTo();
    }
}
