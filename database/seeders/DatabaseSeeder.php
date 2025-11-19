<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Autor;
use App\Models\Genero;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios con diferentes roles
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@biblioteca.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
        ]);

        User::create([
            'name' => 'Bibliotecario',
            'email' => 'bibliotecario@biblioteca.com',
            'password' => Hash::make('password'),
            'rol' => 'bibliotecario',
        ]);

        $lector = User::create([
            'name' => 'Lector Ejemplo',
            'email' => 'lector@biblioteca.com',
            'password' => Hash::make('password'),
            'rol' => 'lector',
        ]);

        // Crear géneros
        $generos = [
            ['nombre' => 'Ficción', 'descripcion' => 'Obras de ficción literaria'],
            ['nombre' => 'No Ficción', 'descripcion' => 'Obras basadas en hechos reales'],
            ['nombre' => 'Ciencia Ficción', 'descripcion' => 'Literatura de ciencia ficción y fantasía'],
            ['nombre' => 'Romance', 'descripcion' => 'Novelas románticas'],
            ['nombre' => 'Misterio', 'descripcion' => 'Novelas de misterio y suspenso'],
            ['nombre' => 'Biografía', 'descripcion' => 'Biografías y autobiografías'],
            ['nombre' => 'Historia', 'descripcion' => 'Libros de historia'],
            ['nombre' => 'Poesía', 'descripcion' => 'Colecciones de poesía'],
        ];

        foreach ($generos as $genero) {
            Genero::create($genero);
        }

        // Crear autores
        $autores = [
            ['nombre' => 'Gabriel García Márquez', 'nacionalidad' => 'Colombiano', 'fecha_nacimiento' => '1927-03-06'],
            ['nombre' => 'Isabel Allende', 'nacionalidad' => 'Chilena', 'fecha_nacimiento' => '1942-08-02'],
            ['nombre' => 'Jorge Luis Borges', 'nacionalidad' => 'Argentino', 'fecha_nacimiento' => '1899-08-24'],
            ['nombre' => 'Pablo Neruda', 'nacionalidad' => 'Chileno', 'fecha_nacimiento' => '1904-07-12'],
            ['nombre' => 'Octavio Paz', 'nacionalidad' => 'Mexicano', 'fecha_nacimiento' => '1914-03-31'],
            ['nombre' => 'Mario Vargas Llosa', 'nacionalidad' => 'Peruano', 'fecha_nacimiento' => '1936-03-28'],
            ['nombre' => 'Julio Cortázar', 'nacionalidad' => 'Argentino', 'fecha_nacimiento' => '1914-08-26'],
            ['nombre' => 'Carlos Fuentes', 'nacionalidad' => 'Mexicano', 'fecha_nacimiento' => '1928-11-11'],
        ];

        foreach ($autores as $autor) {
            Autor::create($autor);
        }

        // Crear libros
        $libros = [
            ['titulo' => 'Cien Años de Soledad', 'autor_id' => 1, 'genero_id' => 1, 'anio_publicacion' => 1967, 'isbn' => '9780060883287', 'disponible' => true],
            ['titulo' => 'El Amor en los Tiempos del Cólera', 'autor_id' => 1, 'genero_id' => 4, 'anio_publicacion' => 1985, 'isbn' => '9780307389732', 'disponible' => true],
            ['titulo' => 'La Casa de los Espíritus', 'autor_id' => 2, 'genero_id' => 1, 'anio_publicacion' => 1982, 'isbn' => '9781501117015', 'disponible' => false],
            ['titulo' => 'Ficciones', 'autor_id' => 3, 'genero_id' => 3, 'anio_publicacion' => 1944, 'isbn' => '9780802130303', 'disponible' => true],
            ['titulo' => 'El Aleph', 'autor_id' => 3, 'genero_id' => 1, 'anio_publicacion' => 1949, 'isbn' => '9788466318990', 'disponible' => true],
            ['titulo' => 'Veinte Poemas de Amor', 'autor_id' => 4, 'genero_id' => 8, 'anio_publicacion' => 1924, 'isbn' => '9788437604817', 'disponible' => true],
            ['titulo' => 'El Laberinto de la Soledad', 'autor_id' => 5, 'genero_id' => 2, 'anio_publicacion' => 1950, 'isbn' => '9780140188424', 'disponible' => true],
            ['titulo' => 'La Ciudad y los Perros', 'autor_id' => 6, 'genero_id' => 1, 'anio_publicacion' => 1963, 'isbn' => '9788420412146', 'disponible' => true],
            ['titulo' => 'Rayuela', 'autor_id' => 7, 'genero_id' => 1, 'anio_publicacion' => 1963, 'isbn' => '9788420458052', 'disponible' => true],
            ['titulo' => 'La Muerte de Artemio Cruz', 'autor_id' => 8, 'genero_id' => 1, 'anio_publicacion' => 1962, 'isbn' => '9788437505015', 'disponible' => false],
        ];

        foreach ($libros as $libro) {
            Libro::create($libro);
        }

        // Crear préstamos de ejemplo
        Prestamo::create([
            'user_id' => $lector->id,
            'libro_id' => 3, // La Casa de los Espíritus (marcado como no disponible)
            'fecha_prestamo' => now(),
            'fecha_devolucion' => now()->addDays(15),
            'estado' => 'prestado',
        ]);

        Prestamo::create([
            'user_id' => $lector->id,
            'libro_id' => 10, // La Muerte de Artemio Cruz (marcado como no disponible)
            'fecha_prestamo' => now()->subDays(5),
            'fecha_devolucion' => now()->addDays(10),
            'estado' => 'prestado',
        ]);

        // Préstamo devuelto
        Prestamo::create([
            'user_id' => $lector->id,
            'libro_id' => 1, // Cien Años de Soledad
            'fecha_prestamo' => now()->subDays(20),
            'fecha_devolucion' => now()->subDays(5),
            'estado' => 'devuelto',
        ]);

        $this->command->info('Base de datos poblada exitosamente!');
        $this->command->info('Usuarios creados:');
        $this->command->info('- Admin: admin@biblioteca.com / password');
        $this->command->info('- Bibliotecario: bibliotecario@biblioteca.com / password');
        $this->command->info('- Lector: lector@biblioteca.com / password');
    }
}

