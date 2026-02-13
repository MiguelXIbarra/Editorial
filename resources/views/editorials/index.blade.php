@extends('adminlte::page')

@section('title', 'Editoriales')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark font-weight-bold">Lista de Editoriales</h1>
        <a href="{{ route('editorials.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-building mr-1"></i> Nueva Editorial
        </a>
    </div>
@stop

@section('content')
<div class="card card-outline card-primary shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-valign-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="border-top-0">Nombre</th>
                    <th class="border-top-0">Correo</th>
                    <th class="border-top-0">Domicilio</th>
                    <th class="border-top-0 text-right pr-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($editorials as $editorial)
                <tr>
                    <td class="font-weight-bold">{{ $editorial[3] }}</td>
                    <td class="text-muted">{{ $editorial[2] }}</td>
                    <td>{{ $editorial[4] }}</td>
                    <td class="text-right pr-4">
                        <div class="btn-group shadow-sm">
                            <a href="{{ route('editorials.show', $editorial[1]) }}" class="btn btn-outline-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('editorials.edit', $editorial[1]) }}" class="btn btn-outline-warning btn-sm mx-1" title="Editar"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm" onclick="modal('{{ $editorial[1] }}')" data-toggle="modal" data-target="#deleteModal" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
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
                <p class="h5">¿Seguro que deseas eliminar la editorial?</p>
                <h4 id="nombreEditorial" class="text-danger font-weight-bold"></h4>
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
@endsection

@section('js')
<script>
    function modal(id, nombre) {
    document.getElementById('nombreEditorial').innerText = nombre;
    let url = "{{ route('editorials.destroy', ':id') }}";
    url = url.replace(':id', id);
    document.getElementById('deleteForm').setAttribute('action', url);
}
</script>
@endsection