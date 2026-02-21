<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Editorial extends Model
{
    use HasFactory;

    protected $table = 'editorials';

protected $fillable = ['name', 'email', 'address'];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'editorial_id');
    }
}