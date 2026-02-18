<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('autors', function (Blueprint $table) {
            // Guardará las coordenadas JSON para re-editar la posición
            $table->text('crop_data')->nullable()->after('imagen');
        });
    }

    public function down(): void
    {
        Schema::table('autors', function (Blueprint $table) {
            $table->dropColumn('crop_data');
        });
    }
};