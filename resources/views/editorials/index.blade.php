@extends('adminlte::page')

@section('title', 'Lista de Editoriales')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Lista de Editoriales</h1>
        <a href="{{ route('editorials.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle mr-1"></i> Nueva Editorial
        </a>
    </div>
@stop

@section('content')
<div class="card shadow-sm mt-2">
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" style="width: 150px;">Acciones</th>
                    <th style="width: 80px;">ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Domicilio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($editorials as $editorial)
                <tr>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{ route('editorials.show', $editorial->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('editorials.edit', $editorial->id) }}" class="btn btn-sm btn-outline-warning mx-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- Botón que activa el modal --}}
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-toggle="modal" 
                                    data-target="#modalEliminar" 
                                    data-id="{{ $editorial->id }}" 
                                    data-nombre="{{ $editorial->name }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                    <td>{{ $editorial->id }}</td>
                    <td class="font-weight-bold">{{ $editorial->name }}</td>
                    <td>{{ $editorial->email }}</td>
                    <td>{{ $editorial->address }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DE ELIMINACIÓN (Idéntico al de Libros) --}}
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold">Eliminar Editorial</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-3">¿Seguro que quieres eliminar la editorial?</p>
                <h3 id="nombreEditorialEliminar" class="font-weight-bold text-dark"></h3>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                <form id="formEliminar" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 font-weight-bold">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Lógica para pasar datos al modal dinámicamente
    $('#modalEliminar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var modal = $(this);
        
        modal.find('#nombreEditorialEliminar').text(nombre);
        modal.find('#formEliminar').attr('action', '/editorials/' + id);
    });
</script>
@stop