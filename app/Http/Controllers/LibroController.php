<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Editorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{
    public function index()
    {
        // Traemos las relaciones para mostrar nombres en lugar de IDs
        $libros = Libro::where('status', 1)->with(['autor', 'editorial'])->get();
        return view('libros.index', ['libros' => $this->cargarDT($libros)]);
    }

    public function show($id)
    {
        // Usamos 'with' para traer las relaciones y no tener errores de carga
        $libro = Libro::with(['autor', 'editorial'])->findOrFail($id);
        return view('libros.show', compact('libro'));
    }

    public function create()
    {
        $autores = Autor::where('status', 1)->get();
        $editoriales = Editorial::all();
        return view('libros.create', compact('autores', 'editoriales'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|min:3',
            'autor_id' => 'required|exists:autors,id',
            'editorial_id' => 'required|exists:editorials,id',
            'portada' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'archivo_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        $libro = new Libro($request->all());
        $libro->status = 1;

        if ($request->hasFile('portada')) {
            $file = $request->file('portada');
            $filename = time() . '-portada-' . $file->getClientOriginalName();
            $file->move(public_path('img/libros/'), $filename);
            $libro->portada = $filename;
        }

        if ($request->hasFile('archivo_pdf')) {
            $file = $request->file('archivo_pdf');
            $filename = time() . '-pdf-' . $file->getClientOriginalName();
            $file->move(public_path('pdf/libros/'), $filename);
            $libro->archivo_pdf = $filename;
        }

        $libro->save();
        return redirect()->route('libros.index')->with('message', 'Libro registrado con éxito');
    }

    public function edit($id)
    {
        $libro = Libro::findOrFail($id);
        $autores = Autor::where('status', 1)->get();
        $editoriales = Editorial::all();
        return view('libros.edit', compact('libro', 'autores', 'editoriales'));
    }

    public function update(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);
        
        $this->validate($request, [
            'titulo' => 'required|min:3',
            'portada' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'archivo_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        $libro->fill($request->all());

        if ($request->hasFile('portada')) {
            $file = $request->file('portada');
            $filename = time() . '-portada-' . $file->getClientOriginalName();
            $file->move(public_path('img/libros/'), $filename);
            $libro->portada = $filename;
        }

        if ($request->hasFile('archivo_pdf')) {
            $file = $request->file('archivo_pdf');
            $filename = time() . '-pdf-' . $file->getClientOriginalName();
            $file->move(public_path('pdf/libros/'), $filename);
            $libro->archivo_pdf = $filename;
        }

        $libro->save();
        return redirect()->route('libros.index')->with('message', 'Libro actualizado correctamente');
    }

    public function deleteLibro($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->status = 0;
        $libro->save();
        return redirect()->route('libros.index')->with('message', 'Libro eliminado');
    }

    private function cargarDT($consulta)
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $acciones = '
                <div class="btn-group">
                    <a href="'.route('libros.show', $value['id']).'" class="btn btn-sm btn-outline-info"><i class="far fa-eye"></i></a>
                    <a href="'.route('libros.edit', $value['id']).'" class="btn btn-sm btn-outline-warning mx-1"><i class="far fa-edit"></i></a>
                    <button class="btn btn-sm btn-outline-danger" onclick="modal(' . $value['id'] . ', \'' . $value['titulo'] . '\')" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
                </div>';

            $portada = ($value['portada']) 
                ? '<img src="'.asset('img/libros/'.$value['portada']).'" width="45px" class="border shadow-sm">' 
                : '<span class="badge badge-secondary">Sin portada</span>';

            $datos[$key] = [
                $acciones,
                $value['id'],
                $value['titulo'],
                $value['autor']['nombre'], 
                $value['editorial']['nombre'],
                $portada
            ];
        }
        return $datos;
    }
}