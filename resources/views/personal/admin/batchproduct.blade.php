@extends('adminlte::page')
@section('title','Lotes')

@section('content_header')
<h1>Lote por Dia</h1>
@stop

@section('content')
<div class="navbar justify-content-end">
    <form method="post" action="{{route('admin.batch.create')}}">
        @csrf
        <input value="{{date('Y-m-d')}}" name="date" class="d-none">
        <button class="btn btn-success nav-item" type="submit">
            <i class="fa fa-clipboard"></i> Nuevo Lote
        </button>
    </form>
</div>

@php
use App\Models\Date;
use App\Models\Product;

$dates=Date::orderBy('event_day','desc')->paginate(10);
$products=Product::where('status',1)->get();
@endphp

@foreach ($dates as $day)


<div class="card">
    <div class="card-body">
        <div class="navbar">
            <div>
                {{-- <h3>{{date('d-m-Y')}}</h3> --}}
                <h5>{{$day->event_day}}</h5>
            </div>
            <div class="justify-content-end">
                @if ($day->event_day==date('Y-m-d'))
                <button class="btn btn-success nav-item" data-bs-toggle='modal' data-bs-target='#addProduct' onclick="selectDate('form-create','{{$day->id}}')">
                    <i class="fa fa-plus"></i> Nuevo Producto
                </button>
                @endif
            </div>
        </div>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th rowspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($day->products as $detail)
                <tr>
                    <td>{{$detail->id}}</td>
                    <td>{{$detail->product->name}}</td>
                    <td>{{$detail->product->price}}</td>
                    <td>{{$detail->quantity}}</td>
                    @if ($day->event_day==date('Y-m-d'))
                    <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProduct" onclick="editUpdate('editP','{{$detail->product->name}}',{{$detail->id}},'form-edit')">editar</button>
                        <form class="d-inline" method="post" action="{{route('admin.batch.product.delete',$detail->id)}}">
                            @csrf
                            <button class="btn btn-danger"  type="submit">eliminar</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endforeach
<div>
    {{$dates->links()}}
</div>

<x-modal title="actualizacion" id="editProduct">
    <form method="post" action="" id="form-edit">
        @csrf
        <div class="input-group">
            <span class="input-group-text">Producto</span>
            <input class="form-control" id="editP" disabled>
        </div>
        <div class="input-group">
            <span class="input-group-text">Cantidad</span>
            <input class="form-control" name="quantity" type="number" min="1">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" >Guardar</button>
        </div>
    </form>
</x-modal>

<x-modal title="Nuevo Producto" id="addProduct">
    <form method="post" action="#" id="form-create">
        @csrf
        <div class="input-group">
            <span class="input-group-text">Id</span>
            <input class="form-control" type="number" id="idProduct" name="idp" value="1">
            <a class="btn btn-primary" onclick="searchSelect('select','idProduct')">
                <i class=" fa fa-search"></i>
            </a>
        </div>
        <div class="input-group">
            <span class="input-group-text">Nombre</span>
            <select class="form-select" id="select" onchange="searchSelect('idProduct','select')">
                @foreach ($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group">
            <span class="input-group-text">cantidad</span>
            <input class="form-control" name="quantity" type="number" min="1">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" >Guardar</button>
        </div>
    </form>
</x-modal>


@error('idp')
<x-toast title="Error" id="errorIdp" colorscheme="text-bg-danger">
    {{$message}}
</x-toast>
@enderror

@error('date')
<x-toast title="Error" id="errorDate" colorscheme="text-bg-danger">
    {{$message}}
</x-toast>
@enderror

@error('quantity')
<x-toast title="Error" id="errorQuantity" colorscheme="text-bg-danger">
    {{$message}}
</x-toast>
@enderror

@endsection

@section('js')
<script>
function searchSelect($selector,$value){
    document.getElementById($selector).value=document.getElementById($value).value;
}

function selectDate(form,day){
    document.getElementById(form).action="{{route('admin.batch.product.create','')}}"+"/"+day;
}

function editUpdate(id,value,idp,form){
    document.getElementById(id).value=value;
    document.getElementById(form).action="{{route('admin.batch.product.update','')}}"+"/"+idp;
}
</script>
@endsection
