@extends('adminlte::page')
@section('plugins.Datatable', true)
@php
    use App\Models\Transaction;
    $sales = Transaction::where('status', 1)
        ->whereRaw('Date(created_at) = ?', date('Y-m-d'))
        ->get();
@endphp

@section('content_header')
    <h1>Ventas en Proceso</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <table class="table table-striped" id="table">
                <thead>
                    <th>Id</th>
                    <th>CI</th>
                    <th>Cliente</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a class="btn btn-warning" onclick="openDeliveryModal(null)">
                                    <i class="fa fa-motorcycle"></i> Delivery
                                </a>


                        </td>


                    </tr>
    
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->_customer != null ? $sale->_customer->ci : 'null' }}</td>
                            <td>{{ $sale->_customer != null ? $sale->_customer->name : 'null' }}</td>
                            <td>
                                <a class="btn btn-primary"
                                    onclick="valideTransaction({{ $sale->id }},{{ $sale->_customer->ci }})">
                                    <i class="fa fa-archive"></i>
                                    Entregar
                                </a>
                                <a class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Cancelar
                                </a>
                                <a class="btn btn-warning" onclick="openDeliveryModal({{ $sale->id }})">
                                    <i class="fa fa-motorcycle"></i> Delivery
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-modal id="mTransaction" title="Validar Transaccion">
        <div class="row justify-content-center">
            <img src="" alt="" id="qr" style="width: 200px;">
            <a class="btn btn-danger mt-1" onclick="closeTransaction()">Cancelar</a>
        </div>
    </x-modal>
    <x-modal id="mDelivery" title="Delivery a Domicilio">
    <div class="row justify-content-center p-3">
        <div class="col-12 text-center mb-2">
            <h5 style="font-weight: bold; color: #4e73df; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Conductores disponibles:
            </h5>
        </div>

        <div class="col-8">
            <select class="form-select text-center">
                <option disabled selected>Seleccione un delivery</option>
                <option>Delevery1</option>
                <option>Delivery2</option>
            </select>
        </div>

        <div class="col-12 text-center mt-3">
            <a class="btn btn-success me-2" onclick="assignDelivery()">Asignar</a>
            <a class="btn btn-secondary" onclick="closeDeliveryModal()">Cerrar</a>
        </div>
    </div>
</x-modal>
@endsection

@section('js')
    <script>
        var interval = null;


        var table = new DataTable('#table', {
            paging: false,
            language: {
                search: 'Filtrar'
            },
            columnDefs: [{
                targets: [3],
                orderable: false,
                searchable: false
            }],
            response: true
        });
        document.getElementById('table_info').classList.add('d-none');


        function valideTransaction(id, customer) {
            fetch('{{ route('personal.sale.genValide') }}' + '/' + id + '?' + 'customer=' + customer).
            then(response => response.json()).
            then(data => {
                document.getElementById('qr').src = "data:image/svg+xml;base64," + data.qrcode;
                const modal = new bootstrap.Modal(document.getElementById('mTransaction'));
                modal.show();
                interval = setInterval(() => {
                    fetch('{{ route('personal.sale.verifyTransaction') }}' + '?id=' + id).
                    then(response => response.json()).
                    then(data => {
                        if (data.message == 'ok') window.location.href =
                            '{{ route('admin.sale.inProcess') }}';
                    });
                }, 3000);
            }).catch(error => Swal.fire({
                title: "mmmm...",
                text: "Parece que hubo un error: " + error,
                icon: "error"
            }));
        };

        function closeTransaction() {
            clearInterval(interval);
            $('#mTransaction').modal('hide');
        }
        function openDeliveryModal(id) {
            const modal = new bootstrap.Modal(document.getElementById('mDelivery'));
            modal.show();
        }

        function closeDeliveryModal() {
            $('#mDelivery').modal('hide');
        }
        
    </script>
    
@endsection
