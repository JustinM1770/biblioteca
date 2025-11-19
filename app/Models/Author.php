<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'nacionalidad',
        'fecha_nacimiento',
        'biografia'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date'
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}
