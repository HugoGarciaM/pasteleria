@extends('adminlte::page')
@section('plugins.Datatable',true)

@php
use App\Models\Product;
use App\Models\Date;
#$products=Product::all();
#$batch=Date::orderBy('id','desc')->first();
#$batch=Date::where('event_day',date('Y-m-d'))->first();
$batch=Date::first()->stockProducts(date('Y-m-d'));
@endphp
@section('content_header')
<h1>Registrar Venta</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('personal.sale.registerOffline')}}" method="post" id="formSale">
            @error('data')
                <x-toast title="Error" id="errorData" colorscheme="text-bg-danger">
                    {{$message}}
                </x-toast>
            @enderror
            @error('id')
                <x-toast title="Error" id="errorIdP" colorscheme="text-bg-danger">
                    {{$message}}
                </x-toast>
            @enderror
            @error('price')
                <x-toast title="Error" id="errorPrice" colorscheme="text-bg-danger">
                    {{$message}}
                </x-toast>
            @enderror
            @error('quantity')
                <x-toast title="Error" id="errorQuantity" colorscheme="text-bg-danger">
                    {{$message}}
                </x-toast>
            @enderror
            @csrf
            <h5>Cliente</h5>
            <div class="input-group">
                <span class="input-group-text">CI</span>
                <input type="number" class="form-control" id="personCi" name="ci">
                <a class="btn btn-primary" onclick="searchPerson()">
                    <i class=" fa fa-search"></i>
                </a>
            </div>
            <div class="input-group">
                <span class="input-group-text">Nombre</span>
                <input type="text" class="form-control" id="personName" name="name">
            </div>
            <hr>
            <div class="d-flex">
                <div class="" style="width: 87%;">
                    <input type="text" name="data" class="d-none" id="data">
                    <table id="TableProduct" class="table table-striped" style="width: 100%;">
                        <thead>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <th colspan="3"></th>
                            <th>Total</th>
                            <td id="total">0</td>
                        </tfoot>
                    </table>
                </div>
                <div class="container d-grid" style="width: 13%;padding-right: 1px;  height: 300px;">
                    <a class="btn btn-success btn-lg" id="btnAdd" data-bs-toggle="modal" onclick="searchSelect('selectProduct','idProduct',1)" data-bs-target="#addProduct">
                        <i class="fa fa-plus"></i>
                        Añadir
                    </a>
                    <a id="btnRemove" onclick="removeProduct()" class="btn btn-danger btn-lg">
                        <i class="fa fa-trash"></i><br>
                        Quitar
                    </a>
                    <a id="btnFinish" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#payment">
                        <i class="fa fa-check"></i>
                        Finalizar
                    </a>
                    <a id="btnCleanAll" href="" class="btn btn-secondary btn-lg">
                        <i class="fa fa-eraser"></i>
                        limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


<x-modal id="addProduct" title="Producto">
    <div class="input-group">
        <span class="input-group-text">Id</span>
        <input id="idProduct" type="number" class="form-control" value="1" onchange="searchSelect('selectProduct','idProduct')">
        <a class="btn btn-primary" onclick="searchSelect('selectProduct','idProduct')">
            <i class=" fa fa-search"></i>
        </a>
    </div>
    <div class="input-group">
        <span class="input-group-text">Nombre</span>
        <select id="selectProduct" class="form-select" onchange="searchSelect('idProduct','selectProduct')">
            @if ($batch!=null)
                @foreach ($batch as $product)
                <option data-stock="{{$product->stock}}" data-price="{{$product->price}}" value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="input-group">
        <span  class="input-group-text">Cantidad</span>
        <input id="quantityProduct" class="form-control" type="number" min="1" onchange="verifyStock()">
        <span class="input-group-text">Precio</span>
        <input id="priceProduct" class="form-control" type="number" readonly value="0">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertProduct()">Añadir</button>
    </div>
</x-modal>

<x-modal id="payment" title="Metodo de Pago">
    <div class="d-flex justify-content-center">
        <button class="btn btn-success" style="width: 50%;" onclick="offline()">
            <i class="fa fa-money-bill fs-1"></i>
            <h5>Efectivo</h5>
        </button>
        <button class="btn btn-primary" style="width: 50%;">
            <i class="fa fa-qrcode fs-1"></i>
            <h5>QR</h5>
        </button>
    </div>
</x-modal>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

<script>

var tableProduct=new DataTable('#TableProduct',{
paginate:false,
select:true,
select:{style:'single'},
searching:false,
scrollX:true,
scrollY:'220px',
responsive:true
});

document.getElementById('TableProduct_info').classList.add('d-none');

var personCi = document.getElementById('personCi');
var personName = document.getElementById('personName');
var select = document.getElementById('selectProduct');
var valores = Array.from(select.options).map(option => option.value);
var total=document.getElementById('total');
var idProduct=document.getElementById('idProduct');
var selectProduct=document.getElementById('selectProduct');
var quantityProduct=document.getElementById('quantityProduct');
var priceProduct=document.getElementById('priceProduct');

function insertProduct(){
    verifyStock();
    let v=true;
    if(!idProduct.value.trim()) v=false;
    if(!selectProduct.value.trim()) v=false;
    if(!quantityProduct.value.trim()) v=false;
    if(v){
        tableProduct.row.add([
            idProduct.value,
            selectProduct.options[selectProduct.selectedIndex].textContent,
            quantityProduct.value,
            priceProduct.value,
            priceProduct.value*quantityProduct.value
        ]).draw();
        total.textContent=parseInt(total.textContent)+quantityProduct.value*priceProduct.value;
        let product = select.options[select.selectedIndex];
        product.dataset.stock=parseInt(product.dataset.stock) - quantityProduct.value;
    }else{
        Swal.fire({title: "Hubo un Error",text: "uno o varios campos no fueron llenados",icon:"warning"});
    }
}

function removeProduct(){
    let rows=tableProduct.rows( { selected: true } ).data();
    for(let i=0;i<rows.length;i++){
        total.textContent=parseInt(total.textContent)-rows[i][4];
        let index=rows[i][0];
        select.value=parseInt(index);
        let product = select.options[select.selectedIndex];
        product.dataset.stock=parseInt(product.dataset.stock)+parseInt(rows[i][2]);
    }
    tableProduct.rows('.selected').remove().draw();
}

function searchSelect(selector, value,load=null) {
    document.getElementById(selector).value = load===null ? document.getElementById(value).value : 1;
    if (valores.indexOf(document.getElementById('idProduct').value) !== -1) {
        let product = select.options[select.selectedIndex];
        document.getElementById('priceProduct').value = product.dataset.price || 0;
    } else {
        document.getElementById('priceProduct').value = 0;
    }
}

function verifyStock(){
    let product = select.options[select.selectedIndex];
    if(quantityProduct.value<=0 || quantityProduct.value>parseInt(product.dataset.stock)){
        Swal.fire({title: "Ups...",text: "Parece que no hay stock! (stock: "+product.dataset.stock+")",icon:"warning"});
        quantityProduct.value=null;
    }
}

function searchPerson(){
    fetch("{{route('api.getPerson')}}" +'/'+personCi.value).
        then(response => {
            return response.json();
        }).then(data => {
            personName.value=data.person.name;
        }).catch(error =>{
            Swal.fire({title: "Ups...",text: "Parece que algo salio mal!",icon:"error"});
        });
}

function sendSale(){
    let data=[];
    if(tableProduct.rows().data().toArray().length<=0){
        return Swal.fire({title: "Vacio?...",text: "Parece que la lista esta vacia!",icon:"warning"});
    }
    for(i=0;i<tableProduct.rows().data().toArray().length;i++){
        let p={
            id: parseInt(tableProduct.rows(i).data().toArray()[0][0]),
            price: parseFloat(tableProduct.rows(i).data().toArray()[0][3]),
            quantity: parseInt(tableProduct.rows(i).data().toArray()[0][2])
        }
        data.push(p)
    }
    document.getElementById('data').value=JSON.stringify(data);
    let form=document.getElementById('formSale');
    form.submit();
}

function offline(){
    let form=document.getElementById('formSale');
    form.action="{{route('personal.sale.registerOffline')}}";
    sendSale();
}

</script>
@endsection

@section('css')
<style>
body::-webkit-scrollbar{
    display: none;
}
@media(max-width :950px){
    #btnAdd{
        font-size: small;
        padding: 0;
    }
    #btnFinish{
        padding: 0;
        font-size: small;
    }
    #btnRemove{
        padding: 0;
        font-size: small;
    }
    #btnCleanAll{
        padding: 0;
        font-size: small;
    }
}
</style>
@endsection
