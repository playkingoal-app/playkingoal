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
        Schema::create('pronosticos', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->bigInteger('jugador')->unsigned()->nullable();
            $table->bigInteger('partido')->unsigned();
            $table->integer('golesLocal')->nullable(); 
            $table->integer('golesVisitante')->nullable();
            $table->string('ganador')->nullable();
            $table->integer('puntos')->default(0);
            $table->timestamps();
 
            $table->foreign('jugador')->references('id')->on('users')->onDelete("cascade");    
            $table->foreign('partido')->references('id')->on('partidos')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pronosticos');
    }
};
