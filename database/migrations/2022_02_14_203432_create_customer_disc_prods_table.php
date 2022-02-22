<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDiscProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_disc_prods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cust_disc_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->double('discount_price',11,2)->unsigned();
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
        Schema::dropIfExists('customer_disc_prods');
    }
}
