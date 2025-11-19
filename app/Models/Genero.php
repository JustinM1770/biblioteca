<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación con libros
     */
    public function libros()
    {
        return $this->hasMany(Libro::class);
    }
}
