@extends('adminlte::page')

@section('title', 'Listado de Libros')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Listado de Libros</h1>
    <a href="{{ route('libros.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Libro</a>
</div>
@stop

@section('content')
<div class="card shadow">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="bg-light text-center">
                <tr>
                    <th style="width: 150px;">Acciones</th>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Portada</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($libros as $libro)
                    <tr>
                        <td class="align-middle">{!! $libro[0] !!}</td>
                        <td class="align-middle">{{ $libro[1] }}</td>
                        <td class="align-middle">{{ $libro[2] }}</td>
                        <td class="align-middle">{{ $libro[3] }}</td>
                        <td class="align-middle">{{ $libro[4] }}</td>
                        <td class="align-middle">{!! $libro[5] !!}</td>
                        <td class="align-middle">{!! $libro[6] !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal de Eliminación --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Eliminar Libro</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body text-center">
                    <p>¿Seguro que quieres eliminar el libro?</p>
                    <h4 id="nombreLibro" class="font-weight-bold"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function modal(id, titulo) {
        $('#nombreLibro').text(titulo);
        let url = "{{ route('libros.destroy', ':id') }}";
        $('#deleteForm').attr('action', url.replace(':id', id));
    }
</script>
@stop