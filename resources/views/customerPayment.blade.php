@extends('layouts.app')

@php
    use App\Models\Transaction;
    use App\Enums\Status;
    $transactions = Transaction::where('customer', auth()->user()->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    $total = 0;
@endphp

@section('content')
    <h3 style="margin-left: 12px;">Mis Compras</h3>
    <div class="m-2">
        <div class="d-flex justify-content-end mx-3">
            <a class="btn btn-danger" id="onCamera">
                <i class="nf nf-fa-bag_shopping"></i>
                Recoger Compra
            </a>
        </div>
        @if ($transactions != null)
            @foreach ($transactions as $transaction)
                <div class="card m-3">
                    <div class="card-body">
                        <div class="input-group">
                            <span class="input-group-text">Id</span>
                            <input class="form-control" type="text" value="{{ $transaction->id }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Fecha</span>
                            <input class="form-control" type="date"
                                value="{{ date('Y-m-d', strtotime($transaction->created_at)) }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Estado</span>
                            @php
                                $status = null;
                                $color = null;
                                switch ($transaction->status) {
                                    case Status::ENABLE:
                                        $status = 'Activo';
                                        $color = 'bg-success';
                                        break;
                                    case Status::DISABLE:
                                        $status = 'Desactivado';
                                        $color = '';
                                        break;
                                    case Status::FAILLED:
                                        $status = 'Fallido';
                                        $color = 'bg-danger';
                                        break;
                                }
                            @endphp
                            <input class="form-control {{ $color }}" type="text" value="{{ $status }}"
                                disabled>
                        </div>
                        <hr>
                        <h5 class="m-2">Detalle</h5>
                        <table class="table table-striped">
                            <thead>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($transaction->details as $product)
                                    <tr>
                                        @php
                                            $total += $product->quantity * $product->price;
                                        @endphp
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th></th>
                                <th>Total</th>
                                <th>{{ $total }}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-center">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <x-modal id="mTransaction" title="Validar Transaccion">
        <div id="part1">
            <div id="reader" width="600px">
            </div>
            <div class="row mt-1">
                <a id="closeModal" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
        <div id="part2" class="d-none">
            <div class="input-group">
                <span class="input-group-text">Id</span>
                <input class="form-control" type="number" value="" id="id" readonly>
            </div>
                <input class="d-none" type="number" value="" id="seller" readonly>
            <div class="row mt-1 mx-1">
                <a class="btn btn-success" id="btnSuccess">Recoger</a>
                <a class="btn btn-danger" id="btnCancel">Cancelar</a>
            </div>
        </div>
    </x-modal>

@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        var inteval = null;
        var html5QrcodeScanner = null;

        function onScanSuccess(decodedText, decodedResult) {
            console.log(decodedText);
            html5QrcodeScanner.clear();
            try {
                let qrData = JSON.parse(decodedText);
                if (qrData.id === undefined || qrData.customer === undefined || qrData.customer !=
                    "{{ auth()->user()->person->ci }}")
                    Swal.fire({
                        title: "Vaya...",
                        text: "Parece que este QR no es Valido",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entiendo"
                    }).then((result) => {
                        window.location.href = "{{ route('payments') }}";
                    });
                document.getElementById('id').value = qrData.id;
                document.getElementById('seller').value = qrData.seller;
                document.getElementById('part1').classList.add('d-none');
                document.getElementById('part2').classList.remove('d-none');
                {{-- document.getElementById('bt').click(); --}}

            } catch (e) {
                return Swal.fire({
                    title: "Vaya...",
                    text: "Parece que este QR no es Valido",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Entiendo"
                }).then((result) => {
                    window.location.href = "{{ route('payments') }}";
                });
            }
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        function activeCamera() {
            html5QrcodeScanner = new window.Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                }
            );

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        let btnCamera = document.getElementById('onCamera');
        let btnClose = document.getElementById('closeModal');
        let btnSuccess = document.getElementById('btnSuccess');
        let btnCancel = document.getElementById('btnCancel');
        btnCamera.addEventListener('click', () => {
            const modal = new bootstrap.Modal(document.getElementById('mTransaction'));
            modal.show();
            activeCamera();
        });
        btnClose.addEventListener('click', () => {
            $('#mTransaction').modal('hide');
            html5QrcodeScanner.clear();
            document.getElementById('part2').classList.add('d-none');
            document.getElementById('part1').classList.remove('d-none');
        });
        btnCancel.addEventListener('click', () => {
            $('#mTransaction').modal('hide');
            html5QrcodeScanner.clear();
            document.getElementById('part2').classList.add('d-none');
            document.getElementById('part1').classList.remove('d-none');
        });
        btnSuccess.addEventListener('click', () => {
            fetch('{{ route('payments.desactive') }}' + '?id=' + document.getElementById('id').value+'&seller='+document.getElementById('seller').value).
            then(response => response.json()).
            then(data => {
                if (data.message == 'ok') window.location.href = '{{ route('payments') }}';
                else {
                    return Swal.fire({
                        title: "Vaya...",
                        text: "Parece que hubo un error.",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entiendo"
                    }).then((result) => {
                        window.location.href = "{{ route('payments') }}";
                    });
                }
            }).catch(() => {
                Swal.fire({
                    title: "Vaya...",
                    text: "Parece que hubo un error.",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Entiendo"
                }).then((result) => {
                    window.location.href = "{{ route('payments') }}";
                });
            });
        });
    </script>
@endsection
