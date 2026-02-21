<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->integer('editorial_id');
 	        $table->integer('autor_id');          
            $table->string('titulo');
           	$table->string('isbn');
           	$table->string('portada');
          	$table->integer('estatus');
            $table->id();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
