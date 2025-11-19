<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">📚 Biblioteca</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('biblioteca.index') }}">Inicio</a>
                <a class="nav-link" href="{{ route('biblioteca.books') }}">API Libros</a>
                <a class="nav-link" href="{{ route('biblioteca.authors') }}">API Autores</a>
                <a class="nav-link" href="{{ route('biblioteca.loans') }}">API Préstamos</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1>Catálogo de Libros</h1>
                <p class="text-muted">Sistema de gestión de biblioteca con 5 tablas: libros, autores, categorías, préstamos y usuarios.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Libros Disponibles</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Categoría</th>
                                        <th>ISBN</th>
                                        <th>Año</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                    <tr>
                                        <td>
                                            <strong>{{ $book->titulo }}</strong>
                                            @if($book->descripcion)
                                                <br><small class="text-muted">{{ Str::limit($book->descripcion, 100) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($book->authors as $author)
                                                <span class="badge bg-secondary">{{ $author->full_name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $book->category->nombre ?? 'Sin categoría' }}</span>
                                        </td>
                                        <td>{{ $book->isbn }}</td>
                                        <td>{{ $book->año_publicacion }}</td>
                                        <td>
                                            <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $book->stock }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Enlaces API</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('biblioteca.books') }}" target="_blank">📚 Todos los libros (JSON)</a></li>
                            <li><a href="{{ route('biblioteca.authors') }}" target="_blank">👤 Todos los autores (JSON)</a></li>
                            <li><a href="{{ route('biblioteca.categories') }}" target="_blank">📁 Todas las categorías (JSON)</a></li>
                            <li><a href="{{ route('biblioteca.loans') }}" target="_blank">📋 Todos los préstamos (JSON)</a></li>
                            <li><a href="{{ route('biblioteca.available') }}" target="_blank">✅ Libros disponibles (JSON)</a></li>
                            <li><a href="{{ route('biblioteca.overdue') }}" target="_blank">⚠️ Préstamos vencidos (JSON)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Estadísticas</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Total de libros:</strong> {{ \App\Models\Book::count() }}</p>
                        <p><strong>Total de autores:</strong> {{ \App\Models\Author::count() }}</p>
                        <p><strong>Total de categorías:</strong> {{ \App\Models\Category::count() }}</p>
                        <p><strong>Préstamos activos:</strong> {{ \App\Models\Loan::where('estado', 'prestado')->count() }}</p>
                        <p><strong>Usuarios registrados:</strong> {{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>