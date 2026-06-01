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
   Schema::create('planes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->integer('max_grupos');
    $table->integer('max_usuarios_por_grupo');
    $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('planes');
    }
};
