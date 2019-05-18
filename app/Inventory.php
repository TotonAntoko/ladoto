<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $table = 'inventory';
    protected $fillable = ['nama_barang', 'jenis_barang', 'harga_barang', 'stok', 'brand'];
}
