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
        $consulta = Libro::with(['autor', 'editorial'])->get();
        $libros = $this->cargarDT($consulta);

        return view('libros.index', compact('libros'));
    }

    public function show($id)
    {
        $libro = Libro::with(['autor', 'editorial'])->findOrFail($id);

        return view('libros.show', compact('libro'));
    }

    public function create()
{
    $autores = Autor::all();
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
        $autores = Autor::all();
        $editoriales = Editorial::all();

        return view('libros.edit', compact('libro', 'autores', 'editoriales'));
    }

    public function update(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);

        // 1. Lógica del Botón Gris (Eliminar archivo actual)
        if ($request->eliminar_portada == "1") {
            if ($libro->portada && file_exists(public_path('img/libros/portadas/' . $libro->portada))) {
                unlink(public_path('img/libros/portadas/' . $libro->portada));
            }
            $libro->portada = null;
        }

        if ($request->eliminar_pdf == "1") {
            if ($libro->pdf && file_exists(public_path('storage/libros/pdfs/' . $libro->pdf))) {
                unlink(public_path('storage/libros/pdfs/' . $libro->pdf));
            }
            $libro->pdf = null;
        }

        if ($request->hasFile('portada')) {
            if ($libro->portada && file_exists(public_path('img/libros/portadas/' . $libro->portada))) {
                unlink(public_path('img/libros/portadas/' . $libro->portada));
            }

            $file = $request->file('portada');
            $nombreFoto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/libros/portadas'), $nombreFoto);
            $libro->portada = $nombreFoto;
        }

        // 3. Subida de Nuevo PDF
        if ($request->hasFile('pdf')) {
            if ($libro->pdf && file_exists(public_path('storage/libros/pdfs/' . $libro->pdf))) {
                unlink(public_path('storage/libros/pdfs/' . $libro->pdf));
            }

            $file = $request->file('pdf');
            $nombrePdf = time() . '_libro.pdf';
            $file->move(public_path('storage/libros/pdfs'), $nombrePdf);
            $libro->pdf = $nombrePdf;
        }

        $libro->titulo = $request->titulo;
        $libro->autor_id = $request->autor_id;
        $libro->editorial_id = $request->editorial_id;

        $libro->save();

        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente');
    }

    public function deleteLibro($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->status = 0;
        $libro->save();
        return redirect()->route('libros.index')->with('message', 'Libro eliminado');
    }

    private function cargarDT($consulta): array
    {
        $datos = [];
        foreach ($consulta as $key => $value) {
            $ver = route('libros.show', $value['id']);
            $editar = route('libros.edit', $value['id']);

            // 1. Botones de Acción
            $acciones = '
<div class="btn-group">
    <a href="' . $ver . '" class="btn btn-sm btn-outline-info" title="Ver Detalle"><i class="far fa-eye"></i></a>
    <a href="' . $editar . '" class="btn btn-sm btn-outline-warning mx-1" title="Editar"><i class="fas fa-edit"></i></a>
    <button class="btn btn-sm btn-outline-danger" onclick="modal(' . $value['id'] . ', \'' . addslashes($value['titulo']) . '\')" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i></button>
</div>';

            $rutaPortada = 'img/libros/portadas/' . $value['portada'];

            if ($value['portada'] && file_exists(public_path($rutaPortada))) {
                $portada = '<img src="' . asset($rutaPortada) . '" 
                style="width: 50px; height: 70px; object-fit: contain; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px;">';
            } else {
                $portada = '<span class="badge badge-secondary">SIN PORTADA</span>';
            }

            $rutaPdf = 'storage/libros/pdfs/' . $value['pdf'];
            $pdf = ($value['pdf'] && file_exists(public_path($rutaPdf)))
                ? '<a href="' . asset($rutaPdf) . '" target="_blank" class="text-danger"><i class="fas fa-file-pdf fa-2x"></i></a>'
                : '<i class="fas fa-times-circle text-muted fa-2x"></i>';

            $datos[$key] = [$acciones, $value['id'], $value['titulo'], $value->autor->name ?? 'N/A', $value->editorial->name ?? 'N/A', $portada, $pdf];
        }
        return $datos;
    }
}