@extends('adminlte::page')
@section('content_header')
    <h1>Ventas Resagadas</h1>
@endsection
@php
    use App\Models\Transaction;
    $sales = Transaction::where('status', 1)
        ->whereRaw('Date(created_at) = ?', date('Y-m-d', strtotime('-1 day')))
        #->whereRaw('Date(created_at) = ?', date('Y-m-d'))
        ->get();
@endphp
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="table">
                <thead>
                    <th>Id</th>
                    <th>CI</th>
                    <th>Cliente</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->_customer != null ? $sale->_customer->ci : 'null' }}</td>
                            <td>{{ $sale->_customer != null ? $sale->_customer->name : 'null' }}</td>
                            <td>{{ $sale->total != null ? $sale->total : 0 }}</td>
                            <td>
                                <form method="post" action="{{route('personal.sale.refund',$sale->id)}}">
                                    @csrf
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                        Devolucion
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
