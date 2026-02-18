@extends('adminlte::page')
@section('title', 'Editar Autor')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
    .image-preview-container { position: relative; width: 150px; height: 150px; margin: 0 auto 20px; }
    .profile-user-img-edit { position: absolute; top: 0; left: 0; width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #ffc107; padding: 3px; background: #fff; }
    .overlay-edit-btn { position: absolute; bottom: 5px; right: 5px; background: #fff; border-radius: 50%; padding: 8px; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.3); z-index: 20; }
    .photo-options-menu { display: none; position: absolute; top: 105%; left: 50%; transform: translateX(-50%); background: white; border: 1px solid #ddd; border-radius: 8px; z-index: 1050; width: 190px; }
    .cropper-view-box, .cropper-face { border-radius: 50%; }
</style>
@stop

@section('content')
<div class="row pt-4 justify-content-center">
    <div class="col-md-9">
        <div class="card card-outline card-warning shadow">
            <div class="card-body">
                <form action="{{ route('autors.update', $autor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="text-center mb-4">
                        <div class="image-preview-container">
                            <div id="noPhotoPlaceholder" class="profile-user-img-edit d-flex align-items-center justify-content-center bg-no-photo {{ $autor->imagen ? 'd-none' : '' }}">
                                <span class="text-muted small font-weight-bold">SIN FOTO</span>
                            </div>
                            {{-- Usamos asset('img/profiles/...') para mostrar la imagen sincronizada --}}
                            <img src="{{ $autor->imagen ? asset('img/profiles/' . $autor->imagen) : '' }}" 
                                 id="mainPreview" 
                                 class="profile-user-img-edit {{ !$autor->imagen ? 'd-none' : '' }}">
                            
                            <div class="overlay-edit-btn" onclick="$('#photoOptionsMenu').toggle()"><i class="fas fa-camera text-warning"></i></div>
                            
                            <div class="photo-options-menu shadow-lg" id="photoOptionsMenu">
                                <button type="button" class="btn btn-light btn-block text-left m-0 border-0 {{ $autor->imagen ? 'd-none' : '' }}" id="btnAnadirImagen" onclick="$('#fileInput').click()">
                                    <i class="fas fa-plus mr-2 text-success"></i> Añadir imagen
                                </button>
                                <div id="groupHasPhoto" class="{{ !$autor->imagen ? 'd-none' : '' }}">
                                    <button type="button" class="btn btn-light btn-block text-left m-0 border-0" id="btnEditarPosicion"><i class="fas fa-arrows-alt mr-2 text-warning"></i> Editar posición</button>
                                    <button type="button" class="btn btn-light btn-block text-left m-0 border-0" onclick="$('#fileInput').click()"><i class="fas fa-sync mr-2 text-primary"></i> Cambiar imagen</button>
                                    <button type="button" class="btn btn-light btn-block text-left m-0 border-0" id="btnEliminarImagen"><i class="fas fa-trash-alt mr-2 text-danger"></i> Eliminar imagen</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label>Nombre del Autor</label><input type="text" name="nombre" class="form-control" value="{{ $autor->nombre }}" required></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Correo Electrónico</label><input type="email" name="email" class="form-control" value="{{ $autor->email }}" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"><label>Reseña</label><textarea name="resenia" class="form-control" rows="3">{{ $autor->resenia }}</textarea></div>
                        </div>
                    </div>

                    <input type="file" id="fileInput" name="imagen" style="display:none" accept="image/*">
                    <input type="hidden" id="croppedImageData" name="cropped_image">
                    <input type="hidden" id="cropDataInput" name="crop_data" value="{{ $autor->crop_data }}">
                    <input type="hidden" id="borrarFotoInput" name="borrar_foto" value="0">

                    <div class="text-right mt-3">
                        <a href="{{ route('autors.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-4 font-weight-bold">Actualizar Autor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal de recorte --}}
<div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning"><h5 class="modal-title font-weight-bold">Ajustar Posición</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body p-0 bg-dark text-center"><div style="max-height: 450px;"><img id="imageToCrop" style="max-width: 100%; display: block;"></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button><button type="button" class="btn btn-warning font-weight-bold" id="btnCrop">Guardar posición</button></div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    let tempOriginalImage = null;
    const fileInput = document.getElementById('fileInput');
    const imageToCrop = document.getElementById('imageToCrop');

    fileInput.addEventListener('change', function(e) {
        if(this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                tempOriginalImage = event.target.result; 
                imageToCrop.src = tempOriginalImage;
                $('#cropDataInput').val('');
                $('#cropperModal').modal('show');
                $('#photoOptionsMenu').hide();
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#btnEditarPosicion').on('click', function() {
    if (tempOriginalImage) {
        imageToCrop.src = tempOriginalImage;
    } else {
        // CORRECCIÓN: Ruta unificada a profiles/originals
        imageToCrop.src = "{{ asset('img/profiles/originals/') }}/" + "{{ $autor->imagen }}";
    }
    $('#cropperModal').modal('show');
    });

    $('#cropperModal').on('shown.bs.modal', function() {
        if (cropper) cropper.destroy();
        let lastData = $('#cropDataInput').val() ? JSON.parse($('#cropDataInput').val()) : null;
        cropper = new Cropper(imageToCrop, { aspectRatio: 1, viewMode: 1, data: lastData, autoCropArea: 1 });
    }).on('hidden.bs.modal', function() { if (cropper) cropper.destroy(); });

    $('#btnCrop').on('click', function() {
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        const base64 = canvas.toDataURL('image/jpeg');
        $('#noPhotoPlaceholder').addClass('d-none');
        $('#mainPreview').removeClass('d-none').attr('src', base64);
        $('#cropDataInput').val(JSON.stringify(cropper.getData()));
        $('#croppedImageData').val(base64);
        $('#borrarFotoInput').val("0");
        $('#btnAnadirImagen').addClass('d-none');
        $('#groupHasPhoto').removeClass('d-none');
        $('#cropperModal').modal('hide');
    });

    $('#btnEliminarImagen').on('click', function() {
        $('#mainPreview').addClass('d-none').attr('src', '');
        $('#noPhotoPlaceholder').removeClass('d-none');
        $('#btnAnadirImagen').removeClass('d-none');
        $('#groupHasPhoto').addClass('d-none');
        $('#borrarFotoInput').val("1");
        $('#croppedImageData').val("");
        $('#cropDataInput').val("");
        tempOriginalImage = null;
        $('#photoOptionsMenu').hide();
    });
</script>
@stop