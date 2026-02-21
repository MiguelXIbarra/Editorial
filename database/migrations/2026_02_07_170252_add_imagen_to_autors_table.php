<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('autors')) {
            Schema::table('autors', function (Blueprint $table) {

                if (!Schema::hasColumn('autors', 'imagen')) {
                    $table->string('imagen')->nullable()->after('email');
                }
                
                if (!Schema::hasColumn('autors', 'video')) {
                    $table->string('video')->nullable()->after('imagen');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('autors', function (Blueprint $table) {
            $table->dropColumn(['imagen', 'video']);
        });
    }
};