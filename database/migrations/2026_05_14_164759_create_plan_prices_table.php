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
 Schema::create('plan_prices', function (Blueprint $table) {
    $table->id();

    $table->foreignId('plan_id')
        ->constrained('planes')
        ->cascadeOnDelete();

    $table->string('country_code', 2); // CO, ES, FR
    $table->string('currency', 3); // COP, EUR, USD

    $table->integer('amount');

    $table->boolean('active')->default(true);

    $table->timestamps();

    $table->unique(['plan_id', 'country_code']);
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_prices');
    }
};
