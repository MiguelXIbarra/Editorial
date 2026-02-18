@extends('adminlte::page')

@section('title', 'Lista de Autores')

@section('content_header')
    <h1>Autores Registrados</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table id="tablaAutores" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Foto</th> </tr>
            </thead>
            <tbody>
                @foreach($autores as $autor)
                <tr>
                    <td>{!! $autor[0] !!}</td>
                    <td>{{ $autor[1] }}</td>
                    <td>{{ $autor[2] }}</td>
                    <td>{{ $autor[3] }}</td>
                    <td>{!! $autor[4] !!}</td>
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
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <p class="h5">¿Seguro que deseas eliminar al autor?</p>
                <h4 id="nombreAutor" class="text-danger font-weight-bold"></h4>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
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
        $('#nombreAutor').html(nombre);
        let url = "{{ route('autors.destroy', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById('deleteForm').setAttribute('action', url);
    }
</script>
@stop