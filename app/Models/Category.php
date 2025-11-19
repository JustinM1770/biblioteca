<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
