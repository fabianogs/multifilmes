<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;



class PostController extends Controller
{
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {
        $request->merge([
            'ativo' => $request->has('ativo'),
            'exibir_franqueado' => $request->has('exibir_franqueado'),
        ]);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'chamada_curta' => 'nullable|string|max:255',
            'conteudo' => 'required|string',
            'imagem_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=1030,min_height=600',
            'link_video' => 'nullable|url',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'galeria.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=1030,min_height=600',
            'ativo' => 'boolean',
            'exibir_franqueado' => 'boolean'
        ]);

        if (!$request->hasFile('imagem_principal') && empty($request->link_video)) {
            return redirect()->back()->withInput()->with('toastr', [
                'type' => 'error',
                'message' => 'É necessário informar uma Imagem Principal ou um Link de Vídeo',
                'title' => 'Erro de validação'
            ]);
        }

        try {
            $post = new Post();
            $post->titulo = $validated['titulo'];
            $post->chamada_curta = $validated['chamada_curta'] ?? null;
            $post->conteudo = $validated['conteudo'];
            $post->link_video = $validated['link_video'] ?? null;
            $post->ativo = $request->has('ativo') ? 1 : 0;
            $post->exibir_franqueado = $request->has('exibir_franqueado') ? 1 : 0;
            $post->slug = Str::slug($validated['titulo']);

            $post->save();
            $dirBase = 'posts/' . $post->id;

            // Imagem principal
            if ($request->hasFile('imagem_principal')) {
                $file = $request->file('imagem_principal');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $post->imagem_principal = $file->storeAs($dirBase, $filename, 'public');
            }

            // Thumbnail
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_thumbnail_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $post->thumbnail = $file->storeAs($dirBase, $filename, 'public');

                // Criando a thumbnail
                $thumbnailPath = $this->createThumbnail(
                    $file,
                    $dirBase,
                    $filename
                );
            }

            $post->save();


            // Galeria
            if ($request->hasFile('galeria')) {
                foreach ($request->file('galeria') as $index => $file) {
                    if (in_array($index, $request->input('imagens_indices', []))) {
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = $file->getClientOriginalExtension();
                        $random = Str::random(10);
                        $filename = $originalName . '_' . $random . '.' . $extension;
                        $thumbName = $originalName . '_thumb_' . $random . '.' . $extension;

                        $path = $file->storeAs($dirBase.'/galeria', $filename, 'public');

                        // Criando a thumbnail para cada imagem da galeria
                        $thumbnailPath = $this->createThumbnail(
                            $file,
                            $dirBase . '/galeria/thumbs',
                            $thumbName
                        );

                        // Salvando as imagens na galeria com o modelo Imagem
                        Imagem::create([
                            'post_id' => $post->id,   // Associando a imagem ao post
                            'caminho' => $path,
                            'nome_arquivo' => $filename,
                            'thumbnail' => $thumbnailPath,
                            'ativo' => true,  // ou o valor que desejar
                        ]);
                    }
                }
            }

            return redirect()->route('posts.index')->with('toastr', [
                'type' => 'success',
                'message' => 'Post criado com sucesso!',
                'title' => 'Sucesso'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return back()->withInput()->with('toastr', [
                    'type' => 'error',
                    'message' => 'Já existe um post com esse título. Por favor, escolha outro.',
                    'title' => 'Erro ao criar post'
                ]);
            }

            return back()->withInput()->with('toastr', [
                'type' => 'error',
                'message' => 'Erro inesperado ao salvar o post.',
                'title' => 'Erro'
            ]);
        }
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::with('imagens')->findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validação dos campos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'chamada_curta' => 'nullable|string|max:255',
            'conteudo' => 'required|string',
            'imagem_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=1030,min_height=600',
            'link_video' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'galeria.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=1030,min_height=600',
            'ativo' => 'boolean',
            'exibir_franqueado' => 'boolean'
        ]);

        $post = Post::findOrFail($id);

        // Verificar se pelo menos imagem_principal ou link_video foi fornecido
        if (!$request->hasFile('imagem_principal') && empty($request->link_video) && empty($post->imagem_principal) && empty($post->link_video)) {
            return redirect()->back()
                ->withInput()
                ->with('toastr', [
                    'type' => 'error',
                    'message' => 'É necessário informar uma Imagem Principal ou um Link de Vídeo',
                    'title' => 'Erro de validação'
                ]);
        }

        // Atualizar dados do post
        $post->titulo = $validated['titulo'];
        $post->chamada_curta = $validated['chamada_curta'] ?? null;
        $post->conteudo = $validated['conteudo'];
        $post->link_video = $validated['link_video'] ?? $post->link_video;
        $post->ativo = $request->has('ativo') ? 1 : 0;
        $post->exibir_franqueado = $request->has('exibir_franqueado') ? 1 : 0;
        $post->slug = Str::slug($validated['titulo']);
        $post->save();

        $dirBase = 'posts/' . $post->id;

        // Processar a imagem principal
        if ($request->hasFile('imagem_principal')) {
            // Excluir a imagem anterior, se existir
            if ($post->imagem_principal) {
                Storage::disk('public')->delete($post->imagem_principal);
            }

            $file = $request->file('imagem_principal');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = Str::random(10);
            $filename = $originalName . '_' . $random . '.' . $extension;
            
            $path = $file->storeAs($dirBase, $filename, 'public');
            $post->imagem_principal = $path;
        }

        // Processar o thumbnail
        if ($request->hasFile('thumbnail')) {
            // Excluir o thumbnail anterior, se existir
            if ($post->thumb) {
                Storage::disk('public')->delete($post->thumb);
            }

            $file = $request->file('thumbnail');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = Str::random(10);
            $filename = $originalName . 'thumbnail' . $random . '.' . $extension;
            
            $path = $file->storeAs($dirBase, $filename, 'public');
            $post->thumb = $path;
        }

        // Salvar o post
        $post->save();

        // Processar as imagens excluídas da galeria
        if ($request->has('remove_imagens')) {
            foreach ($request->input('remove_imagens') as $imagemId) {
                $imagem = Imagem::find($imagemId);
                if ($imagem && $imagem->post_id == $post->id) {
                    // Excluir os arquivos físicos
                    Storage::disk('public')->delete($imagem->caminho);
                    Storage::disk('public')->delete($imagem->thumbnail);
                    
                    // Excluir o registro
                    $imagem->delete();
                }
            }
        }

        // Processar as novas imagens da galeria
        if ($request->hasFile('galeria')) {
            foreach ($request->file('galeria') as $index => $file) {
                if (in_array($index, $request->input('imagens_indices', []))) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $random = Str::random(10);
                    $filename = $originalName . '_' . $random . '.' . $extension;
                    $thumbnailFilename = $originalName . '_thumb_' . $random . '.' . $extension;
                    
                    // Salvar a imagem original
                    $path = $file->storeAs($dirBase.'/galeria', $filename, 'public');
                    
                    // Criar e salvar o thumbnail
                    $thumbnailPath = $this->createThumbnail($file, $dirBase.'/galeria/thumbs', $thumbnailFilename);
                    
                    // Criar registro na tabela de imagens
                    $imagemPost = new Imagem();
                    $imagemPost->post_id = $post->id;
                    $imagemPost->caminho = $path;
                    $imagemPost->nome_arquivo = $filename;
                    $imagemPost->thumbnail = $thumbnailPath;
                    $imagemPost->save();
                }
            }
        }

        return redirect()->route('posts.index')
            ->with('toastr', [
                'type' => 'success',
                'message' => 'Post atualizado com sucesso!',
                'title' => 'Sucesso'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Excluir a imagem principal, se existir
        if ($post->imagem_principal) {
            Storage::disk('public')->delete($post->imagem_principal);
        }

        // Excluir o thumbnail, se existir
        if ($post->thumb) {
            Storage::disk('public')->delete($post->thumb);
        }

        // Excluir as imagens da galeria
        foreach ($post->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminho);
            Storage::disk('public')->delete($imagem->thumbnail);
            $imagem->delete();
        }
        try {
            $post->delete();

            // Verifica se a requisição espera JSON (fetch ou AJAX)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'toastr' => [
                        'type' => 'success',
                        'title' => 'Sucesso',
                        'message' => 'Post deletado com sucesso.'
                    ]
                ]);
            }

            return redirect()->route('posts.index')->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso',
                'message' => 'Post deletado com sucesso.'
            ]);
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao deletar o post.'
                ], 500);
            }

            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'title' => 'Erro',
                'message' => 'Erro ao deletar o post.'
            ]);
        }
    }


    /**
     * Upload de imagem para o editor Summernote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $random = Str::random(10);
            $filename = $originalName . '_' . $random . '.' . $extension;
            
            $path = $file->storeAs('img/posts/editor', $filename, 'public');
            
            return asset('storage/' . $path);
        }
        
        return response()->json(['error' => 'Nenhum arquivo enviado'], 400);
    }

    private function createThumbnail($file, $path, $filename)
    {
        // Usando a facade para criar a instância da imagem
        $img = Image::make($file);
        
        // Definindo a largura desejada e calculando a altura proporcional
        $width = 300;
        $height = intval($img->height() * ($width / $img->width()));
        
        // Redimensionando a imagem
        $img->resize($width, $height);
    
        // Definindo o caminho completo para salvar a thumbnail
        $thumbnailPath = $path . '/' . $filename;
        $fullPath = storage_path('app/public/' . $thumbnailPath);
    
        // Verificando se o diretório existe, caso contrário, criando o diretório
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
    
        // Salvando a imagem redimensionada no diretório
        $img->save($fullPath);
    
        return $thumbnailPath;
    }

    public function set_ativo(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->ativo = $request->input('ativo') ? 1 : 0;
        $post->save();
    
        return response()->json(['success' => true, 'message' => 'Status atualizado com sucesso.']);
    }    
    
    
}        