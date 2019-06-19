<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewChartHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW view_chart_history AS
        SELECT b.user_id, bp.basket_id, p.product_name, p.slug, p.product_detail, bp.quantity, b.ongkir, bp.price, bp.price*bp.quantity AS subTotal, (bp.price*bp.quantity) + b.ongkir AS total
        FROM basket_products bp INNER JOIN baskets b ON bp.basket_id=b.id
        INNER JOIN products p ON bp.product_id=p.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_chart_history');
    }
}
