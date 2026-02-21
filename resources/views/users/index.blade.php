@extends('adminlte::page')

@section('title', 'Lista de Usuarios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Lista de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-user-plus mr-1"></i> Registrar
        </a>
    </div>
@stop

@section('content')
<div class="card shadow-sm mt-2">
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" style="width: 150px;">Acciones</th>
                    <th style="width: 50px;">ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th class="text-center">Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="text-center">{!! $user[0] !!}</td>
                    <td>{{ $user[1] }}</td>
                    <td class="font-weight-bold">{{ $user[2] }}</td>
                    <td>{{ $user[3] }}</td>
                    <td>{!! $user[4] !!}</td>
                    <td class="text-center">{!! $user[5] !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DE ELIMINACIÓN ROJO --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold">Eliminar Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-3">¿Seguro que quieres eliminar al usuario?</p>
                <h3 id="nombreUserEliminar" class="font-weight-bold text-dark"></h3>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                <form id="formEliminarUser" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 font-weight-bold">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function modal(id, nombre) {
        $('#nombreUserEliminar').text(nombre);
        $('#formEliminarUser').attr('action', '/users/' + id);
    }
</script>
@stop