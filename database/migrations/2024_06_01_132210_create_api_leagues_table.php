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
    Schema::create('api_leagues', function (Blueprint $table) {
    $table->id();
    $table->integer('api_id')->unique();
    $table->string('name');
    $table->string('country')->nullable();
    $table->string('logo')->nullable();
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
        Schema::dropIfExists('api_leagues');
    }
};
