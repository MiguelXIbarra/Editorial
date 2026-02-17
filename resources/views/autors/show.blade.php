@extends('adminlte::page')

@section('title', 'Perfil del Autor')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ $autor->imagen ? asset('img/autors/'.$autor->imagen) : asset('img/default-user.png') }}"
                         alt="Foto del autor">
                </div>
                <h3 class="profile-username text-center">{{ $autor->nombre }}</h3>
                <p class="text-muted text-center">{{ $autor->email }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <h3 class="card-title">Información Detallada</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Reseña Biográfica</strong>
                <p class="text-muted">{{ $autor->resenia ?? 'Sin reseña disponible.' }}</p>
                
                <hr>

                @if($autor->video)
                <strong><i class="fas fa-video mr-1"></i> Video de Presentación</strong>
                <div class="embed-responsive embed-responsive-16by9 mt-2">
                    <video class="embed-responsive-item" controls>
                        <source src="{{ asset('video/autors/'.$autor->video) }}" type="video/mp4">
                        Tu navegador no soporta la reproducción de videos.
                    </video>
                </div>
                @endif
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('autors.index') }}" class="btn btn-secondary">Volver al listado</a>
            </div>
        </div>
    </div>
</div>
@stop