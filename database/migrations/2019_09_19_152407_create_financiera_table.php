<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancieraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financiera', function (Blueprint $table) {
            $table->increments('id_financiera');
            $table->integer('fk_id_financiera')->unsigned();
            $table->foreign('fk_id_financiera')->references('id_usuario')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('company_name');
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
        Schema::dropIfExists('financiera');
    }
}