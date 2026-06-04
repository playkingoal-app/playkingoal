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
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('plan_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete("cascade");
            $table->enum('estado', ['activa', 'cancelada', 'expirada'])->default('activa');
            $table->date('inicia_en');
            $table->date('vence_en');
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
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
