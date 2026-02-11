@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row">
            <h2>Editar Usuario: {{ $user->name }}</h2>
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="col-lg-7">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label>Nueva Contraseña (dejar en blanco para no cambiar)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <select name="role" class="form-control">
                        <option value="superadmin">Super Administrador</option>
                        <option value="admin">Administrador</option>
                        <option value="autor">Autor</option>
                        <option value="user">Usuario</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Actualizar Usuario</button>
            </form>
        </div>
    </div>
@endsection