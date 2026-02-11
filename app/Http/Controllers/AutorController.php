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
            'imagen' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        DB::transaction(function () use ($request) {
            // Crear el Usuario vinculado con rol autor
            $user = User::create([
                'name' => $request->input('nombre'),
                'email' => $request->input('email'),
                'password' => Hash::make('password123'),
                'role' => 'autor',
            ]);

            // Crear el registro en la tabla autors
            $autor = new Autor();
            $autor->user_id = $user->id; 
            $autor->nombre = $request->input('nombre');
            $autor->email = $request->input('email');
            $autor->resenia = $request->input('resenia');
            $autor->status = 1;
            $autor->role = 'autor';
    
            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move('img/autors/', $filename);
                $autor->imagen = $filename;
            }

            $autor->save();
        });

        return redirect()->route('autors.index')->with('message', 'Autor y Usuario creados correctamente');
    }

    public function edit($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autors.edit', compact('autor'));
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);
        
        $this->validate($request, [
            'nombre' => 'required|min:5',
            'email' => 'required|email|unique:users,email,' . $autor->user_id,
        ]);

        DB::transaction(function () use ($request, $autor) {
            $autor->nombre = $request->input('nombre');
            $autor->email = $request->input('email');
            $autor->resenia = $request->input('resenia');

            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move('img/autors/', $filename);
                $autor->imagen = $filename;
            }
            $autor->save();

            $user = User::find($autor->user_id);
            if ($user) {
                $user->name = $request->input('nombre');
                $user->email = $request->input('email');
                $user->save();
            }
        });

        return redirect()->route('autors.index')->with('message', 'Autor actualizado correctamente');
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
            
            $foto = ($value['imagen']) 
                ? '<img src="'.asset('img/autors/'.$value['imagen']).'" width="50px" class="img-circle">' 
                : 'Sin foto';

            // Nota: Para la Imagen 3836a3, asegúrate de usar {!! !!} en la vista
            $acciones = '
                <div class="btn-group">
                    <a href="' . $actualizar . '" class="btn btn-sm btn-success" title="Actualizar"><i class="far fa-edit"></i></a>
                    <button class="btn btn-sm btn-danger" onclick="modal(' . $value['id'] . ', \'' . $value['nombre'] . '\')" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
                </div>';

            $datos[$key] = [$acciones, $value['id'], $value['nombre'], $value['email'], $foto];
        }
        return $datos;
    }
}