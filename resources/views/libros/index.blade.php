@extends('adminlte::page')

@section('title', 'Inventario de Libros')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark font-weight-bold">Inventario de Libros</h1>
        <a href="{{ route('libros.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus mr-1"></i> Agregar Libro
        </a>
    </div>
@stop

@section('content')
<div class="card card-outline card-primary shadow-sm">
    <div class="card-header bg-white">
        <h3 class="card-title font-weight-bold">Libros Registrados</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-valign-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="border-top-0">ID</th>
                    <th class="border-top-0">Título</th>
                    <th class="border-top-0">ISBN</th>
                    <th class="border-top-0 text-center">Rol Registro</th>
                    <th class="border-top-0 text-right pr-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                <tr>
                    <td class="text-muted">#{{ $libro[1] }}</td>
                    <td class="font-weight-bold">{{ $libro[2] }}</td>
                    <td><code>{{ $libro[3] }}</code></td>
                    <td class="text-center">
                        {{-- CAMBIO: De badge-secondary (gris) a badge-primary (azul) --}}
                        <span class="badge badge-primary px-3 py-2 shadow-sm" style="min-width: 80px;">
                            {{ strtoupper($libro[4]) }}
                        </span>
                    </td>
                    <td class="text-right pr-4">
                        <div class="btn-group shadow-sm">
                            <a href="{{ route('libros.show', $libro[1]) }}" class="btn btn-outline-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('libros.edit', $libro[1]) }}" class="btn btn-outline-warning btn-sm mx-1" title="Editar"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm" onclick="modal('{{ $libro[1] }}', '{{ $libro[2] }}')" data-toggle="modal" data-target="#deleteModal" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal de Borrado limpio --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white"><h5>Confirmar Eliminación</h5></div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <p class="h5">¿Borrar el libro <strong id="nombreLibro" class="text-danger"></strong>?</p>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                <a href="" id="btnConfirmarBorrar" class="btn btn-danger px-4 shadow-sm">Eliminar Ahora</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function modal(id, titulo) {
        $('#nombreLibro').html(titulo);
        let url = "{{ route('libros.destroy', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById('btnConfirmarBorrar').href = url;
    }
</script>
@endsection