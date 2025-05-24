<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif',
            'link'=> 'required|string',
            'ativo' => 'boolean'
        ]);

        $banner = new Banner();
        $banner->titulo = $validated['titulo'];
        $banner->subtitulo = $validated['subtitulo'];
        $banner->link = $validated['link'];
        
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');

            $originalName   = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension      = $file->getClientOriginalExtension();
            $random         = uniqid();
            $filename = $originalName.'_'.$random.'.'.$extension;
            
            $path = $file->storeAs('img/banners',$filename, 'public');
            $banner->imagem = $path;
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
    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'link'=> 'required|string',
        ]);

        $banner->titulo = $validated['titulo'];
        $banner->subtitulo = $validated['subtitulo'];
        $banner->link = $validated['link'];
        
        if ($request->hasFile('imagem')) {
            // Remove a imagem antiga se existir
            if ($banner->imagem && Storage::exists('public/' . $banner->imagem)) {
                Storage::delete('public/' . $banner->imagem);
            }

            $file = $request->file('imagem');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = uniqid();
            $filename = $originalName.'_'.$random.'.'.$extension;
            
            $path = $file->storeAs('banners', $filename, 'public');
            $banner->imagem = $path;
        }

        $banner->ativo = $request->input('ativo', 0);
        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);

        if ($banner->imagem && Storage::exists('public/' . $banner->imagem)) {
            Storage::delete('public/' . $banner->imagem);
        }
        
        $banner->delete();
        
        return response()->json(['success' => true]);
    }

    public function deleteImage($id)
    {
        $banner = Banner::findOrFail($id);
        
        if ($banner->imagem && Storage::exists('public/' . $banner->imagem)) {
            Storage::delete('public/' . $banner->imagem);
            $banner->imagem = null;
            $banner->save();
        }

        return response()->json(['success' => true]);
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
