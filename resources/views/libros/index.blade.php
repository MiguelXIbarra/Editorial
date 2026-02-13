@extends('adminlte::page')

@section('content')
<div class="container">
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <div class="row">
        <h2>Inventario de Libros</h2>
        <p align="right"><a href="{{ route('libros.create') }}" class="btn btn-success">Agregar Libro</a></p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Título</th>
                    <th>ISBN</th>
                    <th>Rol Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                <tr>
                    <td>
                        {{-- Botón de Ver --}}
                        <a href="{{ route('libros.show', $libro[1]) }}" class="btn btn-info" title="Ver Detalles">
                            <i class="far fa-eye"></i>
                        </a>
                        {!! $libro[0] !!}
                    </td>
                    <td>{{ $libro[1] }}</td>
                    <td>{{ $libro[2] }}</td>
                    <td>{{ $libro[3] }}</td>
                    <td>{{ $libro[4] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5>Confirmar Eliminación</h5></div>
            <div class="modal-body">¿Borrar el libro <span id="nombreLibro"></span>?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a href="" id="btnConfirmarBorrar" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function modal(id, titulo) {
        $('#nombreLibro').html(titulo);
        let url = "{{ route('deleteLibro', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById('btnConfirmarBorrar').href = url;
    }
</script>
@endsection