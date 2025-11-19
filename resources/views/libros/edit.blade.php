@extends('layouts.sidebar')

@section('title', 'Editar Libro')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('libros.update', $libro) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $libro->titulo) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('titulo') border-red-500 @enderror">
                @error('titulo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="autor_id" class="block text-sm font-medium text-gray-700 mb-2">Autor *</label>
                    <select name="autor_id" id="autor_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('autor_id') border-red-500 @enderror">
                        <option value="">Selecciona un autor</option>
                        @foreach($autores as $autor)
                        <option value="{{ $autor->id }}" {{ old('autor_id', $libro->autor_id) == $autor->id ? 'selected' : '' }}>
                            {{ $autor->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('autor_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="genero_id" class="block text-sm font-medium text-gray-700 mb-2">Género *</label>
                    <select name="genero_id" id="genero_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('genero_id') border-red-500 @enderror">
                        <option value="">Selecciona un género</option>
                        @foreach($generos as $genero)
                        <option value="{{ $genero->id }}" {{ old('genero_id', $libro->genero_id) == $genero->id ? 'selected' : '' }}>
                            {{ $genero->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('genero_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="anio_publicacion" class="block text-sm font-medium text-gray-700 mb-2">Año de Publicación *</label>
                    <input type="number" name="anio_publicacion" id="anio_publicacion" value="{{ old('anio_publicacion', $libro->anio_publicacion) }}" required
                           min="1000" max="{{ date('Y') + 1 }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('anio_publicacion') border-red-500 @enderror">
                    @error('anio_publicacion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">ISBN *</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $libro->isbn) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('isbn') border-red-500 @enderror">
                    @error('isbn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                    Actualizar Libro
                </button>
                <a href="{{ route('libros.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </a>
                <form method="POST" action="{{ route('libros.destroy', $libro) }}" class="ml-auto" onsubmit="return confirm('¿Estás seguro de eliminar este libro?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Eliminar
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection
