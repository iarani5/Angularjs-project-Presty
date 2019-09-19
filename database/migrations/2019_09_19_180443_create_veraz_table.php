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
            $table->bigIncrements('id_consulta');
            $table->foreing('fk_id_prestamo')->reference('id_prestamo')->on('prestamo')
            $table->enum('answer', ['Aprobado', 'Reprobado'])
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
