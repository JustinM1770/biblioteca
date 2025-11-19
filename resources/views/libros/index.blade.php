@extends('layouts.sidebar')

@section('title', 'Catálogo de Libros')

@section('content')
<div class="space-y-6">
    <!-- Barra de búsqueda y filtros -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('libros.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Buscar por título o autor..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Género</label>
                    <select name="genero_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Todos los géneros</option>
                        @foreach($generos as $genero)
                        <option value="{{ $genero->id }}" {{ request('genero_id') == $genero->id ? 'selected' : '' }}>
                            {{ $genero->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilidad</label>
                    <select name="disponible" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="1" {{ request('disponible') == '1' ? 'selected' : '' }}>Disponibles</option>
                        <option value="0" {{ request('disponible') == '0' ? 'selected' : '' }}>No disponibles</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                    Buscar
                </button>
                <a href="{{ route('libros.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Botón para agregar nuevo libro (solo admin) -->
    @if(auth()->user()->isAdmin())
    <div class="flex justify-end">
        <a href="{{ route('libros.create') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Agregar Libro
        </a>
    </div>
    @endif

    <!-- Grid de libros -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($libros as $libro)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition-shadow">
            <div class="h-48 bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="text-lg font-semibold text-gray-800 line-clamp-2">{{ $libro->titulo }}</h3>
                    @if($libro->disponible)
                    <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                        Disponible
                    </span>
                    @else
                    <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                        Prestado
                    </span>
                    @endif
                </div>

                <p class="text-sm text-gray-600 mb-1">
                    <strong>Autor:</strong> {{ $libro->autor->nombre }}
                </p>
                <p class="text-sm text-gray-600 mb-1">
                    <strong>Género:</strong> {{ $libro->genero->nombre }}
                </p>
                <p class="text-sm text-gray-600 mb-1">
                    <strong>Año:</strong> {{ $libro->anio_publicacion }}
                </p>
                <p class="text-xs text-gray-500">
                    <strong>ISBN:</strong> {{ $libro->isbn }}
                </p>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('libros.show', $libro) }}" class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-center text-sm">
                        Ver Detalles
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('libros.edit', $libro) }}" class="px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors text-sm">
                        Editar
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <p class="text-gray-500 text-lg">No se encontraron libros</p>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $libros->links() }}
    </div>
</div>
@endsection
