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
            $table->bigIncrements('id_prestamo');
            $table->foreign('fk_id_cliente')->references('fk_id_user')->on('client');
            $table->foreign('fk_id_autorizador')->references('fk_id_user')->on('autorizador');
            $table->foreign('fk_id_financiera')->references('fk_id_user')->on('financiera');
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
