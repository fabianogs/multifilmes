<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create(){
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $usuario = new User();
        $usuario->name = $request->input('nome');
        $usuario->username = $request->input('username');
        $usuario->email = $request->input('email');
        $usuario->password = bcrypt($request->input('password'));

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário deletado com sucesso.');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (isset($user)) {
            return view('usuarios.edit', compact('user'));
        }
        return redirect()->route('usuarios.index')->with('success', 'Usuário alterado com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (isset($user)) {
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                // The user wants to change the password
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();
        }
        return redirect()->route('usuarios.index')->with('success', 'Usuário alterado com sucesso.');
    }

}
