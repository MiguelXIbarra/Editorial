@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <h2>Editar Editorial</h2>
        <form action="{{ route('editorials.update', $editorial->id) }}" method="post" class="col-lg-7">
            @csrf
            @method('PUT')
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$editorial->name}}" />
            </div>

            <div class="form-group">
                <label for="address">Domicilio</label>
                <textarea class="form-control" id="address" name="address">{{$editorial->address}}</textarea>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="{{$editorial->email}}" />
            </div>

            <button type="submit" class="btn btn-success">Actualizar Editorial</button>
        </form>
    </div>
</div>
@endsection