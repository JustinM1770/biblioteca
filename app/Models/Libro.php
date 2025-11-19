<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor_id',
        'genero_id',
        'anio_publicacion',
        'isbn',
        'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'anio_publicacion' => 'integer',
    ];

    /**
     * Relación con autor
     */
    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    /**
     * Relación con género
     */
    public function genero()
    {
        return $this->belongsTo(Genero::class);
    }

    /**
     * Relación con préstamos
     */
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    /**
     * Scope para libros disponibles
     */
    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true);
    }

    /**
     * Scope para buscar libros
     */
    public function scopeBuscar($query, $busqueda)
    {
        return $query->where('titulo', 'like', "%{$busqueda}%")
            ->orWhere('isbn', 'like', "%{$busqueda}%")
            ->orWhereHas('autor', function($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%");
            });
    }
}
