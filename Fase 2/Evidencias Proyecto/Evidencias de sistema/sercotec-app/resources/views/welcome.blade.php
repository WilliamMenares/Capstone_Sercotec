@extends('layout.menu')

@section('title', 'Dashboard')

@section('buscador', 'welcome')

@section('content')
<div class="tituloo">
    <h1>Dashboard</h1>
</div>
<div class="p-6">
    <!-- Primera fila - 4 cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <a href="#" class="dashboard-card block rounded-lg bg-sky-50 p-6 hover:bg-sky-100">
            <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
            </svg>
            <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900">Asesorías</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $asesoriasCount }}</p>
            </div>
        </a>
        
        <a href="{{ route('empresa.index') }}" class="dashboard-card block rounded-lg bg-rose-900 p-6 hover:bg-rose-800">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <div class="mt-4">
                <h3 class="text-lg font-medium text-white">Empresas</h3>
                <p class="text-3xl font-bold text-white">{{ $empresasCount }}</p>
            </div>
        </a>

        <a href="#" class="dashboard-card block rounded-lg bg-purple-50 p-6 hover:bg-purple-100">
            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900">Asesores</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $usuariosCount }}</p>
            </div>
        </a>
    </div>

    <!-- Segunda fila - 2 columnas -->
    <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr] gap-6">
        <!-- Columna izquierda - Área para contenido futuro -->
        <div class="bg-white rounded-lg p-6 shadow-sm min-h-[400px]">
            <h2 class="text-xl font-semibold mb-4">Contenido Futuro</h2>
            <p class="text-gray-500"></p>
        </div>

        <!-- Columna derecha - Lista de empresas -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-semibold mb-4">Últimas empresas diagnosticadas</h2>
            <div class="space-y-3">
                @foreach($ultimasEmpresas as $empresa)
                <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <p class="font-medium text-gray-900">{{ $empresa->nombre }}</p>
                    <p class="text-sm text-gray-500">{{ $empresa->created_at }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection