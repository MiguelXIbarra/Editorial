@extends('adminlte::page')

@section('title', 'Detalle del Libro')

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">{{ $libro->titulo }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                @if($libro->portada)
                    <img src="{{ asset('img/libros/'.$libro->portada) }}" class="img-fluid img-thumbnail shadow" style="max-height: 400px;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center shadow" style="height: 300px;">
                        <span>Sin Portada</span>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h4>Información General</h4>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Autor:</b> <a class="float-right text-primary">{{ $libro->autor->nombre }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Editorial:</b> <a class="float-right text-muted">{{ $libro->editorial->nombre }}</a>
                    </li>
                </ul>
                
                @if($libro->archivo_pdf)
                    <h5 class="mt-4"><i class="fas fa-file-pdf text-danger"></i> Visor de Lectura</h5>
                    <div class="border rounded" style="height: 500px; overflow: hidden;">
                        <embed src="{{ asset('pdf/libros/'.$libro->archivo_pdf) }}" type="application/pdf" width="100%" height="100%" />
                    </div>
                @else
                    <div class="alert alert-warning mt-3">
                        <i class="icon fas fa-exclamation-triangle"></i> Este libro aún no cuenta con una versión digital en PDF.
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a href="{{ route('libros.index') }}" class="btn btn-default">Cerrar Detalle</a>
    </div>
</div>
@stop