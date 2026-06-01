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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('grupo_id')->unsigned()->nullable();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('torneo_id')->unsigned();
            $table->string('comprobante')->nullable();
            
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete("cascade");
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('torneo_id')->references('id')->on('torneos')->onDelete("cascade");
            $table->enum('estado_pago', ['pendiente', 'activo'])->default('pendiente');
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
        Schema::dropIfExists('inscripciones');
    }
};
