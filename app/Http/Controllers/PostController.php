<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('posts.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'ativo' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->titulo);
        $data['ativo'] = $request->has('ativo');

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('posts', 'public');
        }

        $post = Post::create($data);

        return redirect()->route('posts.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Post criado com sucesso!'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categorias = Categoria::all();
        return view('posts.edit', compact('post', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'ativo' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->titulo);
        $data['ativo'] = $request->has('ativo');

        if ($request->hasFile('imagem')) {
            if ($post->imagem) {
                Storage::disk('public')->delete($post->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Post atualizado com sucesso!'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->imagem) {
            Storage::disk('public')->delete($post->imagem);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'toastr' => [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Post excluído com sucesso!'
            ]
        ]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('posts/editor', 'public');
            return response()->json([
                'location' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'Nenhum arquivo enviado'], 400);
    }
}
