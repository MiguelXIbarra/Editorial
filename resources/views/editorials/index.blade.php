@extends('adminlte::page')

@section('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
    </div>
    <div class="row">
        <h2>Lista de Editoriales</h2>
        <p align="right">
            <a href="{{ route('editorials.create') }}" class="btn btn-success">Crear Editorial</a>
        </p>
        <table id="editorialsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Id</th>
                    <th>Correo</th>
                    <th>Nombre</th>
                    <th>Domicilio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($editorials as $editorial)
                <tr>
                    <td>
                        <a href="{{ route('editorials.edit', $editorial[1]) }}" class="btn btn-success">
                            <i class="far fa-edit"></i>
                        </a>
                        <button class="btn btn-danger" onclick="modal('{{ $editorial[1] }}')" data-toggle="modal" data-target="#deleteModal">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>{{ $editorial[1] }}</td>
                    <td>{{ $editorial[2] }}</td>
                    <td>{{ $editorial[3] }}</td>
                    <td>{{ $editorial[4] }}</td>
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
                ¿Estás seguro de que deseas eliminar la editorial con ID: <span id="idEditorial"></span>?
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
    <script>
        function modal(id) {
            $('#idEditorial').html(id);
            let url = "{{ route('deleteEditorial', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('btnConfirmarBorrar').href = url;
        }
    </script>
@endsection