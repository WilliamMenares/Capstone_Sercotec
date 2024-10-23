@extends('layout.menu')

@section('title','Inicio')

<link rel="stylesheet" href="{{asset('css/welcome.css')}}">

@section('buscador', 'welcome')


@section('content')
    <div class="container">
        <div class="cuadro cuadro-1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empresas</h5>
                    <p class="card-text">Cantidad de empresas: {{ $cantidadEmpresas }}</p>
                </div>
            </div>
        </div>
        <div class="cuadro cuadro-2">Cuadro 2</div>
        <div class="cuadro cuadro-3">Cuadro 3</div>
        <div class="cuadro cuadro-4">Cuadro 4</div>
        <div class="cuadro cuadro-5">Cuadro 5</div>
        <div class="cuadro cuadro-6">Cuadro 6</div>
    </div>
@endsection