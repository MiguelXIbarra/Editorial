@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <h1>Gestión de Usuarios</h1>
@stop

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h3 class="card-title">Listado de Personal</h3>
        <div class="card-tools">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus mr-1"></i> Registrar Usuario
            </a>
        </div>
    </div>
    <div class="card-body">
        <table id="tablaUsuarios" class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="text-center">
                    <th width="120px">Acciones</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    {{-- Acciones (botones de ver, editar y borrar) --}}
                    <td class="text-center">{!! $user[0] !!}</td>
                    
                    {{-- ID --}}
                    <td class="text-center">{{ $user[1] }}</td>
                    
                    {{-- Nombre --}}
                    <td>{{ $user[2] }}</td>
                    
                    {{-- Email --}}
                    <td>{{ $user[3] }}</td>
                    
                    {{-- Rol (Badge uniforme) --}}
                    <td class="text-center">{!! $user[4] !!}</td>
                    
                    {{-- Foto (Circular con object-fit: top) --}}
                    <td class="text-center">{!! $user[5] !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-user-times mr-2"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <p class="h5">¿Seguro que deseas eliminar al usuario?</p>
                <h4 id="nombreUsuario" class="text-danger font-weight-bold"></h4>
                <p class="text-muted small">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">Eliminar Ahora</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    /**
     * Función para cargar los datos del usuario en el modal de borrado
     * @param {number} id - ID del usuario
     * @param {string} nombre - Nombre completo del usuario
     */
    function modal(id, nombre) {
        // Mostramos el nombre en el modal para confirmar
        document.getElementById('nombreUsuario').innerText = nombre;
        
        // Construimos la URL de eliminación dinámicamente
        let url = "{{ route('users.destroy', ':id') }}";
        url = url.replace(':id', id);
        
        // Asignamos la URL al formulario del modal
        document.getElementById('deleteForm').setAttribute('action', url);
    }

    // Inicialización de DataTable si lo usas
    $(function () {
        $("#tablaUsuarios").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            }
        });
    });
</script>
@stop