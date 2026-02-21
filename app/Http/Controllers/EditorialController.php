<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    public function index()
    {
        $editorials = Editorial::all();
        return view('editorials.index', compact('editorials'));
    }

    public function create()
    {
        return view('editorials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required'
        ]);

        Editorial::create($request->all());
        return redirect()->route('editorials.index')->with('success', 'Editorial creada.');
}

    public function show($id)
    {
        $editorial = Editorial::findOrFail($id);
        return view('editorials.show', compact('editorial'));
    }

    public function edit($id)
    {
        $editorial = Editorial::findOrFail($id);
        return view('editorials.edit', compact('editorial'));
    }

    public function update(Request $request, $id)
    {
        $editorial = Editorial::findOrFail($id);
        
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:editorials,email,' . $id,
            'address' => 'required'
        ]);

        $editorial->update($request->all());

        return redirect()->route('editorials.index')->with('success', 'Editorial actualizada.');
    }

    public function destroy($id)
    {
        $editorial = Editorial::findOrFail($id);
        $editorial->delete();
        return redirect()->route('editorials.index')->with('success', 'Editorial eliminada.');
    }
}