@extends('adminlte::page')

@section('content')
<div class="container">
    <h2>Registrar Nuevo Libro</h2>
    {{-- Se agrega enctype="multipart/form-data" para permitir el envío de archivos --}}
    <form action="{{ route('libros.store') }}" method="post" class="col-lg-7" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>

        {{-- Nuevo campo para la Portada --}}
        <div class="form-group">
            <label>Portada</label>
            <input type="file" name="portada" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label>Autor</label>
            <select name="autor_id" class="form-control">
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}">{{ $autor->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Editorial</label>
            <select name="editorial_id" class="form-control">
                @foreach($editoriales as $editorial)
                    <option value="{{ $editorial->id }}">{{ $editorial->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar Libro</button>
    </form>
</div>
@endsection