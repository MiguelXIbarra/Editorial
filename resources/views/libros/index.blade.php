@extends('adminlte::page')

@section('title', 'Inventario de Libros')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('libros.create') }}" class="btn btn-primary btn-sm float-right">Nuevo Libro</a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Portada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                <tr>
                    <td>{!! $libro[0] !!}</td>
                    <td>{{ $libro[1] }}</td>
                    <td>{{ $libro[2] }}</td>
                    <td>{{ $libro[3] }}</td>
                    <td>{{ $libro[4] }}</td>
                    <td>{!! $libro[5] !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Eliminar Libro</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-book-dead fa-3x text-danger mb-3"></i>
                <p>¿Seguro que deseas eliminar el título?</p>
                <h4 id="nombreLibro" class="text-danger font-weight-bold"></h4>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function modal(id, nombre) {
        document.getElementById('nombreLibro').innerText = nombre;
        let url = "{{ route('libros.delete', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById('deleteForm').setAttribute('action', url);
    }
</script>
@stop