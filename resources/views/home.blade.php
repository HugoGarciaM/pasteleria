@extends('layouts.app')

@php
    use App\Models\Category;
    use App\Models\Date;
    use App\Models\Product;
    $categories = Category::all();
    $batch = null;
    $stat='available';
    if($request!=null) $stat = $request->stat;
    if ($stat == 'available' && Date::first()!=null) {
        $batch = Date::first()->stockProducts(date('Y-m-d'));
    }
    else if ($stat == 'all') {
        if ($request->name != null && $request->category != null) {
            $batch = Product::where('name', 'like', '%' . $request->name . '%')
                ->where('category_id', $request->category)
                ->paginate(12);
        } elseif ($request->name != null) {
            $batch = Product::where('name', 'like', '%' . $request->name . '%')->paginate(12);
        } elseif ($request->category != null) {
            $batch = Product::where('category_id', $request->category)->paginate(12);
        } else {
            $batch = Product::where('status', 1)->paginate(12);
        }
    } else {
        abort(404);
    }
@endphp

@section('content')
    <div class="container">
        <h1>Catalogo de Productos</h1>
        <div class="row justify-content-center">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><b>Filtrar</b></h5>
                        <form method="get" action="{{route('home')}}">
                            <div class="input-group">
                                <span class="input-group-text">Nombre:</span>
                                <input type="text" name="name" value="{{$request->name}}" class="form-control" id="sname" disabled>
                                <div class="input-group-text">
                                    <input type="checkbox" class="form-check-input" onchange="statusInput('sname')">
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">Categoria:</span>
                                <select class="form-select" name="category" id="scat" disabled>
                                    <option value=null >Todo</option>
                                    @if ($categories!=null)
                                        @foreach ($categories as $category)
                                                <option value={{$category->id}}>{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="input-group-text">
                                    <input type="checkbox" class="form-check-input" onchange="statusInput('scat')">
                                </div>
                            </div>
                            <div class="form-check mt-1">
                                <input type="radio" class="form-check-input" value="available" name="stat" id="available">
                                <span class="form-check-label">Disponible</span>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="all" name="stat" id="all">
                                <span class="form-check-label">Todo</span>
                            </div>
                            <div class="d-flex justify-content-end mt-1">
                                <a href="{{route('home')}}" class="btn btn-danger">Restablecer</a>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#t" type="submit">
                                    <i class="nf nf-fa-search"></i> Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <div class="row" style="width: 100%;">
                        @if ($batch != null)
                            @foreach ($batch as $product)
                                @if ($stat == 'available')
                                    @if ($request->name!=null && $request->category!=null)
                                        @if (strchr($product->name,$request->name) == '' && $product->category_id!=$request->category)
                                            @break
                                        @endif
                                    @elseif($request->name!=null)
                                        @if(strchr($product->name,$request->name) == '')
                                            @break
                                        @endif
                                    @elseif($request->category!=null)
                                        @if($product->category_id!=$request->category)
                                            @break
                                        @endif
                                    @endif
                                @endif
                                <div class="col-md-3 mb-4 col-custom">
                                    <div class="card product">
                                        <div style="position: relative;">
                                            <img src="{{ asset('storage/product/' . $product->id) }}" class="card-img-top"
                                                style="height: 150px;">
                                            <div
                                                style="position: absolute;top: 70%;text-align: end;width: 100%;rotate:340deg;">
                                                <div class="badge text-bg-danger m-0 p-1"
                                                    style="border: solid;border-width: 1px;">
                                                    <h2 class="m-0 p-sm-1"
                                                        style="border:solid;border-radius: 5px;border-width: 2px;font-size: 25px;">
                                                        {{ $product->price }}Bs
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">
                                                <b>{{ $product->name }}</b>
                                            </h5>
                                            <div class="scrollable-paragraph">
                                                <p>{{ $product->description }}</p>
                                            </div>
                                        </div>
                                        <div class="card-footer mt-auto">
                                            <button class="btn btn-danger w-100" onclick="getProduct({{ $product->id }})">
                                                Ordenar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($stat != 'available')
                                <div class="d-flex justify-content-center">
                                    {{ $batch->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal id="modalBasket" title="Canasta">
        <form action="{{ route('personal.sale.register') }}" method="post" id="formSale">
            @csrf
            <input type="number" class="d-none" id="type" name="type">
            <input type="number" class="d-none" id="idq" name="pay">
            <input type="number" class="d-none" name="ci" value="{{auth()->user()->person->ci}}">
            <input type="text" class="d-none"  name="name" value="{{auth()->user()->person->name}}">
            <input type="text" name="data" class="d-none" id="data">
            <div id="part1" class="">
                <div>
                    <table class="table table-striped" id="tableProduct" style="width: 100%;">
                        <thead>
                            <th>Id</th>
                            <th>producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td><b>Total:</b></td>
                                <td id="total"></td>
                                <td>Bs</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <h5>Seleccione Ubicacion de Entrega:</h5>
                <div style="height: 400px;" id="map"></div>
                <div class="modal-footer">
                    <a onclick="online()" class="btn btn-success"><i class="nf nf-md-qrcode"></i> Pagar</a>
                </div>
            </div>
        </form>
        <div class="row justify-content-center d-none" id="part2">
            <h3>Por favor espere, no cierre ni recargue la pagina...</h3>
            <img src="" id="qr" style="width: 200px;">
            <a onclick="saveQR()" class="btn btn-primary mt-1">guardar QR</a>
            <a href="{{route('home')}}" class="btn btn-danger mt-1">Cancelar</a>
        </div>
    </x-modal>

    <x-modal id="modalOrder" title="Ordenar">
        <div class="contanier mb-1">
            <input class="d-none" id="productId">
            <div class="input-group">
                <span class="input-group-text">Producto</span>
                <input class="form-control" id="productName" disabled>
            </div>
            <div class="input-group">
                <span class="input-group-text">Precio</span>
                <input class="form-control" id="productPrice" disabled>
                <span class="input-group-text">Bs</span>
            </div>
            <div class="input-group">
                <span class="input-group-text" data-stock=1>Cantidad</span>
                <input class="form-control" id="productQuantity" type="number">
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="addProduct()" class="btn btn-danger"><i class="nf nf-fa-basket_shopping"></i> Añadir a
                Canasta</button>
        </div>
    </x-modal>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

        var imgQR;
        var interval=null;
        var total = document.getElementById('total');
        var idQr = null;
        var idQr2 = null;

        var map = L.map('map').setView([-17.96, -67.116],13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = null;
        var latlng = null;
        function getLatLong(e){
            if (marker != null) marker.remove();
            latlng = e.latlng;
            marker = L.marker([latlng.lat, latlng.lng]).addTo(map);
        }
        map.on('click',getLatLong);

        @if ($stat == 'available')
            document.getElementById('available').checked = true;
        @else
            document.getElementById('all').checked = true;
        @endif
        @if ($request->category !=null)
        document.getElementById('scat').value = {{$request->category}};
        @endif
        const Basket = document.getElementById('basket');
        var tableProduct;
        var total = 0;

        document.addEventListener('DOMContentLoaded', (event) => {
            tableProduct = new window.DataTable('#tableProduct', {
                paginate: false,
                searching: false,
                responsive: true,
                columnDefs: [{
                    data: null,
                    defaultContent: '<button class="btn btn-danger"><i class="nf nf-fa-trash"></i></button>',
                    targets: 5
                }, {
                    target: 0,
                    visible: false
                }]
            });


            tableProduct.on('click', 'button', function(e) {
                let row = tableProduct.row($(this).closest('tr'));
                let data = row.data();
                total -= parseInt(data[4]);
                document.getElementById('total').textContent = total;
                row.remove().draw();
            });

            document.getElementById('tableProduct_info').classList.add('d-none');
            const modal = new bootstrap.Modal(document.getElementById('modalBasket'));

            Basket.addEventListener('click', () => {
                modal.show();
            });
            const myModal = document.getElementById('modalBasket');
            myModal.addEventListener('shown.bs.modal', function () {
                map.invalidateSize(); // 'map' es la instancia de tu Leaflet
            });

            @if (session('status'))
                window.swal.fire({
                    title: "Información",
                    text: "{{ session('status') }}",
                    icon: "info"
                });
            @endif
        });


        function getProduct(id) {
            document.getElementById('productQuantity').value = "";
            let url = "{{ route('api.getProduct') }}";
            console.log(url);
            fetch(url + '?id=' + id).
            then(response => response.json()).
            then(data => {
                document.getElementById('productId').value = data.product.id;
                document.getElementById('productName').value = data.product.name;
                document.getElementById('productPrice').value = data.product.price;
                document.getElementById('productQuantity').placeholder = "Disponible: " + data.product.stock;
                document.getElementById('productQuantity').dataset.stock = data.product.stock;
                let modal = new bootstrap.Modal(document.getElementById('modalOrder'));
                modal.show();
            }).
            catch(error => {
                window.swal.fire({
                    title: 'Vaya...',
                    text: 'este Producto ya no esta Disponible',
                    icon: 'warning'
                });
            });
        }

        function addProduct() {
            let quantity = document.getElementById('productQuantity');
            if (quantity.value > 0 && quantity.value <= parseInt(quantity.dataset.stock)) {
                tableProduct.row.add([
                    document.getElementById('productId').value,
                    document.getElementById('productName').value,
                    document.getElementById('productQuantity').value,
                    document.getElementById('productPrice').value,
                    document.getElementById('productPrice').value * document.getElementById('productQuantity')
                    .value,
                ]).draw();
                window.swal.fire({
                    title: 'Genial',
                    text: 'se añadio correctamente a la Canasta',
                    icon: 'success'
                });
                total += document.getElementById('productPrice').value * document.getElementById('productQuantity').value;
                document.getElementById('total').textContent = total;
                $("#modalOrder").modal("hide");
            } else {
                window.swal.fire({
                    title: 'Vaya...',
                    text: 'Parece que la cantidad no es la correcta',
                    icon: 'warning'
                });
            }
        }

        function statusInput(id){
            let element = document.getElementById(id);
            element.disabled = element.disabled==true ? false : true;
        }


        function sendSale() {
            let data = [];
            if (tableProduct.rows().data().toArray().length <= 0) {
                return window.swal.fire({
                    title: "Vacio?...",
                    text: "Parece que la lista esta vacia!",
                    icon: "warning"
                });
            }
            for (i = 0; i < tableProduct.rows().data().toArray().length; i++) {
                let p = {
                    id: parseInt(tableProduct.rows(i).data().toArray()[0][0]),
                    price: parseFloat(tableProduct.rows(i).data().toArray()[0][3]),
                    quantity: parseInt(tableProduct.rows(i).data().toArray()[0][2])
                }
                data.push(p)
            }
            document.getElementById('data').value = JSON.stringify(data);
            let form = document.getElementById('formSale');
            form.submit();
        }

        function online() {
            {{-- console.log(); --}}
            {{-- return; --}}
            if (tableProduct.rows().data().length == 0) {
                return window.swal.fire({
                    title: "Vacio?...",
                    text: "Parece que la lista esta vacia!",
                    icon: "warning"
                });
            }
            document.getElementById('type').value = 1;
            fetch('{{ route('paymentQR') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    quantity: parseInt(document.getElementById('total').textContent)
                })
            }).then(response => response.json()).
            then(data => {
                document.getElementById('part2').classList.remove('d-none');
                document.getElementById('part1').classList.add('d-none');
                document.getElementById('qr').src = "data:image/svg+xml;base64," + data.qrcode;
                imgQR = data.qrcode;
                idQr = data.id;
                idQr2 = data.idq;
                document.getElementById('idq').disabled = false;
                document.getElementById('idq').value = idQr2;
                console.log('el id es: ' + idQr);
                inteval = setInterval(function() {
                    fetch('{{ route('statusQR') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id: idQr,
                            idq: idQr2
                        })
                    }).then(response => response.json()).
                    then(data => {
                        console.log("el estado es: " + data.status + " " + data.message);
                        if (data.status == true) {
                            clearInterval(interval);
                            sendSale();
                        }
                    });
                }, 3000);
            }).catch(error => {
                console.log('este es el error: ' + error);
                window.swal.fire({
                    title: "Hubo...",
                    text: "Parece que hubo un error",
                    icon: "error"
                })
            });
        }

        function saveQR(){
            const imgBase64 = document.getElementById('qr').src;

            // Convertir base64 a Blob
            const byteString = atob(imgBase64.split(',')[1]);
            const mimeString = imgBase64.split(',')[0].split(':')[1].split(';')[0];
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            const blob = new Blob([ab], {type: mimeString});

            // Crear un enlace temporal
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'imagen.svg';

            // Agregar el enlace temporal al DOM y hacer clic en él
            document.body.appendChild(link);
            link.click();

            // Eliminar el enlace temporal del DOM
            document.body.removeChild(link);

            // Liberar el objeto URL
            URL.revokeObjectURL(link.href);
        }

    </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
.product {
    height: 450px;
    {{-- width: 25%; --}} margin: 3px;
}

        .scrollable-paragraph {
            height: 180px;
            overflow-y: auto;
        }

        .scrollable-paragraph::-webkit-scrollbar {
            width: 3px;
        }

        .scrollable-paragraph::-webkit-scrollbar-track {
            background-color: #202324;
        }

        .scrollable-paragraph::-webkit-scrollbar-thumb {
            background-color: #454a4d;
        }

        @media(max-width: 884px) {
            .scrollable-paragraph {
                height: auto;
                max-height: 180px;
            }

            .col-custom {
                flex: 0 0 33%;
                max-width: 33%;
            }
        }

        @media(max-width:430px) {
            .product {
                height: 370px;
            }

            .scrollable-paragraph {
                height: auto;
                max-height: 100px;
            }

            .col-custom {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
</style>
@endsection
