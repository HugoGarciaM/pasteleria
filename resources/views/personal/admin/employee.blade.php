@extends('adminlte::page')
@section('plugins.Datatable', true)

@section('content_header')
    <h1>Empleado</h1>
@endsection

@php
    use App\Models\User;
    use App\Enums\Role;
    $employees = User::where('role', 1)
        ->orWhere('role', 2)
        ->orWhere('role', 4)
        ->paginate(10);
    $i = 0;
@endphp

@section('content')
    <div class="navbar justify-content-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate"
            onclick="typeForm('form-employee')">
            <i class="fa fa-plus"></i>
            Nuevo Empleado
        </button>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Lista Empleados</h5>
            <table id="myTable" class="table table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        {{-- <th class="d-none">Id</th> --}}
                        <th>CI</th>
                        <th>Apellido y Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr id="tr{{ $i++ }}">
                            {{-- <td class="d-none">{{$employee->id}}</td> --}}
                            <td>{{ $employee->person_ci }}</td>
                            <td>{{ $employee->person->name }}</td>
                            <td>{{ $employee->email }}</td>
                            @switch($employee->role)
                                @case(Role::ADMIN)
                                    <td>Gerente</td>
                                @break

                                @case(Role::PERSONAL)
                                    <td>Personal</td>
                                @break

                                @default
                                    <td>Delivery</td>
                            @endswitch
                            <td><input type="checkbox" value="0" {{ $employee->status != 1 ? 'checked' : '' }}
                                    onclick='return false'></td>
                            <td>
                                <div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"
                                        onclick="typeForm('form-employee','tr{{ $i - 1 }}',{{ $employee->id }})">Editar</button>
                                    @if ($employee->transactions->isEmpty())
                                        <form class="d-inline" id="drop{{ $i }}"
                                            action="{{ route('admin.employee.delete', $employee->id) }}" method="post">
                                            @csrf
                                            <button class="btn btn-danger" type="button"
                                                onclick="drop('drop{{ $i }}')">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $employees->links() }}
        </div>
    </div>

    <x-modal title="Nuevo Empleado" id="modalCreate">
        <form id="form-employee" method="post" action="{{ route('admin.employee.create') }}">
            @csrf
            <div class="input-group">
                <span class="input-group-text">CI</span>
                <input class="form-control" type="text" name="ci" id="ci">
            </div>
            <div class="input-group">
                <span class="input-group-text">Apellido y Nombre</span>
                <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="input-group">
                <span class="input-group-text">Email</span>
                <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="input-group">
                <span class="input-group-text">Rol</span>
                <select class="form-select" name="role" id="role">
                    <option value="2" selected>Personal</option>
                    <option value="1">Gerente</option>
                    <option value="4">Delivery</option>
                </select>
            </div>
            <div class="input-group" id="div-password">
                <span class="input-group-text">Contraseña</span>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="form-check" id="div-status">
                <input type="checkbox" class="form-check-input" name="status" id="status" value="0">
                <span class="form-check-label">Activo</span>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </x-modal>



    @error('name')
        <x-toast title="Error" id="errorName" colorscheme="text-bg-danger">
            {{ $message }}
        </x-toast>
    @enderror
    @error('ci')
        <x-toast title="Error" id="errorSurname" colorscheme="text-bg-danger">
            {{ $message }}
        </x-toast>
    @enderror
    @error('email')
        <x-toast title="Error" id="errorEmail" colorscheme="text-bg-danger">
            {{ $message }}
        </x-toast>
    @enderror
    @error('password')
        <x-toast title="Error" id="errorEmail" colorscheme="text-bg-danger">
            {{ $message }}
        </x-toast>
    @enderror

@endsection

@section('js')
    <script>
        new DataTable('#myTable', {
            scrollX: true,
            columnDefs: [{
                targets: [5],
                orderable: false,
                searchable: false
            }, ],
            paging: false,
            language: {
                search: 'Filtrar:'
            },
            responsive: true,
            scrollX: true
        });
        document.getElementById('myTable_info').classList.add('d-none');
    </script>

    <script>
        function drop(form) {
            form = document.getElementById(form);
            Swal.fire({
                title: "Estas Seguro?",
                text: "Estas a punto de Eliminar un usuario",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Elimido!",
                        text: "El usuario fue Elimido Correctamente.",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                }
            });
        }
    </script>

    <script>
        function typeForm(id, r = null, idu) {
            let form = document.getElementById(id);
            if (r == null) {
                document.getElementById('div-password').classList.add('d-none');
                form.action = "{{ route('admin.employee.create') }}";
                document.getElementById('ci').value = null;
                document.getElementById('ci').readOnly = false;
                document.getElementById('name').value = null;
                document.getElementById('email').value = null;
                document.getElementById('role').value = 2;
                document.getElementById('status').value = 1;
            } else {
                document.getElementById('ci').readOnly = true;
                document.getElementById('div-password').classList.remove('d-none');
                let row = document.getElementById(r);
                let cells = row.children;
                let v = ['ci', 'name', 'email', 'role', 'status'];
                for (i = 0; i < cells.length - 1; i++) {
                    if (i == 3)
                        switch (cells[i].textContent) {
                            case ('Gerente'):
                                document.getElementById(v[i]).value = 1;
                                break;
                            case ('Personal'):
                                document.getElementById(v[i]).value = 2;
                                break;
                            default:
                                document.getElementById(v[i]).value = 4;
                        }
                    else if (i == 4) {
                        document.getElementById(v[i]).checked = cells[i].children[0].value;

                    } else
                        document.getElementById(v[i]).value = cells[i].textContent;
                }
                form.action = "{{ route('admin.employee.update', '') }}" + "/" + idu;
            }
        }
    </script>

@endsection
