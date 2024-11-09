@extends('layout.menu')

@section('title', 'Asesores')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">


@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Asesorías</h1>
    </div>
    
</div>


<h1>Listado de Usuarios</h1>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Fecha de Creación</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('usuarios.pdf') }}" class="btn btn-primary">Descargar PDF</a>


@endsection
