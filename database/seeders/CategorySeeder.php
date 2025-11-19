<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nombre' => 'Ficción',
                'descripcion' => 'Novelas y relatos de ficción literaria'
            ],
            [
                'nombre' => 'Ciencia Ficción',
                'descripcion' => 'Literatura de ciencia ficción y fantasía'
            ],
            [
                'nombre' => 'Historia',
                'descripcion' => 'Libros de historia y biografías históricas'
            ],
            [
                'nombre' => 'Ciencias',
                'descripcion' => 'Libros científicos y de divulgación'
            ],
            [
                'nombre' => 'Filosofía',
                'descripcion' => 'Obras filosóficas y de pensamiento'
            ],
            [
                'nombre' => 'Tecnología',
                'descripcion' => 'Libros sobre tecnología y programación'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
