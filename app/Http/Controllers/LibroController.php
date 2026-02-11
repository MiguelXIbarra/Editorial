<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Editorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::where('status', 1)->get();
        return view('libros.index', ['libros' => $this->cargarDT($libros)]);
    }

    public function create()
    {
        $autores = Autor::where('status', 1)->get();
        $editoriales = Editorial::where('status', 1)->get();
        return view('libros.create', compact('autores', 'editoriales'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|min:3',
            'isbn' => 'required|unique:libros',
            'autor_id' => 'required',
            'editorial_id' => 'required',
            'portada' => 'nullable|image|mimes:jpg,png,jpeg|max:2048' // Cambiado a nullable
        ]);

        $libro = new Libro();
        $libro->titulo = $request->input('titulo');
        $libro->isbn = $request->input('isbn');
        $libro->autor_id = $request->input('autor_id');
        $libro->editorial_id = $request->input('editorial_id');
        $libro->status = 1;
        $libro->role = Auth::user()->role; 

        if ($request->hasFile('portada')) {
            $file = $request->file('portada');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move('img/portadas/', $filename);
            $libro->portada = $filename;
        } else {
            $libro->portada = null; // Aseguramos que guarde null si no hay archivo
        }

        $libro->save();

        return redirect()->route('libros.index')->with('message', 'Libro guardado correctamente');
    }

    public function show(string $id)
    {
        $libro = Libro::with(['autor', 'editorial'])->findOrFail($id);
        return view('libros.show', compact('libro'));
    }

    public function edit(string $id)
    {
        $libro = Libro::findOrFail($id);
        $autores = Autor::where('status', 1)->get();
        $editoriales = Editorial::where('status', 1)->get();
        return view('libros.edit', compact('libro', 'autores', 'editoriales'));
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'portada' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $libro = Libro::findOrFail($id);
        
        if ($request->hasFile('portada')) {
            $file = $request->file('portada');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move('img/portadas/', $filename);
            $libro->portada = $filename;
        }

        $libro->titulo = $request->input('titulo');
        $libro->autor_id = $request->input('autor_id');
        $libro->editorial_id = $request->input('editorial_id');
        $libro->save();

        return redirect()->route('libros.index')->with('message', 'Libro actualizado');
    }

    public function deleteLibro($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->status = 0;
        $libro->save();
        return redirect()->route('libros.index')->with("message", "Libro eliminado");
    }

    private function cargarDT($consulta)
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $actualizar = route('libros.edit', $value['id']);
            $ver = route('libros.show', $value['id']);
            
            $foto = ($value['portada']) 
                ? '<img src="'.asset('img/portadas/'.$value['portada']).'" width="40px" class="img-thumbnail">' 
                : 'Sin portada';

            $acciones = '
                <div class="btn-group">
                    <a href="' . $ver . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                    <a href="' . $actualizar . '" class="btn btn-sm btn-success"><i class="far fa-edit"></i></a>
                    <button class="btn btn-sm btn-danger" onclick="modal(' . $value['id'] . ', \'' . $value['titulo'] . '\')" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
                </div>';

            $datos[$key] = [$acciones, $value['id'], $value['titulo'], $foto, $value['isbn'], $value['role']];
        }
        return $datos;
    }
}