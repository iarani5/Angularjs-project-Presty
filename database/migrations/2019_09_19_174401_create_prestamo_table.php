<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamo', function (Blueprint $table) {
            $table->increments('id_prestamo');
            $table->integer('fk_id_cliente')->unsigned();
            $table->integer('fk_id_financiera')->unsigned();
            $table->integer('fk_id_autorizador')->unsigned();
            $table->foreign('fk_id_cliente')->references('id_cliente')->on('client')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_id_financiera')->references('id_financiera')->on('financiera')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_id_autorizador')->references('id_autorizador')->on('autorizador')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('amount');
            $table->enum('state', ['Pedido', 'Pre-Otorgado', 'Otorgado', 'Denegado']);
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
        Schema::dropIfExists('prestamo');
    }
}
