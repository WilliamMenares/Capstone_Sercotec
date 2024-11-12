@extends('layout.menu')

@section('title', 'Empresa')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">






@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Empresas</h1>
    </div>


    <form id="import-form" enctype="multipart/form-data" class="d-flex align-items-center gap-3">
        @csrf
        <div class="space-y-2">
            <label for="excel-file" class="block text-sm font-medium text-white">
            </label>
            <input type="file" id="excel-file" name="file" accept=".xlsx,.xls" class="btn btn-primary">
        </div>

        <button type="button" onclick="startImport()" class="btn btn-secondary">
            Importar Excel
        </button>
    </form>

    <script>
        
    </script>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>
</div>

<script src="{{ asset('js/empresa.js') }}"></script>

@endsection

