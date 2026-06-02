<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('plan_id')->unsigned();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreignId('plan_id')->references('id')->on('planes')->onDelete("cascade");
            $table->enum('estado', ['activa', 'cancelada', 'expirada'])->default('activa');
            $table->date('inicia_en');
            $table->date('vence_en');
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
        Schema::dropIfExists('suscripciones');
    }
};
