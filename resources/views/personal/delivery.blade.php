@extends('adminlte::page')


@section('content_header')
    <h1>Entrega Delivery</h1>
@endsection

@section('content')
<div class="d-flex justify-content-end mb-1">
        <button class="btn btn-success nav-item" type="submit">
            <i class="fa fa-check"></i>  Confirmar Entrega
        </button>
        <button class="btn btn-primary" type="submit">
            <i class="fa fa-map-marker-alt"></i> Ubicación
        </button>

</div>
<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Nombre Cliente</th>
                        <th>CI</th>
                        <th>Productos</th>
                        <th>Monto</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


@endsection


