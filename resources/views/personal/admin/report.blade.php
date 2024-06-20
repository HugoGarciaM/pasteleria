@extends('adminlte::page')
@php
    use App\Models\User;
@endphp
@section('content_header')
<h1>Reportes</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div>
            <div class="row justify-content-center">
                <div class="">
                    <div id="histoDia" style="width: 95%; height: 400px;">
                        <!-- El gráfico se renderizará aquí -->
                    </div>
                </div>
                <div class="">
                    <table class="table table-striped">
                        <thead>
                            <th>Id</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>$</th>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                            <tr>
                                <td>{{$item->product->id}}</td>
                                <td>{{$item->product->name}}</td>
                                <td>{{$item->total_quantity}}</td>
                                <td>{{$item->total_revenue}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div>
            <div class="row justify-content-center">
                <div class="">
                    <div id="histoGan" style="width: 95%; height: 400px;">
                        <!-- El gráfico se renderizará aquí -->
                    </div>
                </div>
                <div class="">
                    <table class="table table-striped">
                        <thead>
                            <th>CI</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>$</th>
                        </thead>
                        <tbody>
                            @foreach ($top as $item)
                            <tr>
                                <td>{{$item->customer_id}}</td>
                                @php
                                $u=User::find($item->customer_id);
                                @endphp
                                <td>{{$u->person->name}}</td>
                                <td>{{$item->total_quantity}}</td>
                                <td>{{$item->total_revenue}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
window.onload = function () {
    var dataPoints = @json($dataPoints);

    var chart = new CanvasJS.Chart("histoDia", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1", // "light1", "light2", "dark1", "dark2"
        title:{
            text: "Transacciones por Fecha"
        },
        data: [{
            type: "column",
            dataPoints: dataPoints
        }]
    });
    chart.render();


    var dataPoints1 = @json($dataPoints1);
    var chart1 = new CanvasJS.Chart("histoGan", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1", // "light1", "light2", "dark1", "dark2"
        title:{
            text: "Ganancias por Fecha"
        },
        data: [{
            type: "column",
            dataPoints: dataPoints1
        }]
    });
    chart1.render();
}
</script>
@endsection
