@extends('adminlte::page')

@section('title', 'Detalle de Editorial')

@section('content_header')
    <div class="bg-info p-2 shadow-sm rounded">
        <h5 class="mb-0 text-white font-weight-bold"><i class="fas fa-eye mr-2"></i>Información de la Editorial</h5>
    </div>
@stop

@section('content')
<div class="card card-outline card-info shadow-sm mt-2">
    <div class="card-body">
        <div class="p-4 rounded shadow-xs" style="background: #f8f9fa; border-left: 5px solid #17a2b8; border: 1px solid #ddd; border-left-width: 5px;">
            <div class="row">
                <div class="col-md-12">
                    <label class="text-info small font-weight-bold uppercase mb-0">NOMBRE OFICIAL</label>
                    <h2 class="font-weight-bold text-dark mb-4">{{ $editorial->name }}</h2>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-secondary small font-weight-bold">CORREO ELECTRÓNICO</label>
                    <p class="lead"><i class="fas fa-envelope text-info mr-2"></i>{{ $editorial->email }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-secondary small font-weight-bold">DOMICILIO FISCAL</label>
                    <p class="lead"><i class="fas fa-map-marker-alt text-info mr-2"></i>{{ $editorial->address }}</p>
                </div>
            </div>
            <hr>
            <div class="d-flex text-muted small">
                <span><i class="fas fa-id-badge mr-1"></i> ID: {{ $editorial->id }}</span>
                <span class="ml-4"><i class="fas fa-calendar-alt mr-1"></i> Registrada: {{ $editorial->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ route('editorials.index') }}" class="btn btn-secondary px-4 shadow-sm mr-2">Volver</a>
            <a href="{{ route('editorials.edit', $editorial->id) }}" class="btn btn-warning px-4 font-weight-bold shadow-sm text-dark">Editar Datos</a>
        </div>
    </div>
</div>
@stop