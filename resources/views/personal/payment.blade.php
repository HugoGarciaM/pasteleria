@extends('layouts.app')
@php
$url=url()->current();
if($url==url('/sale')) $url=route('admin.sale');
else $url=url()->previous();
@endphp

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body d-flex flex-column justify-content-center">
            <iframe src="{{route('personal.sale.genPdf',$transaction)}}" style="width: 100%;height: 500px;"></iframe>
            <a href="{{$url}}" class="btn btn-primary">volver</a>
        </div>
    </div>
</div>
@endsection
