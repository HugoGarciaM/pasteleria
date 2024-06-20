@extends('adminlte::page')
@php
use App\Models\Business_info;
$info = Business_info::first();
@endphp

@section('content_header')
    <h1>Configuracion</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><strong>Configuraciones</strong></h5>
            <form method="post" action="{{ route('settings.saveBank') }}">
                @csrf
                <div class="input-group">
                    <span class="input-group-text">Banco:</span>
                    <input type="text" class="form-control" value="{{ $info!=null ? $info->bank : ""}}" name="bank">
                </div>
                <div class="input-group">
                    <span class="input-group-text">N° Cuenta:</span>
                    <input type="number" class="form-control" value="{{ $info!=null ? $info->number_account : ""}}" name="account">
                </div>
                <div class="input-group">
                    <span class="input-group-text">Token:</span>
                    <input type="text" class="form-control" name="token" id="token">
                </div>
                <div class="input-group">
                    <span class="input-group-text">Pocentaje de Devolucion:</span>
                    <input type="number" class="form-control" name="refund" value={{ $info!=null ? ($info->refund!=null ? $info->refund : 0) : 0}}>
                    <span class="input-group-text">%</span>
                </div>
                <div class="btn-toolbar justify-content-end" style="margin-top: 5px;">
                    <div class="btn-group ">
                        <a class="btn btn-primary" onclick="test()">Probar Acceso</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function test() {
            let url = "{{ route('settings.testBank') }}";
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                        'X-CSRF-Token': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        token: document.getElementById('token').value
                    })
                }).then(response => {
                    if (response.ok)
                        window.swal.fire({
                            title: 'Perfecto',
                            text: 'tenemos conexion',
                            icon: 'success'
                        });
                    else
                        window.swal.fire({
                            title: 'Vaya...',
                            text: 'parece que no hay conexion',
                            icon: 'error'
                        });
                })
                .catch(error => alert(error));
        }
    </script>
@endsection
