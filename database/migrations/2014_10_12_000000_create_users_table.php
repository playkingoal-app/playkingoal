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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('phone')->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('phone_country_code_id')->unsigned()->nullable();
            $table->integer('puntos')->nullable();
            $table->integer('puntos_aux')->nullable();
            $table->integer('total')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cod_invitacion')->unique()->nullable();
            $table->string('referido')->nullable(); 
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('country_id')->references('id')->on('countries')->onDelete("cascade");
            $table->foreign('phone_country_code_id')->references('id')->on('phone_country_codes')->onDelete("cascade");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
