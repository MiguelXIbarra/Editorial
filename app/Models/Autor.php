<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Autor extends Model
{
    // Permitir asignación masiva de todos los campos necesarios
    protected $fillable = [
        'nombre', 
        'email', 
        'resenia', 
        'imagen', 
        'status', 
        'role', 
        'user_id', 
        'crop_data'
    ];

    /**
     * Relación: Un Autor pertenece a un Usuario (vinculación por user_id).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}