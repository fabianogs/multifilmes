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
            'video' => 'nullable|url|max:500',
            'solucoes' => 'nullable|array',
            'solucoes.*' => 'exists:solucoes,id',
            'icone' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['nome', 'descricao', 'video']);
        $data['slug'] = Str::slug($request->nome);

        // Upload do ícone
        if ($request->hasFile('icone')) {
            $file = $request->file('icone');
            $filename = Str::slug($request->nome) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $data['icone'] = $file->storeAs('categorias/icones', $filename, 'public');
        }

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
            'video' => 'nullable|url|max:500',
            'solucoes' => 'array',
            'solucoes.*' => 'exists:solucoes,id',
            'icone' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['nome', 'descricao', 'video']);
        $data['slug'] = Str::slug($request->nome);

        // Upload do ícone
        if ($request->hasFile('icone')) {
            // Remove o ícone antigo se existir
            if ($categoria->icone) {
                Storage::disk('public')->delete($categoria->icone);
            }

            $file = $request->file('icone');
            $filename = Str::slug($request->nome) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $data['icone'] = $file->storeAs('categorias/icones', $filename, 'public');
        }

        $categoria->update($data);

        // Atualiza os relacionamentos many-to-many
        $categoria->solucoes()->sync($request->input('solucoes', []));

        return redirect()->route('categorias.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Categoria atualizada com sucesso!'
            ]);
    }


    public function destroy(Categoria $categoria)
    {
        // Remove o ícone se existir
        if ($categoria->icone) {
            Storage::disk('public')->delete($categoria->icone);
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
