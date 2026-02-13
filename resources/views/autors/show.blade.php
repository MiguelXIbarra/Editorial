@extends('adminlte::page')

@section('title', 'Detalle del Autor')

@section('content_header')
    <h1>Ficha Técnica: {{ $autor->nombre }}</h1>
@stop

@section('content')
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title">Información del Autor</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                {{-- Renderizamos la imagen del autor --}}
                @if($autor->imagen)
                    <img src="{{ asset('storage/' . $autor->imagen) }}" 
                         class="img-fluid rounded shadow border" 
                         style="max-height: 350px;" 
                         alt="Foto de {{ $autor->nombre }}">
                @else
                    <div class="bg-gray d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                        <i class="fas fa-user-tie fa-5x"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h2 class="text-info">{{ $autor->nombre }}</h2>
                <p class="text-muted"><i class="fas fa-envelope"></i> {{ $autor->email }}</p>
                <hr>
                <h5><strong>Biografía / Reseña:</strong></h5>
                <p class="text-justify" style="font-size: 1.1rem; line-height: 1.6;">
                    {{ $autor->resenia ?: 'Este autor no cuenta con una reseña registrada actualmente.' }}
                </p>
                
                <div class="mt-5">
                    <a href="{{ route('autors.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Ver todos los autores
                    </a>
                    <a href="{{ route('autors.edit', $autor->id) }}" class="btn btn-success">
                        <i class="fas fa-user-edit"></i> Editar Información
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop