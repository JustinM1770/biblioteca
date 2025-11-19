<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>📚 Biblioteca - Sistema de Gestión</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased" style="font-family: 'Montserrat', sans-serif;">
    <!-- Navegación -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900"> Biblioteca</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Registrarse
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 transition">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-4xl font-bold mb-4">Bienvenido a la Biblioteca Digital</h2>
                <p class="text-xl mb-8 opacity-90">Explora nuestro catálogo de libros y gestiona tus préstamos</p>
                
                <!-- Estadísticas -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <div class="text-3xl font-bold">{{ $stats['total_books'] }}</div>
                        <div class="text-sm opacity-80">Total de Libros</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <div class="text-3xl font-bold">{{ $stats['available_books'] }}</div>
                        <div class="text-sm opacity-80">Disponibles</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <div class="text-3xl font-bold">{{ $stats['total_authors'] }}</div>
                        <div class="text-sm opacity-80">Autores</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <div class="text-3xl font-bold">{{ $stats['active_loans'] }}</div>
                        <div class="text-sm opacity-80">Préstamos Activos</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catálogo de Libros -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Libros Disponibles</h3>
            
            @if($books->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($books as $book)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">
                            <!-- Categoría Badge -->
                            <div class="mb-3">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $book->category->nombre ?? 'Sin categoría' }}
                                </span>
                            </div>
                            
                            <!-- Título -->
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $book->titulo }}
                            </h4>
                            
                            <!-- Autores -->
                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Autor(es):</strong> {{ $book->authors->pluck('full_name')->join(', ') }}
                            </p>
                            
                            <!-- Año y páginas -->
                            <p class="text-sm text-gray-600 mb-3">
                                <strong>Año:</strong> {{ $book->año_publicacion }}
                                @if($book->numero_paginas)
                                    • <strong>Páginas:</strong> {{ $book->numero_paginas }}
                                @endif
                            </p>
                            
                            <!-- Descripción -->
                            @if($book->descripcion)
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ Str::limit($book->descripcion, 120) }}
                                </p>
                            @endif
                            
                            <!-- Stock y Acción -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->stock > 0 ? "Stock: {$book->stock}" : 'Sin stock' }}
                                </span>
                                
                                @auth
                                    @if($book->stock > 0)
                                        <form action="{{ route('loans.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700 transition">
                                                📚 Prestar
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="bg-gray-300 text-gray-500 text-sm px-4 py-2 rounded cursor-not-allowed">
                                            Sin stock
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition">
                                        Iniciar sesión
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Paginación -->
                @if($books->hasPages())
                    <div class="mt-8">
                        {{ $books->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">📚</div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No hay libros disponibles</h3>
                    <p class="text-gray-600">Vuelve pronto para ver nuevos libros en nuestro catálogo.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-2">📚 Sistema de Biblioteca</h3>
                <p class="text-gray-400">Desarrollado con Laravel y Tailwind CSS</p>
            </div>
        </div>
    </footer>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div id="flash-message" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                if(msg) msg.remove();
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div id="flash-error" class="fixed bottom-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('flash-error');
                if(msg) msg.remove();
            }, 5000);
        </script>
    @endif
    </head>
    
</html>
                                                  