@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-200px)]">
    <div class="text-center">
        <div class="mb-8">
            <svg class="w-24 h-24 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        
        <h1 class="text-6xl font-bold text-gray-800 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Acceso Prohibido</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            No tienes permisos para acceder a esta página. Esta acción requiere privilegios de 
            <span class="font-semibold text-primary">{{ implode(' o ', ['Administrador', 'Bibliotecario']) }}</span>.
        </p>
        
        <div class="space-y-3">
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Volver al Dashboard
                </a>
            </div>
            
            <div>
                <button onclick="window.history.back()" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver Atrás
                </button>
            </div>
        </div>

        <div class="mt-12 p-4 bg-blue-50 rounded-lg max-w-md mx-auto">
            <p class="text-sm text-gray-600">
                <strong>Tu rol actual:</strong> 
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ auth()->user()->rol === 'admin' ? 'bg-red-100 text-red-800' : (auth()->user()->rol === 'bibliotecario' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                    {{ ucfirst(auth()->user()->rol) }}
                </span>
            </p>
        </div>
    </div>
</div>
@endsection
