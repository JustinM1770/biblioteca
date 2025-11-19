@extends('layouts.sidebar')

@section('title', 'Detalle del Préstamo')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Información del Préstamo -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Información del Préstamo</h2>
            <span class="px-4 py-2 text-sm font-semibold rounded-full
                @if($prestamo->estado == 'prestado') 
                    @if($prestamo->estaAtrasado()) bg-red-100 text-red-800
                    @else bg-blue-100 text-blue-800 @endif
                @elseif($prestamo->estado == 'devuelto') bg-green-100 text-green-800
                @else bg-red-100 text-red-800
                @endif">
                @if($prestamo->estado == 'prestado' && $prestamo->estaAtrasado())
                    ⚠️ Atrasado
                @else
                    {{ ucfirst($prestamo->estado) }}
                @endif
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información del Usuario -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Usuario</h3>
                <div>
                    <p class="text-sm text-gray-600">Nombre</p>
                    <p class="text-lg font-medium text-gray-900">{{ $prestamo->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-lg font-medium text-gray-900">{{ $prestamo->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Rol</p>
                    <p class="text-lg font-medium text-gray-900 capitalize">{{ $prestamo->user->rol }}</p>
                </div>
            </div>

            <!-- Información del Libro -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Libro</h3>
                <div>
                    <p class="text-sm text-gray-600">Título</p>
                    <p class="text-lg font-medium text-gray-900">{{ $prestamo->libro->titulo }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Autor</p>
                    <p class="text-lg font-medium text-gray-900">{{ $prestamo->libro->autor->nombre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Género</p>
                    <p class="text-lg font-medium text-gray-900">{{ $prestamo->libro->genero->nombre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">ISBN</p>
                    <p class="text-lg font-medium text-gray-900">{{ $prestamo->libro->isbn }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Fechas del Préstamo -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Fechas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-sm text-blue-600 font-medium mb-1">Fecha de Préstamo</p>
                <p class="text-2xl font-bold text-blue-900">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</p>
                <p class="text-xs text-blue-600 mt-1">{{ $prestamo->fecha_prestamo->diffForHumans() }}</p>
            </div>

            <div class="bg-purple-50 rounded-lg p-4">
                <p class="text-sm text-purple-600 font-medium mb-1">Fecha de Devolución</p>
                <p class="text-2xl font-bold text-purple-900">{{ $prestamo->fecha_devolucion->format('d/m/Y') }}</p>
                @if($prestamo->estado == 'prestado')
                    <p class="text-xs text-purple-600 mt-1">{{ $prestamo->fecha_devolucion->diffForHumans() }}</p>
                @endif
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-600 font-medium mb-1">Duración del Préstamo</p>
                <p class="text-2xl font-bold text-gray-900">{{ $prestamo->fecha_prestamo->diffInDays($prestamo->fecha_devolucion) }} días</p>
                @if($prestamo->estado == 'prestado' && $prestamo->estaAtrasado())
                    <p class="text-xs text-red-600 mt-1 font-semibold">{{ abs($prestamo->fecha_devolucion->diffInDays(now())) }} días de retraso</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex gap-3">
            <a href="{{ route('prestamos.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                ← Volver a Préstamos
            </a>

            <a href="{{ route('libros.show', $prestamo->libro) }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                Ver Libro
            </a>

            @if($prestamo->estado == 'prestado' && (auth()->user()->isAdmin() || auth()->user()->isBibliotecario()))
            <form method="POST" action="{{ route('prestamos.devolver', $prestamo) }}" class="ml-auto">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    ✓ Marcar como Devuelto
                </button>
            </form>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isBibliotecario())
            <form method="POST" action="{{ route('prestamos.destroy', $prestamo) }}" onsubmit="return confirm('¿Estás seguro de eliminar este préstamo?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Eliminar
                </button>
            </form>
            @endif
        </div>
    </div>

    @if($prestamo->estaAtrasado() && $prestamo->estado == 'prestado')
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h4 class="text-lg font-semibold text-red-900 mb-1">Préstamo Atrasado</h4>
                <p class="text-red-800">Este préstamo está atrasado. Por favor, devuelve el libro lo antes posible.</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
