@extends('adminlte::page')

@section('title', 'Añadir Libro')

@section('content_header')
    <h1>Registrar Nuevo Título</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Información del Libro</h3>
            </div>
            
            <form action="{{ route('libros.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="titulo">Título del Libro</label>
                        <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                               id="titulo" placeholder="Ej. El llano en llamas" value="{{ old('titulo') }}" required>
                        @error('titulo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Autor</label>
                                <select name="autor_id" class="form-control @error('autor_id') is-invalid @enderror" required>
                                    <option value="">-- Seleccione un autor --</option>
                                    @foreach($autores as $autor)
                                        <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>
                                            {{ $autor->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('autor_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Editorial</label>
                                <select name="editorial_id" class="form-control @error('editorial_id') is-invalid @enderror" required>
                                    <option value="">-- Seleccione editorial --</option>
                                    @foreach($editoriales as $ed)
                                        <option value="{{ $ed->id }}" {{ old('editorial_id') == $ed->id ? 'selected' : '' }}>
                                            {{ $ed->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('editorial_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Resumen / Descripción</label>
                        <textarea name="resumen" class="form-control" rows="3" placeholder="Breve descripción del contenido...">{{ old('resumen') }}</textarea>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="portada">Portada (Imagen JPG/PNG)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="portada" name="portada" accept="image/*">
                                <label class="custom-file-label" for="portada">Elegir imagen...</label>
                            </div>
                        </div>
                        <small class="text-muted">Tamaño máximo recomendado: 2MB.</small>
                    </div>

                    <div class="form-group">
                        <label for="archivo_pdf">Libro Digital (Archivo PDF)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivo_pdf" name="archivo_pdf" accept=".pdf">
                                <label class="custom-file-label" for="archivo_pdf">Elegir archivo PDF...</label>
                            </div>
                        </div>
                        <small class="text-muted">Este archivo estará disponible para lectura en línea.</small>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Registrar Libro</button>
                    <a href="{{ route('libros.index') }}" class="btn btn-default float-right">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Inicialización para que el nombre del archivo se actualice al seleccionar uno
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@stop