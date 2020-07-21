<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            // $table->integer('id_kof')->unsigned();
            $table->string('name_res','50');
            $table->string('address_res','255');
            $table->string('note_res','500')->nullable();
            $table->string('accept_res','3')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('id_kof')->references('id')->on('kind_of_food')->onDelete('cascade');
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
        Schema::dropIfExists('food_restaurent');
    }
}
