@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
    </div>
    <div class="row">
        <h2>Gestión de Usuarios</h2>
        <p align="right">
            <a href="{{ route('users.create') }}" class="btn btn-success">Nuevo Usuario</a>
        </p>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        {{-- Botón de Ver --}}
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info" title="Ver Detalles">
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">
                            <i class="far fa-edit"></i>
                        </a>
                        <button class="btn btn-danger" onclick="confirmarBorrado('{{ $user->id }}', '{{ $user->name }}')" data-toggle="modal" data-target="#deleteModal">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge badge-info">{{ $user->role }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Seguro que deseas eliminar al usuario <span id="userName"></span>?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function confirmarBorrado(id, name) {
        $('#userName').html(name);
        let url = "{{ route('users.destroy', ':id') }}";
        url = url.replace(':id', id);
        $('#deleteForm').attr('action', url);
    }
</script>
@endsection