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
    {Schema::create('grupo_premios', function (Blueprint $table) {
    $table->id();
    $table->foreignId('grupo_id')->constrained('grupos')->cascadeOnDelete();
    $table->unsignedInteger('posicion');
    $table->string('premio');
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
        Schema::dropIfExists('grupo_premios');
    }
};
