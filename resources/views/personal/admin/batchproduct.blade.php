@extends('adminlte::page')
@section('title','Lotes')

@section('content_header')
<h1>Lote por Dia</h1>
@stop

@section('content')
<div class="navbar justify-content-end">
    <button class="btn btn-primary nav-item">
        <i class="fa fa-clipboard"></i> Nuevo Lote
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="navbar">
            <div>
                <h3>{{date('d-m-Y')}}</h3>
            </div>
            <div class="justify-content-end">
                <button class="btn btn-success nav-item">
                    <i class="fa fa-plus"></i> Nuevo Producto
                </button>
            </div>
        </div>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th rowspan="2"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{""}}</td>
                    <td>{{""}}</td>
                    <td>{{""}}</td>
                    <td>{{""}}</td>
                    <td><button class="btn btn-primary">editar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
