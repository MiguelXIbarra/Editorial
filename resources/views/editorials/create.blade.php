@extends('adminlte::page')

@section('title', 'Nueva Editorial')

@section('content_header')
    <div class="bg-primary p-2 shadow-sm rounded">
        <h5 class="mb-0 text-white font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Registrar Nueva Editorial</h5>
    </div>
@stop

@section('content')
<div class="card card-outline card-primary shadow-sm mt-2">
    <div class="card-body">
        <form action="{{ route('editorials.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Nombre de la Editorial</label>
                        <input type="text" name="name" class="form-control" placeholder="Nombre oficial" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" placeholder="ejemplo@editorial.com" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Domicilio</label>
                        <input type="text" name="address" class="form-control" placeholder="Dirección completa" required>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">Guardar Editorial</button>
                <a href="{{ route('editorials.index') }}" class="btn btn-light border px-4 shadow-sm text-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop