<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_res')->unsigned();
            $table->integer('id_user')->unsigned()->nullable();
            $table->integer('id_table')->unsigned();
            $table->float('total_price');
            $table->dateTime('date_price');
            $table->string('status_b');
            $table->foreign('id_res')->references('id')->on('restaurant')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_table')->references('id')->on('table');
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
        Schema::dropIfExists('bill');
    }
}
