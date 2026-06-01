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
        Schema::create('partidos', function (Blueprint $table) {


            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->bigInteger('idEquipoLocal')->unsigned();  
            $table->bigInteger('idEquipoVisitante')->unsigned();
            $table->dateTime('fecha_hora');
            $table->bigInteger('jornada_id')->unsigned(); 
            $table->bigInteger('torneo_id')->unsigned(); 
            $table->bigInteger('api_id')->unique()->nullable();
           $table->string('estado')->default('NS'); 
           // NS, LIVE, FT, PST...NS   → no started  LIVE → en vivo  FT   → finalizado  PST  → postergado
            
         
            $table->integer('golesLocal')->nullable(); 
            $table->integer('golesVisitante')->nullable();
            $table->string('ganador')->nullable();
           
              //  Control de puntos
            $table->boolean('puntos_calculados')->default(false);
            $table->timestamps();
 
            
            $table->foreign('idEquipoLocal')->references('id')->on('equipos')->onDelete("cascade");
            $table->foreign('idEquipoVisitante')->references('id')->on('equipos')->onDelete("cascade");
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onDelete("cascade");
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
        Schema::dropIfExists('partidos');
    }
};
