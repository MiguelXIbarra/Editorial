@extends('adminlte::page')

@section('title', 'Lista de Autores')

@section('css')
<style>
    
    table td img {
        width: 40px !important;
        height: 40px !important;
        object-fit: cover !important;
        object-position: center !important;
        border-radius: 50% !important;
        border: 1px solid #ddd;
        display: block;
        margin: 0 auto;
    }
    .table td, .table th { 
        vertical-align: middle !important; 
        text-align: center; 
    }
</style>
@stop

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Lista de Autores</h1>
    <a href="{{ route('autors.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-user-plus"></i> Registrar
    </a>
</div>
@stop

@section('content')
<div class="card card-outline card-primary shadow">
    <div class="card-body p-0">
        <table class="table table-hover table-valign-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 150px;">Acciones</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th style="width: 80px;">Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($autors as $autor)
                    <tr>
                        <td>{!! $autor[0] !!}</td>
                        {{-- ID --}}
                        <td>{{ $autor[1] }}</td>
                        {{-- Nombre --}}
                        <td>{{ $autor[2] }}</td>
                        {{-- Email --}}
                        <td>{{ $autor[3] }}</td> 
                        {{-- Rol (Badge) --}}
                        <td>{!! $autor[4] !!}</td> 
                        {{-- Foto (img tag) --}}
                        <td>{!! $autor[5] !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal de Confirmación de Eliminación --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-trash-alt mr-2"></i> Eliminar Autor</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center">
                    <p class="mb-1">¿Estás seguro de que deseas eliminar permanentemente a:</p>
                    <h4 id="nombreAutor" class="font-weight-bold text-dark"></h4>
                    <p class="text-muted small mt-2">Esta acción borrará el perfil del autor del sistema.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger font-weight-bold">Confirmar Eliminación</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>

    function modal(id, nombre) {

        $('#nombreAutor').text(nombre);

        let url = "{{ route('autors.destroy', ':id') }}";
        url = url.replace(':id', id);
        
        $('#deleteForm').attr('action', url);
    }
</script>
@stop