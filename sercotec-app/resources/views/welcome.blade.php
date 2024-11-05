@extends('layout.menu')

@section('title', 'Dashboard')

<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/welcome.js') }}"></script>

@section('buscador', 'welcome')

@section('content')
    <div class="titulo-pagina">Dashboard</div>
    <div class="container">
        <div class="cuadro cuadro-grafico-torta">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empresas</h5>
                    <p class="card-text">Cantidad de empresas: {{ $cantidadEmpresas }}</p>
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
