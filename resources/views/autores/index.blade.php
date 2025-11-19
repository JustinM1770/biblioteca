@extends('layouts.sidebar')

@section('title', 'Autores')

@section('content')
<div class="space-y-6">
    <!-- Botón para agregar nuevo autor (solo admin) -->
    @if(auth()->user()->isAdmin())
    <div class="flex justify-end">
        <a href="{{ route('autores.create') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Agregar Autor
        </a>
    </div>
    @endif

    <!-- Tabla de autores -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nacionalidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Nacimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Libros</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($autores as $autor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $autor->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $autor->nacionalidad ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $autor->fecha_nacimiento ? $autor->fecha_nacimiento->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-2 py-1 bg-primary-light/20 text-primary rounded-full">{{ $autor->libros_count }} libros</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('autores.show', $autor) }}" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors">
                                    Ver
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('autores.edit', $autor) }}" class="px-3 py-1 bg-primary text-white rounded hover:bg-primary-light transition-colors">
                                    Editar
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No hay autores registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $autores->links() }}
    </div>
</div>
@endsection
