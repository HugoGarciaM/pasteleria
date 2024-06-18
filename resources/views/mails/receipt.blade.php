@extends('layouts.mail')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{$title}}</h5>
    </div>
    <div class="card-body">
        <p>Gracias por su Compra.<br></p>
    </div>
    <div class="card-footer">
        <p>Atentamente</p>
        <p>Pasteleria Pepita</p>
    </div>
</div>

@endsection

