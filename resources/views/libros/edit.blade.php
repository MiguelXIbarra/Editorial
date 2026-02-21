@extends('adminlte::page')

@section('title', 'Editar Libro')

@section('content_header')
    <div class="bg-warning p-2 shadow-sm rounded">
        <h5 class="mb-0 text-dark font-weight-bold">Editar Libro: {{ $libro->titulo }}</h5>
    </div>
@stop

@section('content')
<div class="card card-outline card-warning shadow-sm mt-2">
    <div class="card-body">
        <form action="{{ route('libros.update', $libro->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="eliminar_portada" id="eliminar_portada" value="0">
            <input type="hidden" name="eliminar_pdf" id="eliminar_pdf" value="0">

            <div class="row">
                <div class="col-md-12">
                    {{-- Título --}}
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Título</label>
                        <input type="text" name="titulo" class="form-control" value="{{ $libro->titulo }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-secondary">Autor</label>
                                <select name="autor_id" class="form-control" required>
                                    @foreach($autores as $autor)
                                        <option value="{{ $autor->id }}" {{ $libro->autor_id == $autor->id ? 'selected' : '' }}>
                                            {{ $autor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-secondary">Editorial</label>
                                <select name="editorial_id" class="form-control" required>
                                    @foreach($editoriales as $editorial)
                                        <option value="{{ $editorial->id }}" {{ $libro->editorial_id == $editorial->id ? 'selected' : '' }}>
                                            {{ $editorial->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Portada Actual</label>
                        <div class="mb-2">
                            @php 
                                $path = 'img/libros/portadas/' . $libro->portada;
                                $existePort = ($libro->portada && file_exists(public_path($path)));
                            @endphp
                            
                            {{-- Fondo Gris Claro (#f8f9fa) con borde visible (#ddd) --}}
                            <div id="previewContainer" style="width: 140px; height: 180px; background: #f8f9fa; border: 2px solid #ddd; display: flex; align-items: center; justify-content: center; overflow: hidden;" class="rounded shadow-sm">
                                <img id="imgPreview" src="{{ $existePort ? asset($path) : '' }}" 
                                     style="width: 100%; height: 100%; object-fit: contain; {{ $existePort ? '' : 'display: none;' }}">
                                
                                <div id="placeholder" class="text-muted text-center" style="{{ $existePort ? 'display: none;' : '' }}">
                                    <i class="fas fa-image fa-3x mb-1 text-secondary" style="opacity: 0.5;"></i><br>
                                    <small class="font-weight-bold">AÑADIR PORTADA</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="portada" class="custom-file-input" id="portadaInput" accept="image/*">
                                <label class="custom-file-label" for="portadaInput" id="labelPortada">
                                    {{ $existePort ? 'Sustituir imagen...' : 'Añadir imagen...' }}
                                </label>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary" onclick="limpiarArchivo('portada')" title="Quitar archivo">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- PDF Dinámico --}}
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Archivo PDF</label>
                        <div id="pdfInfo" class="mb-1">
                            @if($libro->pdf)
                                <small class="text-muted"><i class="fas fa-file-pdf text-danger"></i> {{ $libro->pdf }}</small>
                            @endif
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="pdf" class="custom-file-input" id="pdfInput" accept="application/pdf">
                                <label class="custom-file-label" for="pdfInput" id="labelPdf">
                                    {{ $libro->pdf ? 'Sustituir PDF...' : 'Añadir PDF...' }}
                                </label>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary" onclick="limpiarArchivo('pdf')" title="Quitar archivo">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 border-top pt-3 d-flex justify-content-between">
                <button type="submit" class="btn btn-warning px-4 font-weight-bold shadow-sm">Actualizar Libro</button>
                <a href="{{ route('libros.index') }}" class="btn btn-light border px-4 shadow-sm text-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    function limpiarArchivo(tipo) {
        if (tipo === 'portada') {
            $('#imgPreview').hide().attr('src', '');
            $('#placeholder').show();
            $('#eliminar_portada').val('1');
            $('#labelPortada').html('Añadir imagen...');
        } else {
            $('#eliminar_pdf').val('1');
            $('#pdfInfo').empty();
            $('#labelPdf').html('Añadir PDF...');
        }
    }

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
        
        if($(this).attr('id') === 'portadaInput') {
            $('#eliminar_portada').val('0');
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#placeholder').hide();
                    $('#imgPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            }
        } else {
            $('#eliminar_pdf').val('0');
        }
    });
</script>
@stop