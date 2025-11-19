<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ➕ Nuevo Libro
            </h2>
            <a href="{{ route('books.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('books.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Título -->
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">
                                Título *
                            </label>
                            <input type="text" 
                                   id="titulo" 
                                   name="titulo" 
                                   value="{{ old('titulo') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('titulo') border-red-500 @enderror"
                                   required>
                            @error('titulo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ISBN -->
                        <div>
                            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                                ISBN *
                            </label>
                            <input type="text" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="{{ old('isbn') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('isbn') border-red-500 @enderror"
                                   required>
                            @error('isbn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Año de Publicación -->
                            <div>
                                <label for="año_publicacion" class="block text-sm font-medium text-gray-700 mb-2">
                                    Año de Publicación *
                                </label>
                                <input type="number" 
                                       id="año_publicacion" 
                                       name="año_publicacion" 
                                       value="{{ old('año_publicacion') }}"
                                       min="1000" 
                                       max="{{ date('Y') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('año_publicacion') border-red-500 @enderror"
                                       required>
                                @error('año_publicacion')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Número de Páginas -->
                            <div>
                                <label for="numero_paginas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Número de Páginas
                                </label>
                                <input type="number" 
                                       id="numero_paginas" 
                                       name="numero_paginas" 
                                       value="{{ old('numero_paginas') }}"
                                       min="1"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('numero_paginas') border-red-500 @enderror">
                                @error('numero_paginas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Categoría -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Categoría *
                                </label>
                                <select id="category_id" 
                                        name="category_id"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Seleccionar categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stock *
                                </label>
                                <input type="number" 
                                       id="stock" 
                                       name="stock" 
                                       value="{{ old('stock', 1) }}"
                                       min="0"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stock') border-red-500 @enderror"
                                       required>
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Autores -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Autores * (selecciona uno o más)
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 border border-gray-300 rounded-md p-3 max-h-48 overflow-y-auto">
                                @foreach($authors as $author)
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="authors[]" 
                                               value="{{ $author->id }}"
                                               {{ in_array($author->id, old('authors', [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ $author->full_name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('authors')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea id="descripcion" 
                                      name="descripcion" 
                                      rows="4"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                ✅ Crear Libro
                            </button>
                            <a href="{{ route('books.index') }}" class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition text-center">
                                ❌ Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>