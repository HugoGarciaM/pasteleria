@extends('adminlte::page')

@section('content_header')
<h1>Configuracion</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title"><strong>Cuenta Bancaria</strong></h5>
        <div class="input-group">
            <span class="input-group-text">Banco:</span>
            <input type="text" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">N° Cuenta:</span>
            <input type="number" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Usuario:</span>
            <input type="email" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Contraseña:</span>
            <input type="password" class="form-control">
        </div>
        <div class="btn-toolbar justify-content-end" style="margin-top: 5px;">
            <div class="btn-group ">
                <a href="#" class="btn btn-primary">Probar Acceso</a>
                <a href="#" class="btn btn-success" >Guardar</a>
            </div>
        </div>
    </div>
</div>
@endsection
