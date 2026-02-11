<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorialController extends Controller
{
    public function index()
    {
        $editorials = Editorial::where('status', 1)->get();
        return view('editorials.index', ['editorials' => $this->cargarDT($editorials)]);
    }

    public function create()
    {
        return view('editorials.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5',
            'address' => 'required',
            'email' => 'required|email'
        ]);

        $editorial = new Editorial();
        $editorial->name = $request->input('name');
        $editorial->address = $request->input('address');
        $editorial->email = $request->input('email');
        $editorial->status = 1;
        $editorial->save();

        return redirect()->route('editorials.index')->with('message', 'Editorial guardada');
    }

    public function show(string $id)
    {
        $editorial = Editorial::findOrFail($id);
        return view('editorials.show', compact('editorial'));
    }

    public function edit(string $id)
    {
        $editorial = Editorial::findOrFail($id);
        return view('editorials.edit', compact('editorial'));
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|min:5',
            'address' => 'required',
            'email' => 'required|email'
        ]);

        $editorial = Editorial::findOrFail($id);
        $editorial->name = $request->input('name');
        $editorial->address = $request->input('address');
        $editorial->email = $request->input('email'); 
        $editorial->save();

        return redirect()->route('editorials.index')->with('message', 'Editorial actualizada');
    }

    public function deleteEditorial($id)
    {
        $editorial = Editorial::findOrFail($id);
        $editorial->status = 0;
        $editorial->save();
        return redirect()->route('editorials.index')->with("message", "Editorial eliminada");
    }

    private function cargarDT($consulta)
    {
        $datos = [];
        $userRole = Auth::user()->role;
        foreach ($consulta as $key => $value) {
            $actualizar = route('editorials.edit', $value['id']);
            $ver = route('editorials.show', $value['id']);
            
            $acciones = '
            <div class="btn-group">
                <a href="' . $ver . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                <a href="' . $actualizar . '" class="btn btn-sm btn-success"><i class="far fa-edit"></i></a>
                <button class="btn btn-sm btn-danger" onclick="modal(' . $value['id'] . ', \'' . $value['name'] . '\')" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
            </div>';

            $datos[$key] = [$acciones, $value['id'], $value['email'], $value['name'], $value['address'], $userRole];
        }
        return $datos;
    }
}