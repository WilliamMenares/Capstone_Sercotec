@extends('layout.menu')

@section('title', 'asesorias')

<link rel="stylesheet" href="{{ asset('css/asesorias.css') }}">



@section('buscador', 'asesorias')

@section('content')
<div class="card">
    <div class="card-body">
    <strong class="card-title mb-0">Lista de Asesorías</strong>

        <div class="alert alert-light bg-transparent bg-trans">
            <div class="row align-items-center text-center" style="display: flex; flex-wrap: wrap;">
                <div class="col-md-2">Nombre de empresa diagnosticada</div>
                <div class="col-md-2">Email</div>
                <div class="col-md-2">Rut</div>
                <div class="col-md-2">Id asesoría</div>
                <div class="col-md-2">Apto</div>
                <div class="col-md-2">Fecha creacion</div>
            </div>
        </div>

        <div class="alert alert-light">
            <div class="row align-items-center text-center" style="display: flex; flex-wrap: nowrap;">
                <div class="col-md-2">San Antonio</div>
                <div class="col-md-2">prueba@pruieba.com</div>
                <div class="col-md-2">11.111.111-1</div>
                <div class="col-md-2">1</div>
                <div class="col-md-2">Si</div>
                <div class="col-md-2">25/04/2024</div>
                <div class="col-md-2"></div>
                <div>
                    <button class="btn btn-primary btn-sm" title="Ver informe">
                        <i class="bi bi-eye"></i> Ver
                    </button>
                    <button class="btn btn-danger btn-sm" title="Descargar PDF">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                    <button class="btn btn-success btn-sm" title="Descargar texto plano">
                        <i class="bi bi-file-earmark-text"></i> Texto
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection