<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function index()
    {
        $unidades = Unidade::all();
        return view('unidades.index', compact('unidades'));
    }

    public function create()
    {
        return view('unidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'cidade' => 'required|string|max:255',
            'url' => 'nullable|url|max:255'
        ]);

        $unidade = Unidade::create($request->all());

        return redirect()->route('unidades.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Unidade criada com sucesso!'
            ]);
    }

    public function edit(Unidade $unidade)
    {
        return view('unidades.edit', compact('unidade'));
    }

    public function update(Request $request, Unidade $unidade)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'cidade' => 'required|string|max:255',
            'url' => 'nullable|url|max:255'
        ]);

        $unidade->update($request->all());

        return redirect()->route('unidades.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Unidade atualizada com sucesso!'
            ]);
    }

    public function destroy(Unidade $unidade)
    {
        $unidade->delete();

        return response()->json([
            'success' => true,
            'toastr' => [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Unidade excluída com sucesso!'
            ]
        ]);
    }
}
