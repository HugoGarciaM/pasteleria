@extends('adminlte::page')
@section('plugins.Datatable',true)

@section('content_header')
<h1>Empleado</h1>
@endsection

@php
use App\Models\User;
use App\Enums\Role;
$employees=User::paginate(10);
$i=0;
@endphp

@section('content')
<div class="navbar justify-content-end">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate" onclick="typeForm('form-employee')">
        <i class="fa fa-plus"></i>
        Nuevo Empleado
    </button>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Lista Empleados</h5>
        <table id="myTable" class="table table-striped" style="with:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                <tr id="tr{{$i++}}">
                    <td>{{$employee->id}}</td>
                    <td>{{$employee->surname}}</td>
                    <td>{{$employee->name}}</td>
                    <td>{{$employee->email}}</td>
                    <td>{{($employee->role == Role::ADMIN ? 'Gerente' : 'Personal')}}</td>
                    <td>
                        <div>
                            <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#modalCreate" onclick="typeForm('form-employee','tr{{$i-1}}')">Editar</button>
                            <form class="d-inline" action="{{route('admin.employee.delete',$employee->id)}}" method="post">
                                @csrf
                                <button class="btn btn-danger" type="submit">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$employees->links()}}
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Horario</h5>
    </div>
</div>

<x-modal title="Nuevo Empleado" id="modalCreate">
    <form  id="form-employee" method="post" action="{{route('admin.employee.create')}}">
        @csrf
        <div class="input-group">
            <span class="input-group-text">Apellido</span>
            <input class="form-control" type="text" name="surname" id="surname">
        </div>
        <div class="input-group">
            <span class="input-group-text">Nombre</span>
            <input class="form-control" type="text" name="name" id="name">
        </div>
        <div class="input-group">
            <span class="input-group-text">Email</span>
            <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="input-group">
            <span class="input-group-text">Rol</span>
            <select class="form-select" name="role" id="role">
                <option value="2" selected >Personal</option>
                <option value="1">Gerente</option>
            </select>
        </div>
        <div class="input-group" id="div-password">
            <span class="input-group-text">Contraseña</span>
            <input type="password" class="form-control">
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</x-modal>



@error('name')
<x-toast title="Error" id="errorName" colorscheme="text-bg-danger">
    {{$message}}
</x-toast>
@enderror
@error('surname')
<x-toast title="Error" id="errorSurname" colorscheme="text-bg-danger">
    {{$message}}
</x-toast>
@enderror
@error('email')
<x-toast title="Error" id="errorEmail" colorscheme="text-bg-danger">
    {{$message}}
</x-toast>
@enderror

@endsection

@section('js')
<script>
    new DataTable('#myTable', {
    columnDefs: [
        { targets: [5], orderable: false, searchable: false }
    ],
    columns: [{ width: '5%' },{width:'18%'}, {width:'17%'},{width:'30%'}, {width:'10%'},{with:'20%'}],
    paging:false,
    });
    document.getElementById('myTable_info').classList.add('d-none');
</script>

<script>
function typeForm(id,r=null){
    let form=document.getElementById(id);
    if(r==null){
        document.getElementById('div-password').classList.add('d-none');
        form.action="{{route('admin.employee.create')}}";
        document.getElementById('name').value=null;
        document.getElementById('surname').value=null;
        document.getElementById('email').value=null;
        document.getElementById('role').value=2;
    }else{
        document.getElementById('div-password').classList.remove('d-none');
        let row = document.getElementById(r);
        let cells = row.children;
        let v=['surname','name','email','role'];
        for(i=1;i<cells.length-1;i++){
            if(i==4)
                document.getElementById(v[i-1]).value=cells[i].textContent==='Gerente' ? 1 : 2;
            else
                document.getElementById(v[i-1]).value=cells[i].textContent;
        }
        form.action="{{route('admin.employee.update','')}}"+"/"+cells[0].textContent;
    }
}
</script>

@endsection



