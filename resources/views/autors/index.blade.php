@extends('adminlte::page')

@section('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.css" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
    </div>
    <div class="row">
        <h2>Lista de Autores</h2>
        <p align="right">
            <a href="{{ route('autors.create') }}" class="btn btn-success">Crear Autor</a>
        </p>
        <table id="autorsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($autores as $autor)
                <tr>
                    <td>
                        {{-- Botón de Ver --}}
                        <a href="{{ route('autors.show', $autor[1]) }}" class="btn btn-info" title="Ver Detalles">
                            <i class="far fa-eye"></i>
                        </a>
                        {!! $autor[0] !!}
                    </td> 
                    <td>{{ $autor[1] }}</td>
                    <td>{{ $autor[3] }}</td>
                    <td>{{ $autor[2] }}</td>
                    <td>{!! $autor[4] !!}</td>
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
                <h5 class="modal-title">Confirmar Borrado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar al autor: <span id="nombreAutor"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="" id="btnConfirmarBorrar" class="btn btn-danger">Borrar</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#autoresTable').DataTable();
        });

        function modal(id, nombre) {
            $('#nombreAutor').html(nombre);
            let url = "{{ route('deleteAutor', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('btnConfirmarBorrar').href = url;
        }
    </script>
@endsection