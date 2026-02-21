@extends('adminlte::page')

@section('title', 'Editar Editorial')

@section('content_header')
    <div class="bg-warning p-2 shadow-sm rounded">
        <h5 class="mb-0 text-dark font-weight-bold"><i class="fas fa-edit mr-2"></i>Editar Editorial: {{ $editorial->name }}</h5>
    </div>
@stop

@section('content')
<div class="card card-outline card-warning shadow-sm mt-2">
    <div class="card-body">
        <form action="{{ route('editorials.update', $editorial->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Nombre de la Editorial</label>
                        <input type="text" name="name" class="form-control" value="{{ $editorial->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ $editorial->email }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Domicilio</label>
                        <input type="text" name="address" class="form-control" value="{{ $editorial->address }}" required>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-warning px-4 font-weight-bold shadow-sm text-dark">Actualizar Editorial</button>
                <a href="{{ route('editorials.index') }}" class="btn btn-light border px-4 shadow-sm text-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop