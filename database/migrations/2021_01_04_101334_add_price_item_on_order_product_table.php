<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceItemOnOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function($table) {
            $table->double('price_item',11,2)->nullable()->after('product_id');
            $table->double('price_item_promo',11,2)->nullable()->after('price_item');
            $table->float('discount_item')->nullable()->after('price_item_promo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function($table) {
            $table->dropColumn('price_item');
            $table->dropColumn('price_item_promo');
            $table->dropColumn('discount_item');
        });
    }
}
