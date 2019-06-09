<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->string('slug',160);
            $table->string('product_name',150);
            $table->text('product_detail');
            $table->integer('stok');
            $table->decimal('original_price',18,9)->nullable();;
            $table->decimal('product_price',18,9);

            $table->foreign('category_id')
                    ->references('id')->on('categories')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('brand_id')
                    ->references('id')->on('brands')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
