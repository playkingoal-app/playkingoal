<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->string('codigo_invitacion', 10)
                  ->unique()
                  ->nullable()
                  ->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropUnique(['codigo_invitacion']);
            $table->dropColumn('codigo_invitacion');
        });
    }
};
