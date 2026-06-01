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
        Schema::create('puntos_torneo', function (Blueprint $table) {
            $table->id();
           $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('torneo_id')->unsigned();
            $table->integer('puntos')->default(0);
            $table->integer('puntos_aux')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('torneo_id')->references('id')->on('torneos')->onDelete("cascade");
            $table->unique(['usuario_id', 'torneo_id']); // evita duplicados
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puntos_torneo');
    }
};
