<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Genero;
use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [];

        if ($user->isAdmin() || $user->isBibliotecario()) {
            $stats = [
                'total_libros' => Libro::count(),
                'libros_disponibles' => Libro::where('disponible', true)->count(),
                'total_autores' => Autor::count(),
                'total_generos' => Genero::count(),
                'prestamos_activos' => Prestamo::where('estado', 'prestado')->count(),
                'prestamos_atrasados' => Prestamo::atrasados()->count(),
            ];

            if ($user->isAdmin()) {
                $stats['total_usuarios'] = User::count();
                $stats['usuarios_por_rol'] = User::selectRaw('rol, count(*) as total')
                    ->groupBy('rol')
                    ->pluck('total', 'rol');
            }

            $stats['ultimos_prestamos'] = Prestamo::with(['user', 'libro.autor'])
                ->latest()
                ->take(5)
                ->get();
        } elseif ($user->isLector()) {
            $stats = [
                'mis_prestamos_activos' => Prestamo::where('user_id', $user->id)
                    ->where('estado', 'prestado')
                    ->count(),
                'mis_prestamos_totales' => Prestamo::where('user_id', $user->id)->count(),
                'libros_disponibles' => Libro::where('disponible', true)->count(),
            ];

            $stats['mis_ultimos_prestamos'] = Prestamo::with(['libro.autor'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('stats'));
    }
}
