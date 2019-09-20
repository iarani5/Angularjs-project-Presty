<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicidad', function (Blueprint $table) {
            $table->increments('id_publicidad');
            $table->integer('fk_id_financiera')->unsigned();
            $table->foreign('fk_id_financiera')->references('id_financiera')->on('financiera')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nombre_publicidad');
            $table->string('link_publicidad');
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
        Schema::dropIfExists('publicidad');
    }
}
