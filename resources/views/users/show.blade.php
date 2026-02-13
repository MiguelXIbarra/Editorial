@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
    <h1>Perfil del Usuario: {{ $user->name }}</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                         alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ ucfirst($user->role) }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>ID de Sistema</b> <a class="float-right">{{ $user->id }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Cuenta creada</b> <a class="float-right">{{ $user->created_at->format('d/m/Y') }}</a>
                    </li>
                </ul>

                <div class="text-center">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary"><b>Volver</b></a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success"><b>Editar Datos</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop