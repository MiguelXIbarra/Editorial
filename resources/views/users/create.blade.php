@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row">
            <h2>Registrar Usuario</h2>
            <form action="{{ route('users.store') }}" method="POST" class="col-lg-7">
                @csrf
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
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
                <button type="submit" class="btn btn-success">Guardar Usuario</button>
            </form>
        </div>
    </div>
@endsection