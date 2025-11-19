@extends('layouts.sidebar')

@section('title', 'Préstamos')

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('prestamos.index') }}" class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Todos</option>
                    <option value="prestado" {{ request('estado') == 'prestado' ? 'selected' : '' }}>Prestados</option>
                    <option value="devuelto" {{ request('estado') == 'devuelto' ? 'selected' : '' }}>Devueltos</option>
                    <option value="atrasado" {{ request('estado') == 'atrasado' ? 'selected' : '' }}>Atrasados</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                    Filtrar
                </button>
                <a href="{{ route('prestamos.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Botón para nuevo préstamo -->
    <div class="flex justify-end">
        <a href="{{ route('prestamos.create') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nuevo Préstamo
        </a>
    </div>

    <!-- Tabla de préstamos -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @if(!auth()->user()->isLector())
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Libro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Préstamo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Devolución</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($prestamos as $prestamo)
                    <tr class="hover:bg-gray-50">
                        @if(!auth()->user()->isLector())
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prestamo->user->name }}</td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prestamo->libro->titulo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $prestamo->libro->autor->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $prestamo->fecha_devolucion->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($prestamo->estado == 'prestado') 
                                    @if($prestamo->estaAtrasado()) bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800 @endif
                                @elseif($prestamo->estado == 'devuelto') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                @if($prestamo->estado == 'prestado' && $prestamo->estaAtrasado())
                                    Atrasado
                                @else
                                    {{ ucfirst($prestamo->estado) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                @if($prestamo->estado == 'prestado' && (auth()->user()->isAdmin() || auth()->user()->isBibliotecario()))
                                <form method="POST" action="{{ route('prestamos.devolver', $prestamo) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                                        Marcar Devuelto
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('prestamos.show', $prestamo) }}" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors">
                                    Ver
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isLector() ? 6 : 7 }}" class="px-6 py-12 text-center text-gray-500">
                            No se encontraron préstamos
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $prestamos->links() }}
    </div>
</div>
@endsection
