@extends('adminlte::page')

@section('title', 'Registrar Autor')

@section('content_header')
    <h1>Nuevo Autor</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Formulario de Registro</h3>
            </div>
            
            <form action="{{ route('autors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ingrese nombre completo">
                        @error('nombre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Reseña Biográfica</label>
                        <textarea name="resenia" class="form-control" rows="3">{{ old('resenia') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="imagen">Fotografía Perfil (Imagen)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imagen" name="imagen" accept="image/*">
                                <label class="custom-file-label" for="imagen">Seleccionar archivo...</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="video">Video de Presentación (MP4)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="video" name="video" accept="video/mp4">
                                <label class="custom-file-label" for="video">Seleccionar video...</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar Autor</button>
                    <a href="{{ route('autors.index') }}" class="btn btn-default float-right">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@stop