@extends('adminlte::page')
@section('plugins.Datatable',true)

@section('title','Cliente')
@section('content_header')
<h1>Cliente</h1>
@endsection

@php
use App\Models\Person;
$customers=Person::paginate(10);
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table-striped table display" id="table">
            <thead>
                <tr>
                    <th>CI</th>
                    <th>Nombre</th>
                    <th>Cuenta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{$customer->ci}}</td>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->user ? 'si' : 'no'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
new DataTable('#table',
    {
        paging:false
    });
document.getElementById('table_info').classList.add('d-none');
</script>
@endsection
