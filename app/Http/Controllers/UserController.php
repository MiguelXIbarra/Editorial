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
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:superadmin,admin,autor,user'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('message', 'Usuario creado');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:superadmin,admin,autor,user'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('users.index')->with('message', 'Usuario actualizado');
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('message', 'Usuario eliminado');
    }
}