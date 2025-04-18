<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Solucao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $solucoes = Solucao::all();
        return view('categorias.create', compact('solucoes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->titulo);

        $categoria = Categoria::create($data);

        return redirect()->route('categorias.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Categoria criada com sucesso!'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nome);

        $categoria->update($data);

        return redirect()->route('categorias.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Categoria atualizada com sucesso!'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        if ($categoria->imagem) {
            Storage::disk('public')->delete($categoria->imagem);
        }

        $categoria->delete();

        return response()->json([
            'success' => true,
            'toastr' => [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Categoria excluída com sucesso!'
            ]
        ]);
    }
}
