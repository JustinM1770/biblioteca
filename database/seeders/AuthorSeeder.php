<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'nombre' => 'Gabriel',
                'apellido' => 'García Márquez',
                'nacionalidad' => 'Colombiana',
                'fecha_nacimiento' => '1927-03-06',
                'biografia' => 'Escritor, novelista, cuentista, guionista, editor y periodista colombiano.'
            ],
            [
                'nombre' => 'Jorge Luis',
                'apellido' => 'Borges',
                'nacionalidad' => 'Argentina',
                'fecha_nacimiento' => '1899-08-24',
                'biografia' => 'Escritor argentino, uno de los autores más destacados de la literatura del siglo XX.'
            ],
            [
                'nombre' => 'Isaac',
                'apellido' => 'Asimov',
                'nacionalidad' => 'Estadounidense',
                'fecha_nacimiento' => '1920-01-02',
                'biografia' => 'Escritor y profesor de bioquímica, conocido por sus obras de ciencia ficción.'
            ],
            [
                'nombre' => 'Octavio',
                'apellido' => 'Paz',
                'nacionalidad' => 'Mexicana',
                'fecha_nacimiento' => '1914-03-31',
                'biografia' => 'Poeta, escritor, ensayista y diplomático mexicano, premio Nobel de Literatura.'
            ],
            [
                'nombre' => 'Yuval Noah',
                'apellido' => 'Harari',
                'nacionalidad' => 'Israelí',
                'fecha_nacimiento' => '1976-02-24',
                'biografia' => 'Historiador y escritor israelí, especializado en historia mundial.'
            ]
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
