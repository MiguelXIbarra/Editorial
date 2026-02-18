@extends('adminlte::page')

@section('title', 'Perfil Detallado')

@section('content')
<style>
    /* Contenedor principal con altura reducida */
    .profile-container {
        position: relative;
        width: 100%;
        height: 280px; /* Tamaño reducido para que sea más pequeño */
        overflow: hidden;
        border-radius: 4px 4px 0 0;
        background-color: #f4f6f9;
    }

    /* object-fit: cover evita que la imagen se vea estirada o apachurrada */
    .profile-container img {
        width: 100%;
        height: 100%;
        object-fit: cover; 
        object-position: center; 
    }

    /* Degradado inferior con transparencia para legibilidad */
    .profile-info-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 25px 15px 10px;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);
        color: white;
        text-align: center;
    }

    .profile-info-overlay h3 {
        margin: 0;
        font-size: 1.4rem; /* Texto un poco más pequeño acorde al contenedor */
        font-weight: 700;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    }

    .profile-info-overlay .role-badge {
        display: inline-block;
        margin-top: 5px;
        padding: 2px 10px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 4px;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: bold;
    }
</style>

<div class="row pt-4">
    <div class="col-md-5">
        <div class="card card-outline card-primary shadow">
            <div class="card-body p-0">
                <div class="profile-container shadow-sm" style="background-color: #e9ecef;">
                    @if($user->foto)
                        <img src="{{ asset('img/profiles/' . $user->foto) }}" alt="Foto de perfil">
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-user-circle fa-5x mb-2" style="opacity: 0.3;"></i>
                            <h5 class="font-weight-bold">SIN FOTO DE PERFIL</h5>
                        </div>
                    @endif
                
                    <div class="profile-info-overlay">
                        <h3>{{ $user->name }}</h3>
                        <div class="role-badge">{{ $user->role }}</div>
                    </div>
                </div>
                <div class="p-3"> {{-- Reducimos el padding interno --}}
                    <ul class="list-group list-group-unbordered mb-2">
                        <li class="list-group-item" style="font-size: 0.9rem;">
                            <b>Email:</b> <span class="float-right text-muted">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item" style="font-size: 0.9rem;">
                            <b>ID:</b> <span class="float-right text-muted">#{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item" style="font-size: 0.9rem;">
                            <b>Registro:</b> <span class="float-right text-muted">{{ $user->created_at->format('d/m/Y') }}</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-block btn-sm font-weight-bold">
                        <i class="fas fa-edit mr-1"></i> Editar Datos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-info shadow">
            <div class="card-header">
                <h3 class="card-title" style="font-size: 1rem;"><i class="fas fa-info-circle mr-1"></i> Información</h3>
            </div>
            <div class="card-body">
                <p style="font-size: 0.95rem;">Nivel de acceso: <strong>{{ strtoupper($user->role) }}</strong>.</p>
                
                <div class="callout callout-info mt-3" style="font-size: 0.9rem;">
                    <h6><i class="fas fa-shield-alt text-info"></i> Seguridad</h6>
                    <p class="text-muted mb-0">Contraseña cifrada. Cambios disponibles en el panel de ajustes de cuenta.</p>
                </div>
            </div>
            <div class="card-footer text-right bg-white">
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary px-3">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>
@stop