@extends('layout.menu')

@section('title', 'Asesorias')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">

@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Asesores</h1>
    </div>

    <div class="create-nuevo">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Crear un
            Asesor</button>
    </div>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>
</div>



@endsection

