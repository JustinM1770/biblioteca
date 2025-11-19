<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'titulo',
        'isbn',
        'año_publicacion',
        'numero_paginas',
        'descripcion',
        'stock',
        'category_id'
    ];

    protected $casts = [
        'año_publicacion' => 'integer',
        'numero_paginas' => 'integer',
        'stock' => 'integer'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
