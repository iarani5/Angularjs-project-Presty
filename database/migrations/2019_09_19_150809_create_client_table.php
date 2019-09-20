<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id_cliente');
            $table->integer('fk_id_cliente')->unsigned();
            $table->foreign('fk_id_cliente')->references('id_usuario')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('last_name');
            $table->integer('dni');
            $table->dateTime('birth_date');
            $table->rememberToken();
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
        Schema::dropIfExists('client');
    }
}
