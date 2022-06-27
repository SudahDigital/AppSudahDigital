<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountPaketOnOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->double('discount_pkt',11,2)->nullable()->after('bonus_cat');
            $table->enum('discount_pkt_type',['PERCENT','NOMINAL'])->nullable()->after('discount_pkt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropColumn('discount_pkt');
            $table->dropColumn('discount_pkt_type');
        });
    }
}
