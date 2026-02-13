@extends('adminlte::page')

@section('title', 'Detalles del Libro')

@section('content_header')
    <h1>Detalles del Libro: {{ $libro->titulo }}</h1>
@stop

@section('content')
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                @if($libro->portada)
                    <img src="{{ asset('img/portadas/' . $libro->portada) }}" class="img-fluid rounded shadow" alt="Portada" style="max-height: 400px;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded shadow" style="height: 400px;">
                        <span>Sin Portada Disponible</span>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h3 class="text-primary">{{ $libro->titulo }}</h3>
                <hr>
                <p><strong>ISBN:</strong> {{ $libro->isbn }}</p>
                
                {{-- Uso de relaciones definidas en el modelo --}}
                <p><strong>Autor:</strong> {{ $libro->autor->nombre ?? 'Sin Autor asignado' }}</p>
                <p><strong>Editorial:</strong> {{ $libro->editorial->name ?? 'Sin Editorial asignada' }}</p>
                
                <p><strong>Registrado por (Rol):</strong> <span class="badge badge-info">{{ $libro->role }}</span></p>
                
                <div class="mt-4">
                    <a href="{{ route('libros.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a la lista
                    </a>
                    <a href="{{ route('libros.edit', $libro->id) }}" class="btn btn-success">
                        <i class="fas fa-edit"></i> Editar Libro
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop