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
                                <label for="autor_id">Autor</label>
                                <select name="autor_id" class="form-control" required>
                                    <option value="">-- Selecciona un Autor --</option>
                                    @foreach($autores as $autor)
                                        <option value="{{ $autor->id }}">{{ $autor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editorial_id">Editorial</label>
                                <select name="editorial_id" class="form-control" required>
                                    <option value="">-- Selecciona una Editorial --</option>
                                    @foreach($editoriales as $editorial)
                                        <option value="{{ $editorial->id }}">{{ $editorial->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Resumen / Descripción</label>
                        <textarea name="resumen" class="form-control" rows="3" placeholder="Breve descripción del contenido...">{{ old('resumen') }}</textarea>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Portada (Imagen JPG/PNG)</label>
                        <div class="custom-file">
                            <input type="file" name="portada" class="custom-file-input" id="portadaInput" accept="image/*">
                            <label class="custom-file-label" for="portadaInput">Elegir imagen...</label>
                        </div>
                        <div class="mt-2 text-center">
                            <img id="imgPreview" src="#" alt="Vista previa"
                                style="max-width: 200px; display: none; border-radius: 5px; border: 1px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Libro Digital (Archivo PDF)</label>
                        <div class="custom-file">
                            <input type="file" name="pdf" class="custom-file-input" id="pdfInput" accept="application/pdf">
                            <label class="custom-file-label" id="pdfLabel" for="pdfInput">Elegir archivo PDF...</label>
                        </div>
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
    // Vista previa de la Imagen
    $('#portadaInput').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#imgPreview').attr('src', event.target.result).show();
            }
            reader.readAsDataURL(file);
            $(this).next('.custom-file-label').html(file.name);
        }
    });

    // Actualizar nombre del PDF
    $('#pdfInput').change(function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });
</script>
@stop