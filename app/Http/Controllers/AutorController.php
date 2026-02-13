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

            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $destinatinoPath = 'img/autors/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('imagen')->move($destinatinoPath, $filename);
                $autor->imagen = $filename;
            }

            $autor->save();
        });

        return redirect()->route('autors.index')->with('message', 'Autor creado exitosamente');
    }

    // Método Show agregado para ver los detalles del autor
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
        
        $this->validate($request, [
            'nombre' => 'required|min:5',
            'email' => 'required|email|unique:users,email,' . $autor->user_id,
        ]);

        DB::transaction(function () use ($request, $autor) {
            $autor->nombre = $request->input('nombre');
            $autor->email = $request->input('email');
            $autor->resenia = $request->input('resenia');
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

    // Método cargarDT modificado con los botones de acción en estilo outline
    private function cargarDT($consulta)
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $actualizar = route('autors.edit', $value['id']);
            
            $foto = ($value['imagen']) 
                ? '<img src="'.asset('img/autors/'.$value['imagen']).'" width="50px" class="img-circle border shadow-sm">' 
                : '<span class="text-muted">Sin foto</span>';

            // Botones corregidos: Sin duplicados y con estilo btn-outline (blancos con borde)
            $acciones = '
                <div class="btn-group shadow-sm">
                    <a href="' . $actualizar . '" class="btn btn-sm btn-outline-warning mx-1" title="Editar">
                        <i class="far fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" 
                            onclick="modal(' . $value['id'] . ', \'' . $value['nombre'] . '\')" 
                            data-toggle="modal" data-target="#deleteModal" title="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>';

            $datos[$key] = [
                $acciones,
                $value['id'],
                $value['email'],
                $value['nombre'],
                $foto
            ];
        }
        return $datos;
    }
}