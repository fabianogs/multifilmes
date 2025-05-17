<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Solucao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('solucoes')->get();
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

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'solucoes' => 'nullable|array',
            'solucoes.*' => 'exists:solucoes,id',
        ]);

        $data = $request->only(['nome', 'descricao']);
        $data['slug'] = Str::slug($request->nome);

        $categoria = Categoria::create($data);

        // Associa as soluções (muitos-para-muitos)
        if ($request->has('solucoes')) {
            $categoria->solucoes()->sync($request->solucoes);
        }

        return redirect()->route('categorias.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Categoria criada com sucesso!'
            ]);
    }


    public function edit(Categoria $categoria)
    {
        $solucoes = Solucao::all();
        return view('categorias.edit', compact('categoria', 'solucoes'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'solucoes' => 'array', // pode ser vazio (nenhuma marcada)
            'solucoes.*' => 'exists:solucoes,id',
        ]);

        $data = $request->only(['nome', 'descricao']);
        $data['slug'] = Str::slug($request->nome);

        $categoria->update($data);

        // Atualiza os relacionamentos many-to-many
        $categoria->solucoes()->sync($request->input('solucoes', [])); // se nada for enviado, remove todos

        return redirect()->route('categorias.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Categoria atualizada com sucesso!'
            ]);
    }


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
