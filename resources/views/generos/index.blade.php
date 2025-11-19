@extends('layouts.sidebar')

@section('title', 'Géneros Literarios')

@section('content')
<div class="space-y-6">
    <!-- Botón para agregar nuevo género (solo admin) -->
    @if(auth()->user()->isAdmin())
    <div class="flex justify-end">
        <a href="{{ route('generos.create') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Agregar Género
        </a>
    </div>
    @endif

    <!-- Grid de géneros -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($generos as $genero)
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-800">{{ $genero->nombre }}</h3>
                <span class="px-3 py-1 bg-primary-light/20 text-primary text-sm rounded-full">
                    {{ $genero->libros_count }} libros
                </span>
            </div>

            <p class="text-sm text-gray-600 mb-4">{{ $genero->descripcion ?? 'Sin descripción' }}</p>

            <div class="flex gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('generos.show', $genero) }}" class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-center text-sm">
                    Ver Libros
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('generos.edit', $genero) }}" class="px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors text-sm">
                    Editar
                </a>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <p class="text-gray-500 text-lg">No hay géneros registrados</p>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $generos->links() }}
    </div>
</div>
@endsection
