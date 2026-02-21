<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Verificamos si la tabla 'autors' NO tiene todavía la columna 'status'
        if (!Schema::hasColumn('autors', 'status')) {
            Schema::table('autors', function (Blueprint $table) {
                $table->integer('status')->default(1)->after('email');
            });
        }
    }

    public function down()
    {
            if (Schema::hasColumn('autors', 'status')) {
            Schema::table('autors', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};