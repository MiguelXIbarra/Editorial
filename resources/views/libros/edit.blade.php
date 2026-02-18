@extends('adminlte::page')

@section('title', 'Editar Libro')

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Editar Libro: {{ $libro->titulo }}</h3>
    </div>
    <form action="{{ route('libros.update', $libro->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ $libro->titulo }}" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Autor</label>
                        <select name="autor_id" class="form-control" required>
                            @foreach($autores as $autor)
                                <option value="{{ $autor->id }}" {{ $libro->autor_id == $autor->id ? 'selected' : '' }}>
                                    {{ $autor->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Editorial</label>
                        <select name="editorial_id" class="form-control" required>
                            @foreach($editoriales as $ed)
                                <option value="{{ $ed->id }}" {{ $libro->editorial_id == $ed->id ? 'selected' : '' }}>
                                    {{ $ed->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Portada Actual</label>
                <div class="mb-2">
                    @if($libro->portada)
                        <img src="{{ asset('img/libros/'.$libro->portada) }}" width="80" class="img-thumbnail">
                    @endif
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="portada" id="portada" accept="image/*">
                        <label class="custom-file-label" for="portada">Cambiar portada...</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>PDF Actual</label>
                <div class="mb-2">
                    @if($libro->archivo_pdf)
                        <span class="badge badge-info"><i class="fas fa-file-pdf"></i> {{ $libro->archivo_pdf }}</span>
                    @endif
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="archivo_pdf" id="archivo_pdf" accept=".pdf">
                        <label class="custom-file-label" for="archivo_pdf">Subir nuevo PDF...</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Actualizar</button>
            <a href="{{ route('libros.index') }}" class="btn btn-default float-right">Cancelar</a>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@stop