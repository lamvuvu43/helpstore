<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_order', function (Blueprint $table) {
            $table->id();
            $table->integer('id_res')->unsigned();
            $table->integer('id_f')->unsigned();
            $table->integer('amount');
            $table->integer('id_user');
            $table->string('note_f','255')->nullable();
            $table->timestamps();
            $table->foreign('id_f')->references('id')->on('food')->onDelete('cascade');
            $table->foreign('id_res')->references('id')->on('restaurant')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_order');
    }
}
