@extends('adminlte::page')

@php
use App\Models\Detail_product;
use App\Models\Product;
use App\Models\Date;
$batch = Date::first() != null ? Date::first()->stockProducts(date('Y-m-d')) : null;


$sellerId = Auth::user()->id;

$dailySalesBySeller = Detail_product::join('transactions', 'detail_products.transaction_id', '=', 'transactions.id')
->where('transactions.seller', $sellerId)
->selectRaw('DATE(transactions.created_at) as date, SUM(detail_products.quantity) as total_quantity, SUM(detail_products.quantity * detail_products.price) as total_revenue')
->groupBy('date')
->orderBy('date', 'desc')
->first();
@endphp


@section('title','Principal')

@section('content_header')
<h1>Dashboard</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-content">
        <div class="d-flex p-3 justify-content-between">
            <div class="card bg-success" style="width: 49%;">
                <div class="card-content p-2">
                    <h1 class="d-inline">
                        <i class="fa fa-wallet"></i>
                    </h1>
                    <h3 class="d-inline">Total: {{$dailySalesBySeller->total_quantity}}</h3>
                </div>
            </div>

            <div class="card bg-primary" style="width: 49%;">
                <div class="card-content p-2">
                    <h1 class="d-inline">
                        <i class="fa fa-cookie"></i>
                    </h1>
                    <h3 class="d-inline">Cantidad: {{$dailySalesBySeller->total_revenue}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Productos Disponibles</h5>
        <div>
            <table class="table table-striped">
                <thead>
                    <th>Id</th>
                    <th>Product</th>
                    <th>Stock</th>
                </thead>
                <tbody>
                    @if ($batch!=null)
                    @foreach ($batch as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->stock}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
