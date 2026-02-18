@extends('adminlte::page')

@section('title', 'Directorio de Autores')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark font-weight-bold">Directorio de Autores</h1>
        <a href="{{ route('autors.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-user-edit mr-1"></i> Crear Autor
        </a>
    </div>
@stop

@section('content')
<div class="card card-outline card-primary shadow-sm">
    <div class="card-header bg-white">
        <h3 class="card-title font-weight-bold">Autores Registrados</h3>
    </div>
    <div class="card-body p-0">
        <table id="autorsTable" class="table table-hover table-valign-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="border-top-0 pl-4">Imagen</th>
                    <th class="border-top-0">Nombre</th>
                    <th class="border-top-0">Email</th>
                    <th class="border-top-0 text-right pr-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($autores as $autor)
                <tr>
                    <td class="pl-4">{!! $autor[4] !!}</td>
                    <td class="font-weight-bold">{{ $autor[3] }}</td>
                    <td class="text-muted">{{ $autor[2] }}</td>
                    <td class="text-right pr-4">
                        <div class="btn-group shadow-sm">
                            <a href="{{ route('autors.show', $autor[1]) }}" class="btn btn-outline-info btn-sm" title="Ver Detalles"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('autors.edit', $autor[1]) }}" class="btn btn-outline-warning btn-sm mx-1" title="Editar"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm" onclick="modal('{{ $autor[1] }}', '{{ $autor[3] }}')" data-toggle="modal" data-target="#deleteModal" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold">Confirmar Borrado</h5>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <p class="h5">¿Estás seguro de que deseas eliminar al autor: <br><strong id="nombreAutor" class="text-danger"></strong>?</p>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cerrar</button>
                <a href="" id="btnConfirmarBorrar" class="btn btn-danger px-4 shadow-sm">Borrar Ahora</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function modal(id, nombre) {
        $('#nombreAutor').html(nombre);
        let url = "{{ route('autors.destroy', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById('btnConfirmarBorrar').href = url;
    }
</script>
@endsection