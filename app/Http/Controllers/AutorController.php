<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::where('status', 1)->get();
        return view('autors.index', ['autores' => $this->cargarDT($autores)]);
    }

    public function create()
    {
        return view('autors.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'resenia' => 'nullable',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'video'  => 'nullable|mimes:mp4,mov,ogg|max:20480', // Máx 20MB
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->input('nombre'),
                'email' => $request->input('email'),
                'password' => Hash::make('password123'),
                'role' => 'autor',
            ]);

            $autor = new Autor();
            $autor->user_id = $user->id; 
            $autor->nombre = $request->input('nombre');
            $autor->email = $request->input('email');
            $autor->resenia = $request->input('resenia');
            $autor->status = 1;

            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $filename = time() . '-img-' . $file->getClientOriginalName();
                $file->move(public_path('img/autors/'), $filename);
                $autor->imagen = $filename;
            }

            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $filename = time() . '-vid-' . $file->getClientOriginalName();
                $file->move(public_path('video/autors/'), $filename);
                $autor->video = $filename;
            }

            $autor->save();
        });

        return redirect()->route('autors.index')->with('message', 'Autor y archivos guardados correctamente');
    }

    public function show($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autors.show', compact('autor'));
    }

    public function edit($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autors.edit', compact('autor'));
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);

        // Borrado de imagen
        if ($request->borrar_foto == "1") {
            $autor->imagen = null;
            $autor->crop_data = null;
        }

        // Procesamiento de imagen (Recorte y Original)
        if ($request->cropped_image) {
            $data = $request->cropped_image;
            if (preg_match('/^data:image\/(\w+);base64,/', $data)) {
                $data = substr($data, strpos($data, ',') + 1);
                $data = base64_decode($data);
                $fileName = time() . '_autor_' . $id . '.jpg';

                // Asegurar que las carpetas existan para evitar Error 500
                $mainPath = public_path('img/autors/');
                $origPath = public_path('img/autors/originals/');
                if (!file_exists($mainPath))
                    mkdir($mainPath, 0777, true);
                if (!file_exists($origPath))
                    mkdir($origPath, 0777, true);

                // 1. Guardar Recorte
                file_put_contents($mainPath . $fileName, $data);

                // 2. Guardar Original
                if ($request->hasFile('imagen')) {
                    $request->file('imagen')->move($origPath, $fileName);
                }
                $autor->imagen = $fileName;
                $autor->crop_data = $request->crop_data;
            }
        }

        $autor->nombre = $request->nombre;
        $autor->email = $request->email;
        $autor->resenia = $request->resenia;
        $autor->save();

        return redirect()->route('autors.index');
    }
    
    public function deleteAutor($id)
    {
        $autor = Autor::findOrFail($id);
        $autor->status = 0;
        $autor->save();

        return redirect()->route('autors.index')->with('message', 'Autor eliminado correctamente');
    }

    private function cargarDT($consulta)
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $actualizar = route('autors.edit', $value['id']);
            $ver = route('autors.show', $value['id']);
            
            $foto = ($value['imagen']) 
                ? '<img src="'.asset('img/autors/'.$value['imagen']).'" width="50px" class="img-circle border shadow-sm">' 
                : '<span class="badge badge-secondary">Sin foto</span>';

            $acciones = '
                <div class="btn-group">
                    <a href="' . $ver . '" class="btn btn-sm btn-outline-info" title="Ver Detalle"><i class="far fa-eye"></i></a>
                    <a href="' . $actualizar . '" class="btn btn-sm btn-outline-warning mx-1" title="Editar"><i class="far fa-edit"></i></a>
                    <button class="btn btn-sm btn-outline-danger" onclick="modal(' . $value['id'] . ', \'' . $value['nombre'] . '\')" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
                </div>';

            $datos[$key] = [$acciones, $value['id'], $value['nombre'], $value['email'], $foto];
        }
        return $datos;
    }
}