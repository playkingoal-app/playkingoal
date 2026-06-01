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
            $table->bigInteger('country_id')->unsigned()->nullable();
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
