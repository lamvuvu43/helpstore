<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bill', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_b')->unsigned();
//            $table->integer('id_f')->unsigned();
            $table->string('name_f','50');
            $table->integer('amount_food');
            $table->float('price_f','10');
            $table->float('total_price_of_food');
            $table->string('note_db')->nullable();
            $table->foreign('id_b')->references('id')->on('bill')->onDelete('cascade');
//            $table->foreign('id_f')->references('id')->on('food')->onDelete('cascade');
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
        Schema::dropIfExists('detail_bill');
    }
}
