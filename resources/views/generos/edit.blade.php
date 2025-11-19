@extends('layouts.sidebar')

@section('title', 'Editar Género')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('generos.update', $genero) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre del Género *</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $genero->nombre) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('nombre') border-red-500 @enderror">
                @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $genero->descripcion) }}</textarea>
                @error('descripcion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                    Actualizar Género
                </button>
                <a href="{{ route('generos.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </a>
                <form method="POST" action="{{ route('generos.destroy', $genero) }}" class="ml-auto" onsubmit="return confirm('¿Estás seguro de eliminar este género? Se eliminarán también todos los libros asociados.')">
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
