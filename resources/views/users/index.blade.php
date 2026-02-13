@extends('adminlte::page')

@section('title', 'Usuarios del Sistema')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark font-weight-bold">Usuarios del Sistema</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-user-plus mr-1"></i> Registrar Usuario
        </a>
    </div>
@stop

@section('content')
<div class="card card-outline card-primary shadow-sm">
    <div class="card-header bg-white">
        <h3 class="card-title font-weight-bold">Listado General</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-valign-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="border-top-0">Nombre</th>
                    <th class="border-top-0">Email</th>
                    <th class="border-top-0 text-center">Rol</th>
                    <th class="border-top-0 text-right pr-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="font-weight-bold">{{ $user->name }}</td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td class="text-center">
                        {{-- CAMBIO: Ahora todos los roles usan el fondo azul primario --}}
                        <span class="badge badge-primary px-3 py-2 shadow-sm" style="min-width: 100px;">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td class="text-right pr-4">
                        <div class="btn-group shadow-sm">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-warning btn-sm mx-1" title="Editar"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm" onclick="confirmarBorrado('{{ $user->id }}', '{{ $user->name }}')" data-toggle="modal" data-target="#deleteModal" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal de Borrado limpio --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold">Confirmar Eliminación</h5>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <p class="h5">¿Seguro que deseas eliminar al usuario <br><strong id="userName" class="text-danger"></strong>?</p>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger px-4 shadow-sm">Eliminar Ahora</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function confirmarBorrado(id, name) {
        $('#userName').text(name);
        let url = "{{ route('users.destroy', ':id') }}";
        url = url.replace(':id', id);
        $('#deleteForm').attr('action', url);
    }
</script>
@endsection