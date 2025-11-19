<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos usuarios de ejemplo si no existen
        $user = User::firstOrCreate(
            ['email' => 'usuario1@example.com'],
            [
                'name' => 'Juan Pérez',
                'password' => bcrypt('password'),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'usuario2@example.com'],
            [
                'name' => 'María González',
                'password' => bcrypt('password'),
            ]
        );

        $loans = [
            [
                'user_id' => $user->id,
                'book_id' => 1, // Cien años de soledad
                'fecha_prestamo' => now()->subDays(10),
                'fecha_devolucion_esperada' => now()->addDays(4),
                'fecha_devolucion_real' => null,
                'estado' => 'prestado'
            ],
            [
                'user_id' => $user2->id,
                'book_id' => 2, // El Aleph
                'fecha_prestamo' => now()->subDays(20),
                'fecha_devolucion_esperada' => now()->subDays(6),
                'fecha_devolucion_real' => null,
                'estado' => 'vencido'
            ],
            [
                'user_id' => $user->id,
                'book_id' => 3, // Fundación
                'fecha_prestamo' => now()->subDays(30),
                'fecha_devolucion_esperada' => now()->subDays(16),
                'fecha_devolucion_real' => now()->subDays(14),
                'estado' => 'devuelto'
            ]
        ];

        foreach ($loans as $loan) {
            Loan::create($loan);
        }
    }
}
