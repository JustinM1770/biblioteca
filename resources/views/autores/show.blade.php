@extends('layouts.sidebar')

@section('title', $autor->nombre)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Información del Autor -->
    <div class="bg-white rounded-lg shadow-sm p-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $autor->nombre }}</h1>
                @if($autor->nacionalidad)
                <p class="text-lg text-gray-600">{{ $autor->nacionalidad }}</p>
                @endif
            </div>
            <div class="px-6 py-3 bg-primary-light/20 rounded-lg">
                <p class="text-sm text-gray-600">Total de libros</p>
                <p class="text-3xl font-bold text-primary">{{ $autor->libros->count() }}</p>
            </div>
        </div>

        @if($autor->fecha_nacimiento)
        <div class="mb-6">
            <p class="text-sm text-gray-600">Fecha de Nacimiento</p>
            <p class="text-lg font-medium text-gray-900">{{ $autor->fecha_nacimiento->format('d/m/Y') }}</p>
            <p class="text-sm text-gray-500">({{ $autor->fecha_nacimiento->age }} años)</p>
        </div>
        @endif

        <div class="flex gap-3 pt-6 border-t border-gray-200">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('autores.edit', $autor) }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                Editar Autor
            </a>
            @endif
            <a href="{{ route('autores.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                ← Volver a Autores
            </a>
        </div>
    </div>

    <!-- Libros del Autor -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Libros de {{ $autor->nombre }}</h2>
        
        @if($autor->libros->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($autor->libros as $libro)
            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-40 bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <strong>Género:</strong> {{ $libro->genero->nombre }}
                    </p>
                    <p class="text-sm text-gray-600 mb-1">
                        <strong>Año:</strong> {{ $libro->anio_publicacion }}
                    </p>
                    <p class="text-xs text-gray-500 mb-3">
                        <strong>ISBN:</strong> {{ $libro->isbn }}
                    </p>
                    <a href="{{ route('libros.show', $libro) }}" class="block w-full px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-center text-sm">
                        Ver Detalles
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <p class="text-gray-500 text-lg">Este autor no tiene libros registrados aún</p>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('libros.create') }}" class="inline-block mt-4 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                Agregar Libro
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
