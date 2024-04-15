@extends('layouts.mail')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{$title}}</h5>
    </div>
    <div class="card-body">
        <p>Se le da la bienvenida a la Pasteleria Pepita y sus respectivas credenciales para el acceso al sistema.<br></p>
        <p>Rol: <strong>{{$user->role==1 ? 'Gerente' : 'Personal'}}</strong></p>
        <p><strong>Email: </strong>{{$user->email}}</p>
        <p><strong>Constraseña: </strong><a href="{{$url}}">Establecer Contraseña</a></p>
    </div>
    <div class="card-footer">
        <p>Atentamente</p>
        <p>Pasteleria Pepita</p>
    </div>
</div>

@endsection

