<?php

namespace App\Http\Controllers;

use App\Models\Solucao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SolucaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solucoes = Solucao::all();
        return view('solucoes.index', compact('solucoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('solucoes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($request->titulo);

        Solucao::create($validated);

        return redirect()->route('solucoes.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Solução criada com sucesso!',
            'title' => 'Sucesso'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Solucao $solucao)
    {
        return view('solucoes.show', compact('solucao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $solucao = Solucao::find($id);
        return view('solucoes.edit', compact('solucao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solucao $solucao)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($request->titulo);

        $solucao->update($validated);

        return redirect()->route('solucoes.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Solução atualizada com sucesso!',
            'title' => 'Sucesso'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solucao $solucao)
    {
        $solucao->delete();
        return response()->json([
            'success' => true,
            'toastr' => [
                'type' => 'success',
                'message' => 'Solução excluída com sucesso!',
                'title' => 'Sucesso'
            ]
        ]);
    }
}
