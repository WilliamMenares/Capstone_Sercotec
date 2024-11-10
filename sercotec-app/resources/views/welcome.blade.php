@extends('layout.menu')

@section('title', 'Dashboard')

<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/welcome.js') }}"></script>

@section('buscador', 'welcome')

@section('content')
    <div class="titulo-pagina">Dashboard</div>
    <div class="container">
        <div class="cuadro cuadro-kpi1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empresas</h5>
                    <p class="card-text">Cantidad de empresas: {{ $cantidadEmpresas }}</p>
                </div>
            </div>
        </div>
        <div class="cuadro cuadro-kpi2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">KPI 2</h5>
                    <p class="card-text">Valor KPI 2</p>
                </div>
            </div>
        </div>
        <div class="cuadro cuadro-kpi3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">KPI 3</h5>
                    <p class="card-text">Valor KPI 3</p>
                </div>
            </div>
        </div>
        <div class="cuadro cuadro-kpi4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">KPI 4</h5>
                    <p class="card-text">Valor KPI 4</p>
                </div>
            </div>
        </div>

        <div class="cuadro cuadro-grafico-torta">
            <h5 class="card-title">UltimasEmpresas</h5>
            <div class="card">
                <div class="card-body">
                    
                    <div class="grafico">
                        <ul>
                            @foreach ($ultimasEmpresas as $empresa)
                            <li>
                                {{ $empresa->nombre }} - <small>{{ $empresa->created_at->format('d/m/Y') }}</small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="cuadro cuadro-grafico-barras">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empresas por Mes</h5>
                    <div class="grafico">
                        <canvas id="graficoBarras"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Datos de empresas por mes en un elemento oculto -->
    <div id="empresasPorMesData" style="display: none;">
        @json($empresasPorMes)
    </div>
@endsection
