@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
<div class="card card-warning shadow">
    <div class="card-header">
        <h3 class="card-title">Modificar datos de: {{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select name="role" class="form-control">
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="autor" {{ $user->role == 'autor' ? 'selected' : '' }}>Autor</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Contraseña (Opcional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="foto">Foto de Perfil</label>
                <input type="file" name="foto" class="form-control-file">
                @if($user->foto)
                    <small class="text-muted">Ya tienes una foto guardada. Sube una nueva solo si quieres cambiarla.</small>
                @endif
            </div>

            <div class="text-right">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-warning px-4"><b>Guardar Cambios</b></button>
            </div>
        </form>
    </div>
</div>
@stop