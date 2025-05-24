<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('unidade')->get();
        return view('usuarios.index', compact('users'));
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('usuarios.create', compact('unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'O nome é obrigatório',
            'name.max' => 'O nome não pode ter mais de 255 caracteres',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
        ]);

        if ($request['role'] === 'franqueado' && isset($request['unidade_id'])) {
            $unidadeJaAtribuida = User::where('unidade_id', $request['unidade_id'])->exists();
            if ($unidadeJaAtribuida) {
                return back()->withErrors(['unidade_id' => 'Esta unidade já está atribuída a outro usuário.'])->withInput();
            }
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
            'unidade_id' => $request['role'] === 'franqueado' ? $request['unidade_id'] : null
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function show($id)
    {
        $user = User::with('unidade')->findOrFail($id);
        return view('usuarios.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('unidade')->findOrFail($id);
        $unidades = Unidade::all();
        return view('usuarios.edit', compact('user', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,franqueado',
            'unidade_id' => 'required_if:role,franqueado|exists:unidades,id'
        ]);

        if ($validated['role'] === 'franqueado' && isset($validated['unidade_id'])) {
            $unidadeJaAtribuida = User::where('unidade_id', $validated['unidade_id'])
                ->where('id', '!=', $user->id)
                ->exists();
            if ($unidadeJaAtribuida) {
                return back()->withErrors(['unidade_id' => 'Esta unidade já está atribuída a outro usuário.'])->withInput();
            }
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'unidade_id' => $validated['role'] === 'franqueado' ? $validated['unidade_id'] : null
        ]);

        if ($validated['password']) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}
