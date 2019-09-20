<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerazTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veraz', function (Blueprint $table) {
            $table->increments('id_consulta');
            $table->integer('fk_id_prestamo')->unsigned();
            $table->foreign('fk_id_prestamo')->references('id_prestamo')->on('prestamo')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('answer', ['Aprobado', 'Reprobado']);
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
        Schema::dropIfExists('veraz');
    }
}
