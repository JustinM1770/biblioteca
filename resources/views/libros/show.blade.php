@extends('layouts.sidebar')

@section('title', $libro->titulo)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Información Principal del Libro -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 bg-gradient-to-br from-primary to-primary-light p-12 flex items-center justify-center">
                <svg class="w-32 h-32 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="md:w-2/3 p-8">
                <div class="flex items-start justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $libro->titulo }}</h1>
                    @if($libro->disponible)
                    <span class="px-4 py-2 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                        ✓ Disponible
                    </span>
                    @else
                    <span class="px-4 py-2 bg-red-100 text-red-800 text-sm font-semibold rounded-full">
                        ✗ No Disponible
                    </span>
                    @endif
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Autor</p>
                        <a href="{{ route('autores.show', $libro->autor) }}" class="text-xl font-semibold text-primary hover:text-primary-light">
                            {{ $libro->autor->nombre }}
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Género</p>
                            <a href="{{ route('generos.show', $libro->genero) }}" class="text-lg font-medium text-gray-900 hover:text-primary">
                                {{ $libro->genero->nombre }}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Año de Publicación</p>
                            <p class="text-lg font-medium text-gray-900">{{ $libro->anio_publicacion }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">ISBN</p>
                        <p class="text-lg font-medium text-gray-900 font-mono">{{ $libro->isbn }}</p>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    @if($libro->disponible && auth()->user()->isLector())
                    <a href="{{ route('prestamos.create', ['libro_id' => $libro->id]) }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                        Solicitar Préstamo
                    </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('libros.edit', $libro) }}" class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-colors">
                        Editar Libro
                    </a>
                    @endif

                    <a href="{{ route('libros.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        ← Volver al Catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Préstamos (solo admin y bibliotecario) -->
    @if((auth()->user()->isAdmin() || auth()->user()->isBibliotecario()) && $libro->prestamos->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Historial de Préstamos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Préstamo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Devolución</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($libro->prestamos->sortByDesc('created_at')->take(10) as $prestamo)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prestamo->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $prestamo->fecha_devolucion->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($prestamo->estado == 'prestado') bg-blue-100 text-blue-800
                                @elseif($prestamo->estado == 'devuelto') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($prestamo->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('prestamos.show', $prestamo) }}" class="text-primary hover:text-primary-light font-medium">
                                Ver detalles
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
