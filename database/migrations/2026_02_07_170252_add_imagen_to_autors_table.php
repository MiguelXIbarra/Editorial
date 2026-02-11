<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('autors', function (Blueprint $table) {
            // Se añade la columna imagen después del email
            $table->string('imagen')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('autors', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }
};
