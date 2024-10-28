@extends('layout.menu')

@section('title', 'Dashboard')

<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/welcome.js') }}"></script>


@section('buscador', 'welcome')

@section('content')
    <div class="container">
        <!-- Cuadro de conteo de empresas -->
        <div class="cuadro cuadro-empresas">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empresas</h5>
                    <p class="card-text">Cantidad de empresas: {{ $cantidadEmpresas }}</p>
                </div>
            </div>
        </div>

        <!-- Cuadro de formularios realizados -->
        <div class="cuadro cuadro-formularios">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Formularios Realizados</h5>
                    <p class="card-text">Cantidad de formularios</p>
                </div>
            </div>
        </div>

        <!-- Cuadro de top mejores empresas -->
        <div class="cuadro cuadro-empresas-recientes">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Últimas Empresas Añadidas</h5>
                    <ul class="lista-empresas">
                        @foreach ($ultimasEmpresas as $empresa)
                            <li>{{ $empresa->nombre }} - {{ $empresa->created_at->format('d/m/Y') }}</li>
                        @endforeach
                    </ul>
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



        <!-- Gráfico de torta -->
        <div class="cuadro cuadro-grafico-torta">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Distribución de Empresas</h5>
                    <div class="grafico">
                        <canvas id="graficoTorta"></canvas>
                    </div>
                </div>
            </div>
        </div>

    @endsection
