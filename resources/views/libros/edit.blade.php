@extends('adminlte::page')

@section('title', 'Editar Libro')

@section('content_header')
    <h1>Editar Libro: {{ $libro->titulo }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Edición</h3>
                </div>
                
                {{-- Es vital incluir enctype="multipart/form-data" para permitir subir la nueva portada --}}
                <form action="{{ route('libros.update', $libro->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="titulo">Título del Libro</label>
                            <input type="text" name="titulo" class="form-control" id="titulo" value="{{ $libro->titulo }}" required>
                        </div>

                        <div class="form-group">
                            <label for="isbn">ISBN (No editable)</label>
                            <input type="text" class="form-control" value="{{ $libro->isbn }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="portada">Cambiar Portada</label>
                            <div class="row mb-2">
                                <div class="col-sm-3">
                                    @if($libro->portada)
                                        <p>Actual:</p>
                                        <img src="{{ asset('img/portadas/'.$libro->portada) }}" class="img-thumbnail" width="100">
                                    @else
                                        <p class="text-muted">Sin portada actual</p>
                                    @endif
                                </div>
                            </div>
                            <input type="file" name="portada" class="form-control" id="portada" accept="image/*">
                            <small class="text-muted">Formatos permitidos: JPG, PNG, JPEG. Máximo 2MB.</small>
                        </div>

                        <div class="form-group">
                            <label for="autor_id">Autor</label>
                            <select name="autor_id" class="form-control" required>
                                @foreach($autores as $autor)
                                    <option value="{{ $autor->id }}" {{ $libro->autor_id == $autor->id ? 'selected' : '' }}>
                                        {{ $autor->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="editorial_id">Editorial</label>
                            <select name="editorial_id" class="form-control" required>
                                @foreach($editoriales as $editorial)
                                    <option value="{{ $editorial->id }}" {{ $libro->editorial_id == $editorial->id ? 'selected' : '' }}>
                                        {{ $editorial->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Actualizar Libro</button>
                        <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop