@extends('adminlte::page')
@section('title', 'Gestión de Usuarios')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h3 class="card-title">Listado de Personal</h3>
        <div class="card-tools"><a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i
                    class="fas fa-user-plus mr-1"></i> Registrar</a></div>
    </div>
    <div class="card-body">
        <table class="table table-hover">
    <thead>
        <tr>
            <th class="text-center">Acciones</th> {{-- Índice 0 --}}
            <th class="text-center">ID</th>       {{-- Índice 1 --}}
            <th>Nombre</th>                       {{-- Índice 2 --}}
            <th>Email</th>                        {{-- Índice 3 --}}
            <th class="text-center">Rol</th>      {{-- Índice 4 --}}
            <th class="text-center">Foto</th>     {{-- Índice 5 --}}
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td class="text-center" style="vertical-align: middle;">{!! $user[0] !!}</td>
                <td class="text-center" style="vertical-align: middle;">{{ $user[1] }}</td>
                <td style="vertical-align: middle;">{{ $user[2] }}</td>
                <td style="vertical-align: middle;">{{ $user[3] }}</td>
                <td class="text-center" style="vertical-align: middle;">{!! $user[4] !!}</td>
                <td class="text-center" style="vertical-align: middle;">
                    @php
                        $archivo = trim($user[5] ?? ''); 
                    @endphp

                    @if($archivo && !in_array(strtolower($archivo), ['null', 'sin foto', 'none', '']) && strlen($archivo) > 5)
                        <img src="{{ asset('img/profiles/' . $archivo) }}" class="img-circle elevation-2" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <span class="badge badge-secondary">SIN FOTO</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>

{{-- Modal de eliminación --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger"><h5 class="modal-title">Confirmar Eliminación</h5></div>
            <div class="modal-body text-center">
                <p>¿Seguro que deseas eliminar al usuario?</p>
                <h4 id="nombreUsuario" class="text-danger font-weight-bold"></h4>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar Ahora</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function modal(id, nombre) {
        document.getElementById('nombreUsuario').innerText = nombre;
        let url = "{{ route('users.destroy', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById('deleteForm').setAttribute('action', url);
        $('#deleteModal').modal('show');
    }
</script>
@stop