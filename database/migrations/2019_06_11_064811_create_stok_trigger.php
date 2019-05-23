<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStokTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER STOK_UPDATE_PRODUCT AFTER INSERT ON orders FOR EACH ROW BEGIN
                UPDATE products p 
                INNER JOIN basket_products bp ON p.id=bp.product_id 
                INNER JOIN baskets b ON bp.basket_id=b.id
                INNER JOIN orders o ON b.id=o.basket_id
                SET stok=stok-bp.quantity 
                WHERE p.id=bp.product_id
                AND bp.basket_id=b.id
                AND b.id=NEW.basket_id;
            END
        ');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `STOK_UPDATE_PRODUCT`');
    }
}
