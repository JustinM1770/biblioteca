<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado',
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion' => 'date',
    ];

    /**
     * Boot del modelo para manejar eventos
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear un préstamo, marcar el libro como no disponible
        static::created(function ($prestamo) {
            $prestamo->libro->update(['disponible' => false]);
        });

        // Al actualizar a devuelto, marcar el libro como disponible
        static::updated(function ($prestamo) {
            if ($prestamo->estado === 'devuelto') {
                $prestamo->libro->update(['disponible' => true]);
            }
        });
    }

    /**
     * Relación con usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con libro
     */
    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    /**
     * Verificar si el préstamo está atrasado
     */
    public function estaAtrasado()
    {
        return $this->estado === 'prestado' && 
               $this->fecha_devolucion < Carbon::today();
    }

    /**
     * Scope para préstamos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'prestado');
    }

    /**
     * Scope para préstamos atrasados
     */
    public function scopeAtrasados($query)
    {
        return $query->where('estado', 'prestado')
            ->where('fecha_devolucion', '<', Carbon::today());
    }
}
