@extends('layout.menu')

@section('title','Inicio')

<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

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

        <!-- Cuadro de usuario logeado -->
        <div class="cuadro cuadro-usuario">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuario Logeado</h5>
                    <p class="card-text">Bienvenido, {{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>

        <!-- Gráfico de barras -->
        <div class="cuadro cuadro-grafico-barras">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gráfico de Barras</h5>
                    <p class="card-text">Aquí se mostrará el gráfico de barras.</p>
                    <div class="grafico" id="graficoBarras"></div>
                </div>
            </div>
        </div>

        <!-- Gráfico de torta -->
        <div class="cuadro cuadro-grafico-torta">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gráfico de Torta</h5>
                    <p class="card-text">Aquí se mostrará el gráfico de torta.</p>
                    <div class="grafico" id="graficoTorta"></div>
                </div>
            </div>
        </div>
    </div>
@endsection