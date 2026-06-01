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
        Schema::create('equipos', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            // Datos de la API
            $table->integer('api_id')->nullable()->unique();
            $table->string('name')->nullable(); 
            $table->string('logo')->nullable(); 

    
            $table->foreignId('api_league_id')
                ->nullable()
                ->constrained('api_leagues')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('equipos');
    }
};
