<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📚 Catálogo de Libros
            </h2>
            <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                ➕ Nuevo Libro
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($books as $book)
                        <div class="border rounded-lg p-6 hover:shadow-lg transition">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $book->titulo }}</h3>
                                <p class="text-sm text-gray-600 mb-2">
                                    <strong>Autor(es):</strong> {{ $book->authors->pluck('full_name')->join(', ') }}
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    <strong>ISBN:</strong> {{ $book->isbn }}
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    <strong>Año:</strong> {{ $book->año_publicacion }}
                                </p>
                                @if($book->descripcion)
                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ Str::limit($book->descripcion, 100) }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                    {{ $book->category->nombre ?? 'Sin categoría' }}
                                </span>
                                <span class="text-xs {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 rounded">
                                    Stock: {{ $book->stock }}
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('books.show', $book) }}" class="flex-1 bg-gray-100 text-gray-700 px-3 py-2 rounded text-center text-sm hover:bg-gray-200 transition">
                                    Ver
                                </a>
                                <a href="{{ route('books.edit', $book) }}" class="flex-1 bg-yellow-100 text-yellow-700 px-3 py-2 rounded text-center text-sm hover:bg-yellow-200 transition">
                                    Editar
                                </a>
                                
                                @if($book->stock > 0)
                                    <form action="{{ route('loans.store') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" class="w-full bg-green-100 text-green-700 px-3 py-2 rounded text-sm hover:bg-green-200 transition">
                                            Prestar
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="flex-1 bg-gray-100 text-gray-400 px-3 py-2 rounded text-sm cursor-not-allowed">
                                        Sin Stock
                                    </button>
                                @endif
                            </div>

                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="mt-2" onsubmit="return confirm('¿Estás seguro de eliminar este libro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-100 text-red-700 px-3 py-2 rounded text-sm hover:bg-red-200 transition">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-8">
                            <div class="text-gray-400 text-xl mb-2">📚</div>
                            <p class="text-gray-600">No hay libros registrados.</p>
                            <a href="{{ route('books.create') }}" class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Agregar el primer libro
                            </a>
                        </div>
                        @endforelse
                    </div>

                    @if($books->hasPages())
                        <div class="mt-6">
                            {{ $books->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>