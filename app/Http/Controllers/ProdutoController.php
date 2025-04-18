<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::with('marca')->get();
        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = Marca::all();
        return view('produtos.create', compact('marcas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'marca_id' => 'required|exists:marcas,id',
            'ativo' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($request->nome);
        $validated['ativo'] = $request->has('ativo');

        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = uniqid();
            $filename = $originalName.'_'.$random.'.'.$extension;
            
            $path = $file->storeAs('produtos', $filename, 'public');
            $validated['imagem'] = $path;
        }

        Produto::create($validated);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        $marcas = Marca::all();
        return view('produtos.edit', compact('produto', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'marca_id' => 'required|exists:marcas,id',
            'ativo' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($request->nome);
        $validated['ativo'] = $request->has('ativo');

        if ($request->hasFile('imagem')) {
            // Remove a imagem antiga se existir
            if ($produto->imagem && Storage::exists('public/' . $produto->imagem)) {
                Storage::delete('public/' . $produto->imagem);
            }

            $file = $request->file('imagem');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = uniqid();
            $filename = $originalName.'_'.$random.'.'.$extension;
            
            $path = $file->storeAs('produtos', $filename, 'public');
            $validated['imagem'] = $path;
        }

        $produto->update($validated);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        if ($produto->imagem && Storage::exists('public/' . $produto->imagem)) {
            Storage::delete('public/' . $produto->imagem);
        }
        
        $produto->delete();
        return response()->json(['success' => true]);
    }
}
