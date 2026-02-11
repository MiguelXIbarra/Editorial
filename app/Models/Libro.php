<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Libro extends Model
{
    protected $fillable = [
        'titulo', 
        'isbn', 
        'portada', 
        'autor_id', 
        'editorial_id', 
        'status', 
        'role'
    ];

    /**
     * Relación: Un libro pertenece a un Autor.
     */
    public function autor(): BelongsTo
    {
        return $this->belongsTo(Autor::class, 'autor_id');
    }

    /**
     * Relación: Un libro pertenece a una Editorial.
     */
    public function editorial(): BelongsTo
    {
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }
}