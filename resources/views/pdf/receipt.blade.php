@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF</title>
        <style>
            *{
                margin: 0;
                padding: 0;
            }
            td,th{
                text-align: right;
                max-width: 120px;
            }
            th:first-child,td:first-child{
                text-align: left;
            }
        </style>
    </head>
    <body style="display: flex;justify-content: center;">
        <div style="display: flexbox;">
            <div style="width: auto;height: auto;padding-top: 10px;">
                <div style="padding: 0 20px;">
                    <div style="text-align: center;">
                        <img src="data:image/png;base64,{{base64_encode(Storage::drive('public')->get('logo-bn.png'))}}" alt="logo" style="height: 75px;width: 75px;">
                    </div>
                    <h4 style="text-align: center;">RECIBO</h4>
                    <h6 style="text-align: center;">N°{{(isset($id) ? $id : "null")}}</h6>
                    <hr>
                    <p>CI: {{(isset($ci) ? $ci : "null")}}</p>
                    <p>Nombre: {{(isset($name) ? $name : "null")}}</p>
                    <hr>
                    <p>Forma de Pago: {{(isset($payment) ? $payment : "null")}}</p>
                    <p>Fecha: {{(isset($timestamps) ? $timestamps : "null")}}</p>
                    <hr>
                    <table style="width: 100%;border-collapse: collapse;">
                        <thead style="border-bottom: solid;border-color: black;">
                            <th>producto</th>
                            <th>cant</th>
                            <th>precio</th>
                            <th>sub</th>
                        </thead>
                        <tbody style="border-bottom: solid;">
                            @foreach ($details as $detail)
                            <tr>
                                <td>{{$detail->product->name}}</td>
                                <td>{{$detail->price}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>{{($detail->quantity*$detail->price)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold;">
                                <td colspan="3">TOTAL</td>
                                <td>100</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div style="border-bottom: solid;border-top: solid;padding: 5px 0;">
                        <p><strong>Cajero: </strong>{{(isset($seller) ? $seller : "null")}}</p>
                    </div>
                    <div style="text-align: center; margin: 5px 0;">
                        <img src="data:image/png;base64,{{ base64_encode($qr) }}" alt="Código QR">
                    </div>
                    <div style="text-align: center;">
                        <p>¡Gracias por su Compra!</p>
                    </div>
                </div>
            </div>
            <div style="height: 80px;width: auto;">
            </div>
        </div>
    </body>
</html>
