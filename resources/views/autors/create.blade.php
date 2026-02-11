@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <h2>Crear Nuevo Autor</h2>
        <form action="{{ route('autors.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
            @csrf
            
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required />
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required />
            </div>

            <div class="form-group">
                <label for="resenia">Reseña</label>
                <textarea class="form-control" id="resenia" name="resenia" rows="3">{{ old('resenia') }}</textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Fotografía del Autor</label>
                <input type="file" class="form-control" id="imagen" name="imagen" />
            </div>

            <button type="submit" class="btn btn-success">Guardar Autor</button>
            <a href="{{ route('autors.index') }}" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</div>
@endsection