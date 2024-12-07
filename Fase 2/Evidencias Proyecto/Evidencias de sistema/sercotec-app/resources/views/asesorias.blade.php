@extends('layout.menu')

@section('title', 'Asesorias')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">



@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Asesorias</h1>
    </div>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>

    <div id="mobileGrid" class="mobile-table">
        <div class="mobile-table-header">
            <h2>Lista de Asesorías</h2>
        </div>
        <div class="mobile-search">
            <input type="text" id="searchInput" class="form-control bg-dark text-light"
                placeholder="Buscar por id, responsable, empresa, contacto o email">
        </div>
        <div class="mobile-table-body" id="mobileTableBody">
            <!-- Las filas se generarán dinámicamente aquí -->
        </div>
        <nav aria-label="Paginación de empresas">
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Los elementos de paginación se generarán dinámicamente con JavaScript -->
            </ul>
        </nav>
    </div>
    <div style="color:white">
        <p>////////////////////////////////////////////////</p>
        @foreach ($encuestas as $encu)
            <p>Puntaje Total Obtenido: {{$datos_encu[$encu->id]['obtenido']}} de {{$datos_encu[$encu->id]['resultado']}} </p>
            <p>Porcentaje Total Obtenido {{($datos_encu[$encu->id]['obtenido'] * 100 ) / $datos_encu[$encu->id]['resultado'] }}</p>
            @foreach ($datos_encu[$encu->id]['empresas'] as $emp)
                <p>{{$emp['rut']}}</p>
            @endforeach

            @foreach ($datos_encu[$encu->id]['ambitos'] as $amb)
                <p>------------------------------------------</p>
                <p>{{$amb['nombre']}}</p>
                <p>Puntaje Obtenido por Ambito: {{$amb['obtenido']}} de {{$amb['resultado']}}</p>
                <p>Porcentaje Total Obtenido : {{($amb['obtenido'] * 100) / $amb['resultado'] }} </p>
                <p></p>
                <p>------------------------------------------</p>
                @foreach ($amb['preguntas'] as $preg)
                    <p>{{$preg['nombre']}}</p>
                    <p>{{$preg['respuesta']}}</p>
                @endforeach
            @endforeach
            <p>////////////////////////////////////////////////</p>
        @endforeach
    </div>




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