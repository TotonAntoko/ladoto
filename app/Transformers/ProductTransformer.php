<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product)
    {
        return[
            'id' => $product->id,
            'nama' => $product->product_name,
            'namaKategori' => $product->categories->category_name,
            'detail' => $product->product_detail,
            'stok' => $product->stok,
            'hargaOri' => number_format($product->original_price),
            'hargaProduct' => number_format($product->product_price),
            'image' => $product->thumbs,
            'published' => $product->created_at->diffForHumans()
        ];
    }
}