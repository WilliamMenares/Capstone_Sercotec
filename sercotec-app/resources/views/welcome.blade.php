@extends('layout.menu')

@section('title','Dashboard')

<link rel="stylesheet" href="{{asset('css/crud.css')}}">



@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Dashboard</h1>
    </div>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>
</div>

@endsection
