@extends('adminlte::page')
@section('title', 'Lista de Autores')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <table id="tablaAutores" class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">Acciones</th>
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th class="text-center">Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($autores as $autor)
                    <tr>
                        {{-- Aplicamos vertical-align: middle para que todo esté centrado igual que en Users --}}
                        <td class="text-center" style="vertical-align: middle;">{!! $autor[0] !!}</td>
                        <td class="text-center" style="vertical-align: middle;">{{ $autor[1] }}</td>
                        <td style="vertical-align: middle;">{{ $autor[2] }}</td>
                        <td style="vertical-align: middle;">{{ $autor[3] }}</td>
                        <td class="text-center" style="vertical-align: middle;">
                            @php
                                $archivo = trim($autor[4] ?? '');
                            @endphp

                            @if($archivo && !in_array(strtolower($archivo), ['null', 'sin foto', 'none', '']) && strlen($archivo) > 5)
                                <img src="{{ asset('img/profiles/' . $archivo) }}" 
                                     class="img-circle elevation-2" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <span class="badge badge-secondary">SIN FOTO</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal de eliminación --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Eliminar Autor</h5>
            </div>
            <div class="modal-body text-center">
                <p>¿Seguro que deseas eliminar al autor?</p>
                <h4 id="nombreAutor" class="text-danger font-weight-bold"></h4>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function modal(id, nombre) {
        $('#nombreAutor').text(nombre);
        let url = "{{ route('autors.destroy', ':id') }}";
        url = url.replace(':id', id);
        $('#deleteForm').attr('action', url);
        $('#deleteModal').modal('show');
    }
</script>
@stop