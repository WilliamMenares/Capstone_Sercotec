@extends('layout.menu')

@section('title', 'Dashboard')

@section('buscador', 'welcome')

@section('content')

<div class="p-6">
    <!-- Primera fila - 3 tarjetas + 2 tarjetas divididas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 ">
        <div class="grid grid-rows-2 gap-3">
            <a href="{{ route('empresa.index') }}"
                class="dashboard-card block rounded-lg bg-sky-100 p-6 hover:bg-sky-200">
                <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">Cantidad de empresas</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $empresasCount }}</p>
                </div>
            </a>
            <a href="{{ route('asesorias.index') }}"
                class="dashboard-card block rounded-lg bg-sky-100 p-6 hover:bg-sky-200">
                <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">Cantidad de Diagnosticos</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $asesoriasCount }}</p>
                </div>
            </a>
        </div>
        <div class="grid grid-rows-2 gap-3">
            <a href="{{ route('user.index') }}" class="dashboard-card block rounded-lg bg-sky-100 p-3 hover:bg-sky-200">
                <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">Cantidad de asesores</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $usuariosCount }}</p>
                </div>
            </a>

            <a href="#" class="dashboard-card block rounded-lg bg-sky-100 p-3 hover:bg-sky-200">
                <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.67 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z">
                    </path>
                </svg>

                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">% Promedio General Diagnosticos</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format(($promedioPuntajes * 100) / 5, 2) }}%
                    </p>
                </div>
            </a>
        </div>




        <div class="grid grid-rows-2 gap-3">
            <a href="#" class="dashboard-card block rounded-lg bg-sky-100 p-3 hover:bg-sky-200">
                <div class="d-flex">
                    <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <line x1="4" y1="20" x2="20" y2="4" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <circle cx="7" cy="7" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="17" cy="17" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <!-- Flecha hacia abajo -->
                        <path d="M12 16V8M16 12l-4 4-4-4" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>


                </div>

                <div class="mt-4">
                    @php
                        $ambitosCollection = collect($ambitosConTotales ?? []);
                        $sortedAmbitos = $ambitosCollection->sortBy('porcentaje_general');
                        $minAmbito = $sortedAmbitos->first();
                    @endphp

                    @if ($ambitosCollection->isNotEmpty() && $minAmbito)
                        <h3 class="text-lg font-medium text-gray-900">Ámbito con el porcentaje más Bajo:
                            {{ $minAmbito['ambito'] }}
                        </h3>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ number_format($minAmbito['porcentaje_general'], 2) }}%
                        </p>
                    @else
                        <h3 class="text-lg font-medium text-gray-900">Ámbito con el porcentaje más Bajo:
                            Sin Datos
                        </h3>
                        <p class="text-3xl font-bold text-gray-900">
                            0.00%
                        </p>
                    @endif
                </div>
            </a>

            <a href="#" class="dashboard-card block rounded-lg bg-sky-100 p-3 hover:bg-sky-200">
                <div class="d-flex">
                    <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <line x1="4" y1="20" x2="20" y2="4" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <circle cx="7" cy="7" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="17" cy="17" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <!-- Flecha hacia arriba -->
                        <path d="M12 8V16M16 12l-4-4-4 4" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <div class="mt-4">
                    @php
                        $maxAmbito = $sortedAmbitos->last();
                    @endphp

                    @if ($ambitosCollection->isNotEmpty() && $maxAmbito)
                        <h3 class="text-lg font-medium text-gray-900">Ámbito con el porcentaje más Alto:
                            {{ $maxAmbito['ambito'] }}
                        </h3>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ number_format($maxAmbito['porcentaje_general'], 2) }}%
                        </p>
                    @else
                        <h3 class="text-lg font-medium text-gray-900">Ámbito con el porcentaje más Alto:
                            Sin Datos
                        </h3>
                        <p class="text-3xl font-bold text-gray-900">
                            0.00%
                        </p>
                    @endif
                </div>
            </a>
        </div>
        <div class="dashboard-card block rounded-lg bg-sky-100 p-6 shadow-sm min-h-[400px]">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Pregunta que "No Cumple" y el ámbito al cual está
                enlazada</h3>
            @if ($ambitosCollection->isNotEmpty() && $minAmbito)
                    <div class="p-3 bg-sky-200 rounded-lg mt-5">
                        @if ($preguntaConMasRespuestasTipo1)
                            <strong>
                                <p>Pregunta con más "No cumple":
                            </strong> {{ $preguntaConMasRespuestasTipo1->title }}</p>

                            <strong>
                                <p>Ámbito:
                            </strong> {{ $preguntaConMasRespuestasTipo1->ambito->title }}</p>

                            <strong>
                                <p>Respuestas:
                            </strong> {{ $preguntaConMasRespuestasTipo1->respuesta->count() }}</p>

                        @else
                            <div class="alert alert-info bg-red-300 border-gray-400">
                                No hay preguntas que no cumplan
                            </div>
                        @endif
                    </div>
                </div>
            @endif
    </div>
</div>
</div>




<!-- Segunda fila - 2 columnas -->

<div class="grid grid-cols-1 md:grid-cols-[2fr_1fr] gap-6 px-6">
    <!-- Columna izquierda - Área para contenido futuro -->
    <div class="bg-sky-100 rounded-lg p-6 shadow-sm min-h-[400px]">
        <h2 class="text-xl font-semibold mb-2">Gráfico de % promedio de todos los ámbitos</h2>
        <p class="text-gray-500"></p>

        <!-- Gráfico -->
        <div class="p-3 bg-sky-200 rounded-lg shadow-sm h-[300px]"> <!-- Limitar la altura aquí -->
            <canvas id="ambitosChart" class="h-full"></canvas>
        </div>
    </div>

    <!-- Columna derecha - Lista de empresas -->
    <div class="bg-sky-100 rounded-lg p-6 shadow-sm">
        <h2 class="text-xl font-semibold mb-2">Últimas empresas Diagnosticadas</h2>
        <div class="space-y-3">
            @if ($ultimasEmpresas->isEmpty())
                <div class="alert alert-info bg-red-300 border-gray-400">
                    No hay empresas Diagnosticadas
                </div>
            @else
                @foreach ($ultimasEmpresas as $empresa)
                    <div class="p-3 bg-sky-200 rounded-lg hover:bg-sky-300 transition-colors">
                        <p class="font-medium text-gray-900">{{ $empresa->nombre }}</p>
                        <p class="text-sm text-gray-500">{{ $empresa->created_at }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Incluir el script de Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const labels = @json($ambitosCollection->pluck('ambito'));
        const data = @json($ambitosCollection->pluck('porcentaje_general'));

        const ctx = document.getElementById('ambitosChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '% Promedio',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permite que el gráfico se ajuste a la altura disponible
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0, // Mínimo 0%
                        max: 100, // Máximo 100%
                        suggestedMin: 0, // Sugerir mínimo
                        suggestedMax: 100, // Sugerir máximo
                        ticks: {
                            stepSize: 10, // Intervalos de 10%
                            callback: function (value) {
                                return value + '%'; // Agrega el símbolo de porcentaje
                            }
                        }
                    }
                }
            }
        });
    });
</script>


@endsection