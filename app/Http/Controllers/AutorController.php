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

        // Borrado sincronizado
        if ($request->borrar_foto == "1") {
            $autor->imagen = null;
            $autor->crop_data = null;
            if ($autor->user) {
                $autor->user->update(['foto' => null, 'crop_data' => null]);
            }
        }

        // Procesamiento en carpeta unificada 'profiles'
        if ($request->cropped_image) {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->cropped_image));
            $fileName = time() . '_profile_auth_' . $id . '.jpg';

            $path = public_path('img/profiles/');
            if (!file_exists($path . 'originals/'))
                mkdir($path . 'originals/', 0777, true);

            file_put_contents($path . $fileName, $data);
            if ($request->hasFile('imagen')) {
                $request->file('imagen')->move($path . 'originals/', $fileName);
            }

            $autor->imagen = $fileName;
            $autor->crop_data = $request->crop_data;

            // SINCRONIZACIÓN: Actualiza la tabla users
            if ($autor->user) {
                $autor->user->update([
                    'foto' => $fileName,
                    'crop_data' => $request->crop_data
                ]);
            }
        }

        $autor->nombre = $request->nombre;
        $autor->email = $request->email;
        $autor->resenia = $request->resenia;
        $autor->save();

        return redirect()->route('autors.index');
    }

    private function cargarDT($consulta)
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $actualizar = route('autors.edit', $value['id']);
            $ver = route('autors.show', $value['id']);
            
            $foto = $value['imagen'];

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

    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);
        $autor->status = 0;
        $autor->save();

        return redirect()->route('autors.index')->with('message', 'Autor eliminado correctamente');
    }
}