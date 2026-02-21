<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';

    protected $fillable = [
    'titulo',
    'autor_id',
    'editorial_id',
    'portada',
    'pdf'
];

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'autor_id');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }
}