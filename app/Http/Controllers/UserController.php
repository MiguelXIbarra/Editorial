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
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '-user-' . $file->getClientOriginalName();
            $file->move(public_path('img/users/'), $filename);
            $user->foto = $filename;
        }

        $user->save();
        return redirect()->route('users.index')->with('message', 'Usuario actualizado');
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
                ? '<img src="'.asset('img/users/'.$value['foto']).'" width="40px" class="img-circle border shadow-sm">' 
                : '<span class="badge badge-secondary">Sin foto</span>';

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