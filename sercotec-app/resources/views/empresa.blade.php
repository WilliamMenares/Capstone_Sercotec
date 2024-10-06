@extends('layout.menu')

@section('title','Empresa')

<link rel="stylesheet" href="{{asset('css/empresa.css')}}">

@section('buscador', 'empresa')


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Lista de Empresas</h5>
                <button class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nuevo Usuario
                </button>
            </div>
            <div class="row column-headers">
                <div class="col-md-3">Nombre</div>
                <div class="col-md-2">Email</div>
                <div class="col-md-2">Teléfono</div>
                <div class="col-md-2">Rut</div>
                <div class="col-md-2">Fecha Creación</div>
                <div class="col-md-1"></div>
            </div>
            @foreach(range(1, 7) as $index)
            <div class="alert alert-light">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <span>Duoc</span>
                        </div>
                    </div>
                    <div class="col-md-2">duoc@duoc.cl</div>
                    <div class="col-md-2">73054777760</div>
                    <div class="col-md-2">12.123.456-7</div>
                    <div class="col-md-2">13/09/2024</div>
                    <div class="col-md-1 text-end action-icons">
                        <a href="#" aria-label="Editar usuario"><i class="bi bi-pencil"></i></a>
                        <a href="#" aria-label="Eliminar usuario"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
