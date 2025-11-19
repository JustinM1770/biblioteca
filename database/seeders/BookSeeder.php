<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'titulo' => 'Cien años de soledad',
                'isbn' => '978-84-376-0494-7',
                'año_publicacion' => 1967,
                'numero_paginas' => 471,
                'descripcion' => 'Una de las obras más importantes de la literatura hispanoamericana.',
                'stock' => 3,
                'category_id' => 1, // Ficción
                'authors' => [1] // Gabriel García Márquez
            ],
            [
                'titulo' => 'El Aleph',
                'isbn' => '978-84-206-3647-5',
                'año_publicacion' => 1949,
                'numero_paginas' => 203,
                'descripcion' => 'Colección de cuentos del escritor argentino Jorge Luis Borges.',
                'stock' => 2,
                'category_id' => 1, // Ficción
                'authors' => [2] // Jorge Luis Borges
            ],
            [
                'titulo' => 'Fundación',
                'isbn' => '978-84-450-7617-4',
                'año_publicacion' => 1951,
                'numero_paginas' => 244,
                'descripcion' => 'Primera novela de la saga Fundación de Isaac Asimov.',
                'stock' => 4,
                'category_id' => 2, // Ciencia Ficción
                'authors' => [3] // Isaac Asimov
            ],
            [
                'titulo' => 'El laberinto de la soledad',
                'isbn' => '978-968-16-0359-1',
                'año_publicacion' => 1950,
                'numero_paginas' => 191,
                'descripcion' => 'Ensayo de Octavio Paz sobre la identidad mexicana.',
                'stock' => 2,
                'category_id' => 5, // Filosofía
                'authors' => [4] // Octavio Paz
            ],
            [
                'titulo' => 'Sapiens: De animales a dioses',
                'isbn' => '978-84-9992-529-0',
                'año_publicacion' => 2011,
                'numero_paginas' => 496,
                'descripcion' => 'Una breve historia de la humanidad.',
                'stock' => 5,
                'category_id' => 3, // Historia
                'authors' => [5] // Yuval Noah Harari
            ]
        ];

        foreach ($books as $bookData) {
            $authors = $bookData['authors'];
            unset($bookData['authors']);
            
            $book = Book::create($bookData);
            $book->authors()->attach($authors);
        }
    }
}
