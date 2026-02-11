@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <h2>Editar Autor: {{ $autor->nombre }}</h2>
        <form action="{{ route('autors.update', $autor->id) }}" method="post" enctype="multipart/form-data" class="col-lg-7">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $autor->nombre }}" required />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $autor->email }}" required />
            </div>

            <div class="form-group">
                <label for="resenia">Reseña</label>
                <textarea class="form-control" id="resenia" name="resenia" rows="3">{{ $autor->resenia }}</textarea>
            </div>

            <div class="form-group">
                <label for="role">Editado por (Rol)</label>
                <input type="text" class="form-control" value="{{ Auth::user()->role }}" readonly />
            </div>

            <button type="submit" class="btn btn-success">Actualizar Datos</button>
            <a href="{{ route('autors.index') }}" class="btn btn-primary">Regresar</a>
        </form>
    </div>
</div>
@endsection