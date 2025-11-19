<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for the library system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Verificar si ya existe el usuario
        $existingUser = User::where('email', 'admin@biblioteca.com')->first();
        
        if ($existingUser) {
            $this->info('El usuario admin@biblioteca.com ya existe.');
            $this->info('Email: admin@biblioteca.com');
            $this->info('Password: password');
            return;
        }

        // Crear usuario administrador
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@biblioteca.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->info('¡Usuario creado exitosamente!');
        $this->info('Credenciales para el login:');
        $this->info('Email: admin@biblioteca.com');
        $this->info('Password: password');
        
        // Crear un usuario regular también
        $regularUser = User::create([
            'name' => 'Usuario Demo',
            'email' => 'user@biblioteca.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->info('');
        $this->info('Usuario regular también creado:');
        $this->info('Email: user@biblioteca.com');
        $this->info('Password: password');
    }
}
