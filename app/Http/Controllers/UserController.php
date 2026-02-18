<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // Cambiado de 'admin.users.index' a 'users.index'
        return view('users.index', ['users' => $this->cargarDT($users)]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        // Cambiado de 'admin.users.show' a 'users.show'
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = new User($request->all());
        $user->password = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '-user-' . $file->getClientOriginalName();
            $file->move(public_path('img/users/'), $filename);
            $user->foto = $filename;
        }

        $user->save();
        return redirect()->route('users.index')->with('message', 'Usuario creado con éxito');
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
        $user->foto = null;
        $user->crop_data = null;
    }

    if ($request->cropped_image) {
        $data = $request->cropped_image;
        if (preg_match('/^data:image\/(\w+);base64,/', $data)) {
            $data = substr($data, strpos($data, ',') + 1);
            $data = base64_decode($data);
            $fileName = time() . '_user_' . $user->id . '.jpg';

            file_put_contents(public_path('img/users/') . $fileName, $data);

            if ($request->hasFile('foto')) {
                $path = public_path('img/users/originals/');
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('foto')->move($path, $fileName);
            }
            $user->foto = $fileName;
            $user->crop_data = $request->crop_data;
        }
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role; //
    if($request->password) $user->password = Hash::make($request->password);
    
    $user->save();
    return redirect()->route('users.index');
}

    private function cargarDT($consulta)
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $ver = route('users.show', $value['id']);
            $editar = route('users.edit', $value['id']);

            $rolLabel =
                '<span class="badge badge-info">' . strtoupper($value['role']) . '</span>';

            $foto = ($value['foto']) 
            ? '<img src="'.asset('img/users/'.$value['foto']).'" 
                    class="img-circle elevation-2" 
                    style="width: 45px; height: 45px; object-fit: cover; object-position: top; border: 2px solid #fff;">' 
            : '<div class="text-center">
                    <span class="badge badge-secondary p-2" style="border-radius: 20px; font-size: 0.7rem;">
                        <i class="fas fa-user-slash mr-1"></i> SIN FOTO
                    </span>
               </div>';

            $acciones = '
                <div class="btn-group">
                    <a href="' . $ver . '" class="btn btn-sm btn-outline-info" title="Ver Detalle"><i class="far fa-eye"></i></a>
                    <a href="' . $editar . '" class="btn btn-sm btn-outline-warning mx-1" title="Editar"><i class="far fa-edit"></i></a>
                    <button class="btn btn-sm btn-outline-danger" onclick="modal(' . $value['id'] . ', \'' . $value['name'] . '\')" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
                </div>';

            $datos[$key] = [$acciones, $value['id'], $value['name'], $value['email'], $rolLabel, $foto];
        }
        return $datos;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('message', 'Usuario eliminado correctamente');
    }
}