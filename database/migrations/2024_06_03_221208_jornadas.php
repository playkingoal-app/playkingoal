<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
     * Significados de variables
     *valor_puntaje_me = al valor que tiene la jornada en marcador exacto
     *valor_puntaje_g = al valor que tiene la jornada en acierto de ganador
     */
        Schema::create('jornadas', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->bigInteger('torneo_id')->unsigned();
            $table->string('descripcion');
            $table->integer('valor_puntaje_me');
            $table->integer('valor_puntaje_g');
            $table->timestamps();

            $table->foreign('torneo_id')->references('id')->on('torneos')->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jornadas');
    }
};
