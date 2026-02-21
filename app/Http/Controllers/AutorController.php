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
        $consulta = Autor::where('status', 1)->get();

        $autors = $this->cargarDT($consulta);

        return view('autors.index', compact('autors'));
    }
    public function create()
    {
        return view('autors.create');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('nombre');
        $user->email = $request->input('email');
        $user->password = Hash::make('12345678');
        $user->role = 'AUTOR';
        $user->status = 1;
        $user->save();

        $autor = new Autor();
        $autor->user_id = $user->id;
        $autor->name = $user->name;
        $autor->email = $user->email;
        $autor->status = 1;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_orig_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/autors/originals/'), $filename);

            $autor->image = $filename;
            
            $user->image = $filename;
            $user->save();
        }

        $autor->save();
        return redirect()->route('autors.index');
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
        $autor->name = $request->input('nombre');
        $autor->email = $request->input('email');
        $autor->description = $request->input('resenia');

        if ($request->input('cropped_image')) {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('cropped_image')));
            $fileName = time() . '_crop_auth_' . $id . '.jpg';
            file_put_contents(public_path('img/autors/' . $fileName), $data);
            $autor->image = $fileName;
        }

        $autor->save();

        $user = User::find($autor->user_id);
        if ($user) {
            $user->name = $autor->name;
            $user->email = $autor->email;
            $user->image = $autor->image;
            $user->save();
        }

        return redirect()->route('autors.index');
    }

    private function cargarDT($consulta): array
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $actualizar = route('autors.edit', $value['id']);
            $ver = route('autors.show', $value['id']);

            $foto = $value['image']
                ? '<img src="' . asset('img/autors/' . $value['image']) . '" class="img-circle elevation-1" style="width: 35px; height: 35px; object-fit: cover;">'
                : '<span class="badge badge-secondary">SIN FOTO</span>';

            $acciones = '
            <div class="btn-group">
                <a href="' . route('autors.show', $value['id']) . '" 
                class="btn btn-sm btn-outline-info" 
                title="Ver Detalle">
                <i class="far fa-eye"></i>
                </a>

                <a href="' . route('autors.edit', $value['id']) . '" 
                class="btn btn-sm btn-outline-warning mx-1" 
                title="Editar">
                <i class="far fa-edit"></i>
                </a>

                <button class="btn btn-sm btn-outline-danger" 
                        onclick="modal(' . $value['id'] . ', \'' . addslashes($value['name']) . '\')" 
                        data-toggle="modal" 
                        data-target="#deleteModal" 
                        title="Eliminar">
                    <i class="far fa-trash-alt"></i>
                </button>
            </div>';

            $datos[$key] = [
                $acciones,
                $value['id'],
                $value['name'],
                $value['email'],
                '<span class="badge badge-info">AUTOR</span>',
                $foto
            ];
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