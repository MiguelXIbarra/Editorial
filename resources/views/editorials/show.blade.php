@extends('adminlte::page')

@section('title', 'Detalles de la Editorial')

@section('content_header')
    <h1>Ficha de Editorial: {{ $editorial->name }}</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-building mr-1"></i> Datos Generales</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <strong><i class="fas fa-id-card mr-1"></i> ID de Registro</strong>
                        <p class="text-muted">{{ $editorial->id }}</p>
                    </div>
                    <div class="col-sm-6">
                        <strong><i class="fas fa-check-circle mr-1"></i> Estatus</strong>
                        <p>
                            @if($editorial->status == 1)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </p>
                    </div>
                </div>
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Domicilio</strong>
                <p class="text-muted">{{ $editorial->address }}</p>
                <hr>
                <strong><i class="fas fa-envelope mr-1"></i> Correo Electrónico</strong>
                <p class="text-muted">{{ $editorial->email }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('editorials.index') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i> Regresar a la lista
                </a>
                <a href="{{ route('editorials.edit', $editorial->id) }}" class="btn btn-success">
                    <i class="fas fa-edit"></i> Editar Editorial
                </a>
            </div>
        </div>
    </div>
</div>
@stop