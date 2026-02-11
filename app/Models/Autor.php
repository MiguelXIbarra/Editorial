<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    // Añade esto para permitir la asignación masiva
    protected $fillable = ['nombre', 'email', 'resenia', 'imagen', 'status', 'role', 'user_id'];
}