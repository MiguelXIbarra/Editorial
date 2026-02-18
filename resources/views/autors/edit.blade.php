@extends('adminlte::page')

@section('title', 'Editar Autor')

@section('content_header')
    <h1>Editar Información de Autor</h1>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Modificar Datos</h3>
    </div>
    <form action="{{ route('autors.update', $autor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" class="form-control" value="{{ $autor->nombre }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $autor->email }}" required>
            </div>

            <div class="form-group">
                <label>Imagen Actual</label>
                <div class="mb-2">
                    @if($autor->imagen)
                        <img src="{{ asset('img/autors/'.$autor->imagen) }}" width="100" class="img-thumbnail d-block">
                    @else
                        <span class="badge badge-secondary">Sin imagen registrada</span>
                    @endif
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imagen" name="imagen" accept="image/*">
                        <label class="custom-file-label" for="imagen">Cambiar imagen...</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Video Actual</label>
                <div class="mb-2">
                    @if($autor->video)
                        <span class="badge badge-success"><i class="fas fa-video"></i> Video registrado: {{ $autor->video }}</span>
                    @else
                        <span class="badge badge-secondary">Sin video registrado</span>
                    @endif
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="video" name="video" accept="video/mp4">
                        <label class="custom-file-label" for="video">Cambiar video...</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Actualizar Cambios</button>
            <a href="{{ route('autors.index') }}" class="btn btn-default float-right">Volver</a>
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