<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::with('categoria')->get();
        return view('marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('marcas.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $validated['slug'] = Str::slug($request->nome);

        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = uniqid();
            $filename = $originalName.'_'.$random.'.'.$extension;
            
            $path = $file->storeAs('marcas', $filename, 'public');
            $validated['imagem'] = $path;
        }

        Marca::create($validated);

        return redirect()->route('marcas.index')->with('success', 'Marca criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        return view('marcas.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        $categorias = Categoria::all();
        return view('marcas.edit', compact('marca', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $marca)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $validated['slug'] = Str::slug($request->nome);

        if ($request->hasFile('imagem')) {
            // Remove a imagem antiga se existir
            if ($marca->imagem && Storage::exists('public/' . $marca->imagem)) {
                Storage::delete('public/' . $marca->imagem);
            }

            $file = $request->file('imagem');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = uniqid();
            $filename = $originalName.'_'.$random.'.'.$extension;
            
            $path = $file->storeAs('marcas', $filename, 'public');
            $validated['imagem'] = $path;
        }

        $marca->update($validated);

        return redirect()->route('marcas.index')->with('success', 'Marca atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        if ($marca->imagem && Storage::exists('public/' . $marca->imagem)) {
            Storage::delete('public/' . $marca->imagem);
        }
        
        $marca->delete();
        return response()->json(['success' => true]);
    }
}
