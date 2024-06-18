@php
    use App\Models\Transaction;
    $transactions = Transaction::whereRaw('Date(created_at) = ?', date('Y-m-d'))
        ->where('seller', auth()->user()->id)
        ->paginate(10);
@endphp

@extends('adminlte::page')
@section('plugins.Datatable', true)

@section('content_header')
    <h1>Ventas Realizadas</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tableSale">
                <thead>
                    <th>Id</th>
                    <th>CI</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->_customer == null ? 'No Disponible' : $transaction->_customer->id }}</td>
                            <td>{{ $transaction->_customer == null ? 'No Disponible' : $transaction->_customer->name }}</td>
                            <td>
                                <a href="{{ route('personal.sale.pdf', $transaction->id) }}" class="btn btn-primary">
                                    <i class="fa fa-info"></i>
                                    Detalle
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>


@endsection


@section('js')
    <script>
        let table = new DataTable('#tableSale', {
            paging: false,
            language: {
                search: 'Filtrar:'
            },
            columnDefs: [{
                targets: [3],
                orderable: false,
                searchable: false
            }],
            response: true
        });

        document.getElementById('tableSale_info').classList.add('d-none');
    </script>
@endsection
