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
<<<<<<< HEAD
            $table->foreing('fk_id_user')->reference('id_usuario')->on('users');
=======
            $table->bigIncrements('id');
>>>>>>> da7ddeec52a27b5bf0b1d89aca717cfdc63864d6
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