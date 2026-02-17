@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Datos de Cuenta</h3>
    </div>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Nombre de Usuario</label>
                <input type="text" name="name" class="form-control" placeholder="Ej. Juan Pérez" required>
            </div>
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Rol del Sistema</label>
                <select name="role" class="form-control">
                    <option value="admin">Administrador</option>
                    <option value="autor">Autor</option>
                    <option value="editor">Editor</option>
                </select>
            </div>
            <div class="form-group">
                <label>Foto de Perfil</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="foto" id="foto" accept="image/*">
                        <label class="custom-file-label" for="foto">Elegir imagen...</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>
</div>
@stop

@section('js')
<script> $(document).ready(function () { bsCustomFileInput.init(); }); </script>
@stop