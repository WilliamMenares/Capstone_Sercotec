@extends('layout.menu')

@section('title', 'Asesorias')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">



@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Asesorias</h1>
    </div>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>
</div>

<script src="{{ asset('js/asesorias.js') }}"></script>

@endsection

@foreach ($encuestas as $encu)

    <div class="modal fade" id="deleteModal{{$encu->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Asesoria</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta asesoria?</p>

                </div>
                <div class="modal-footer">
                    <form action="/asesorias/{{$encu->id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">
                            Eliminar
                        </button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>


@endforeach