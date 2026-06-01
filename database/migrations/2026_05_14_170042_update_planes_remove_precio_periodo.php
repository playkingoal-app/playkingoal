<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            if (Schema::hasColumn('planes', 'precio')) {
                $table->dropColumn('precio');
            }

            if (Schema::hasColumn('planes', 'periodo')) {
                $table->dropColumn('periodo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->decimal('precio', 8, 2)->default(0);
            $table->enum('periodo', ['mensual', 'anual'])->default('mensual');
        });
    }
};