@extends('layout.menu')

@section('title','Empleado')

<link rel="stylesheet" href="{{asset('css/empleado.css')}}">

@section('buscador', 'empleado')


@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-start align-items-center mb-4">
            <h5 class="card-title mb-0 mt-4 ms-4">Lista de Empleados</h5>
          <button class="btn btn-primary ms-auto mb-0 mt-4 ms-4 button-inicio">
              <i class="bi bi-plus-lg me-1"></i>
              Nuevo Usuario
          </button>
        </div>   
      
      
            <div class="p-5 table-responsive">
            <table class="table">
               
                <thead>
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @foreach ($datos as $item)
                    <tr>
                    <td>{{$item->id_empleado}}</td>
                    <td>{{$item->nombre_empleado}}</td>
                    <td>{{$item->correo_empleado}}</td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            
            </div>
          </div>
              @endsection
