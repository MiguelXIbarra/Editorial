<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasColumn('autors', 'crop_data')) {
            Schema::table('autors', function (Blueprint $table) {

                if (Schema::hasColumn('autors', 'image')) {
                    $table->text('crop_data')->nullable()->after('image');
                } elseif (Schema::hasColumn('autors', 'imagen')) {
                    $table->text('crop_data')->nullable()->after('imagen');
                } else {
                    $table->text('crop_data')->nullable();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('autors', 'crop_data')) {
            Schema::table('autors', function (Blueprint $table) {
                $table->dropColumn('crop_data');
            });
        }
    }
};