@extends('adminlte::page')

@section('title', 'Detalle del Libro')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-info text-white">
            <h3 class="card-title font-weight-bold">{{ $libro->titulo }}</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @php 
                        $path = 'img/libros/portadas/' . $libro->portada;
                        $existePort = ($libro->portada && file_exists(public_path($path)));
                    @endphp

                    <div class="bg-light p-3 border rounded shadow-sm mb-3">
                        @if($existePort)
                            <img src="{{ asset($path) }}" class="img-fluid rounded" style="max-height: 400px; object-fit: contain;">
                        @else
                            <div class="py-5 text-muted">
                                <i class="fas fa-image fa-5x mb-2"></i><br>
                                <span class="font-weight-bold">SIN PORTADA DISPONIBLE</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <h4 class="border-bottom pb-2">Información General</h4>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-user-nib text-secondary mr-2"></i>
                            <strong>Autor:</strong> 
                            <span class="ml-2 text-primary">{{ $libro->autor->name ?? 'No asignado' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-building text-secondary mr-2"></i>
                            <strong>Editorial:</strong> 
                            <span class="ml-2 text-primary">{{ $libro->editorial->name ?? 'No asignada' }}</span>
                        </li>
                    </ul>

                    @if($libro->pdf && file_exists(public_path('storage/libros/pdfs/' . $libro->pdf)))
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x mr-3"></i>
                            <div>
                                <strong>Versión Digital Disponible</strong><br>
                                <a href="{{ asset('storage/libros/pdfs/' . $libro->pdf) }}" target="_blank" class="btn btn-light btn-sm mt-2 font-weight-bold">
                                    <i class="fas fa-file-pdf text-danger"></i> Abrir PDF
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x mr-3 text-dark"></i>
                            <div>
                                <span class="font-weight-bold">Este libro aún no cuenta con una versión digital en PDF.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer text-right bg-white">
            <a href="{{ route('libros.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
            <a href="{{ route('libros.edit', $libro->id) }}" class="btn btn-warning shadow-sm font-weight-bold ml-2">
                <i class="fas fa-edit"></i> Editar Libro
            </a>
        </div>
    </div>
</div>
@stop