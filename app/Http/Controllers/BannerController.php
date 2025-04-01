<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'ativo' => 'boolean'
        ]);

        $banner = new Banner();
        $banner->titulo = $validated['titulo'];
        $banner->subtitulo = $validated['subtitulo'];
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image = $imagePath;
        }

        $banner->ativo = $request->input('ativo', 0);
        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
    }

    public function set_ativo($id, Request $request){
        $item = Banner::findOrFail($id);
        $item->ativo = $request->input('ativo', 0); // Define como 0 se não enviado
        $item->save();
    
        // Log::info($plano->ativo ? 'Plano ativado' : 'Plano desativado', [
        //     'usuario' => auth()->user()->name,
        //     'editado' => $plano->nome,
        // ]);
    
        return response()->json([
            'success' => true,
            'ativo' => $item->ativo
        ]);
    }    
}
