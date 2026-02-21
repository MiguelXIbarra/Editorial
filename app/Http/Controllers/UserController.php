<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $consulta = User::all();
        $users = $this->cargarDT($consulta);
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('nombre');
        $user->email = $request->input('email');
        $user->password = Hash::make('12345678');
        $user->role = $request->input('role') ?? 'AUTOR';
        $user->status = 1;
        $user->save();

        if ($user->role == 'AUTOR') {
            Autor::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => 1
            ]);
        }

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->borrar_foto == "1") {
            $user->image = null;
            $user->crop_data = null;
            if ($user->role == 'AUTOR' && $user->autor) {
                $user->autor->update(['image' => null, 'crop_data' => null]);
            }
        }


        if ($request->cropped_image) {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->cropped_image));
            $fileName = time() . '_profile_' . $user->id . '.jpg';

            $path = public_path('img/profiles/');
            if (!file_exists($path . 'originals/'))
                mkdir($path . 'originals/', 0777, true);

            file_put_contents($path . $fileName, $data);
            if ($request->hasFile('foto')) {
                $request->file('foto')->move($path . 'originals/', $fileName);
            }

            $user->image = $fileName;
            $user->crop_data = $request->crop_data;

            if ($user->role == 'AUTOR' && $user->autor) {
                $user->autor->update([
                    'image' => $fileName,
                    'crop_data' => $request->crop_data
                ]);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->password)
            $user->password = Hash::make($request->password);

        $user->save();
        return redirect()->route('users.index');
    }


    private function cargarDT($consulta)
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $ver = route('users.show', $value['id']);
            $editar = route('users.edit', $value['id']);
            $rolLabel = '<span class="badge badge-info">' . strtoupper($value['role']) . '</span>';

            $nombreImagen = $value['image'];
            $fotoHtml = '<span class="badge badge-secondary">SIN FOTO</span>';

            if ($nombreImagen) {
                $rutaAutor = 'img/autors/' . $nombreImagen;
                $rutaPerfil = 'img/profiles/' . $nombreImagen;

                $urlFinal = null;
                if (file_exists(public_path($rutaAutor))) {
                    $urlFinal = asset($rutaAutor);
                } elseif (file_exists(public_path($rutaPerfil))) {
                    $urlFinal = asset($rutaPerfil);
                }

                if ($urlFinal) {
                    $fotoHtml = '<img src="' . $urlFinal . '" 
                    style="width: 40px !important; 
                           height: 40px !important; 
                           object-fit: cover !important; 
                           object-position: center !important; 
                           border-radius: 50% !important; 
                           border: 1px solid #dee2e6;">';
                }
            }

            $acciones = '
            <div class="btn-group">
                <a href="' . $ver . '" class="btn btn-sm btn-outline-info" title="Ver Detalle"><i class="far fa-eye"></i></a>
                <a href="' . $editar . '" class="btn btn-sm btn-outline-warning mx-1" title="Editar"><i class="far fa-edit"></i></a>
                <button class="btn btn-sm btn-outline-danger" onclick="modal(' . $value['id'] . ', \'' . $value['name'] . '\')" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
            </div>';

            $datos[$key] = [$acciones, $value['id'], $value['name'], $value['email'], $rolLabel, $fotoHtml];
        }
        return $datos;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->foto && file_exists(public_path('img/users/' . $user->foto))) {
            unlink(public_path('img/users/' . $user->foto));
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'El usuario ha sido eliminado correctamente.');
}
}