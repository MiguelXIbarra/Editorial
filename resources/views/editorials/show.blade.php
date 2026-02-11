@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <h2>Detalles de la Editorial</h2>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $editorial->id }}</p>
                    <p><strong>Nombre:</strong> {{ $editorial->name }}</p>
                    <p><strong>Domicilio:</strong> {{ $editorial->address }}</p>
                    <p><strong>Correo Electrónico:</strong> {{ $editorial->email }}</p>
                    <p><strong>Estatus:</strong> {{ $editorial->status == 1 ? 'Activo' : 'Inactivo' }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('editoriales.index') }}" class="btn btn-primary">Regresar</a>
                    <a href="{{ route('editoriales.edit', $editorial->id) }}" class="btn btn-success">Editar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection