@extends('layout.menu')

@section('title', 'Dashboard')

@section('buscador', 'welcome')

@section('content')

<div class="p-6">
    <!-- Primera fila - 3 cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="#" class="dashboard-card block rounded-lg bg-sky-50 p-6 hover:bg-sky-100">
            <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                </path>
            </svg>
            <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900">Asesorías</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $asesoriasCount }}</p>
            </div>
        </a>

        <a href="{{ route('empresa.index') }}"
            class="dashboard-card block rounded-lg bg-rose-900 p-6 hover:bg-rose-800">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                </path>
            </svg>
            <div class="mt-4">
                <h3 class="text-lg font-medium text-white">Empresas</h3>
                <p class="text-3xl font-bold text-white">{{ $empresasCount }}</p>
            </div>
        </a>

        <a href="#" class="dashboard-card block rounded-lg bg-purple-50 p-6 hover:bg-purple-100">
            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
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
            @php
                $sortedAmbitos = collect($ambitosConTotales)->sortBy('porcentaje_general');
                $minAmbito = $sortedAmbitos->first();  // El ámbito con el menor porcentaje
                $maxAmbito = $sortedAmbitos->last();   // El ámbito con el mayor porcentaje
            @endphp

            <!-- Mostrar el menor porcentaje -->
            <div>
                <strong>Menor Porcentaje:</strong> {{$minAmbito['ambito']}}
                <p>{{ number_format($minAmbito['porcentaje_general'], 2) }}%</p>
            </div>

            <!-- Mostrar el mayor porcentaje -->
            <div>
                <strong>Mayor Porcentaje:</strong> {{$maxAmbito['ambito']}}
                <p>{{ number_format($maxAmbito['porcentaje_general'], 2) }}%</p>
            </div>
            <strong>Lista de % promedio de todos los ambitos</strong>

            @foreach (collect($ambitosConTotales)->sortBy('porcentaje_general') as $ambi)
                <p>{{$ambi['ambito']}}</p>

                <p>{{ number_format($ambi['porcentaje_general'], 2) }}%</p>
            @endforeach

            <strong>Pregunta con mas veces respondida No Cumple y el ambito al cual esta enlazada</strong>
            <p>Pregunta con mas NO cunple: {{$preguntaConMasRespuestasTipo1->title}}</p>
            <p>Ambito: {{$preguntaConMasRespuestasTipo1->ambito->title}}</p>
            <p>Respuestas: {{ $preguntaConMasRespuestasTipo1->respuesta->count() }}</p>


        </div>

        <!-- Columna derecha - Lista de empresas -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-semibold mb-4">Últimas empresas Asesoradas</h2>
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