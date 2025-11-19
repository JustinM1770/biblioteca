@extends('layouts.sidebar')

@section('title', 'Nuevo Préstamo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('prestamos.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="libro_id" class="block text-sm font-medium text-gray-700 mb-2">Libro Disponible *</label>
                <select name="libro_id" id="libro_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('libro_id') border-red-500 @enderror">
                    <option value="">Selecciona un libro</option>
                    @foreach($librosDisponibles as $libro)
                    <option value="{{ $libro->id }}" {{ old('libro_id') == $libro->id ? 'selected' : '' }}>
                        {{ $libro->titulo }} - {{ $libro->autor->nombre }}
                    </option>
                    @endforeach
                </select>
                @error('libro_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fecha_devolucion" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Devolución *</label>
                <input type="date" name="fecha_devolucion" id="fecha_devolucion" value="{{ old('fecha_devolucion', now()->addDays(15)->format('Y-m-d')) }}" required
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('fecha_devolucion') border-red-500 @enderror">
                @error('fecha_devolucion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Período de préstamo recomendado: 15 días</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">Información del Préstamo</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• El préstamo se registrará a tu nombre</li>
                    <li>• El libro quedará marcado como no disponible</li>
                    <li>• Recuerda devolver el libro antes de la fecha límite</li>
                </ul>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                    Registrar Préstamo
                </button>
                <a href="{{ route('prestamos.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
