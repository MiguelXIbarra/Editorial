<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autors';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'description',
        'status',
        'image',
        'video',
        'crop_data'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function libros()
    {
        return $this->hasMany(Libro::class, 'autor_id');
    }
}