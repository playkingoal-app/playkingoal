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
        Schema::create('grupo_usuario', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('grupo_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();

            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete("cascade");
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete("cascade");
            $table->enum('rol', ['admin', 'jugador']);
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->timestamps();
            $table->unique(['grupo_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupo_usuario');
    }
};
