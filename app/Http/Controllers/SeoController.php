<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seos = auth()->user()->role === 'admin' 
            ? Seo::all() 
            : Seo::where('unidade_id', auth()->user()->unidade_id)->get();

        return view('seo.index', compact('seos'));
    }

    public function create()
    {
        $unidade_id = auth()->user()->unidade_id;
        return view('seo.create', compact('unidade_id'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|string|in:head,body',
                'script' => 'required|string',
            ]);

            $seo = new Seo();
            $seo->nome = $request->nome;
            $seo->tipo = $request->tipo;
            $seo->script = $request->script;
            $seo->status = $request->status;
            $seo->unidade_id = auth()->user()->unidade_id;
            $seo->save();

            Log::info('SEO criado com sucesso', [
                'user' => auth()->user()->name,
                'unidade_id' => $seo->unidade_id
            ]);

            return redirect()->route('seo.index')
                ->with('success', 'SEO criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar SEO: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao criar SEO. Por favor, tente novamente.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $seo = Seo::findOrFail($id);
        
        if (!auth()->user()->can('acessar-recurso', $seo)) {
            return redirect()->route('seo.index')
                ->with('error', 'Você não tem permissão para editar este SEO.');
        }

        return view('seo.edit', compact('seo'));
    }

    public function update(Request $request, $id)
    {
        try {
            $seo = Seo::findOrFail($id);
            
            if (!auth()->user()->can('acessar-recurso', $seo)) {
                return redirect()->route('seo.index')
                    ->with('error', 'Você não tem permissão para atualizar este SEO.');
            }

            $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|string|in:head,body',
                'script' => 'required|string',
            ]);

            $seo->nome = $request->nome;
            $seo->tipo = $request->tipo;
            $seo->script = $request->script;
            $seo->status = $request->status;
            $seo->save();

            Log::info('SEO atualizado com sucesso', [
                'user' => auth()->user()->name,
                'unidade_id' => $seo->unidade_id
            ]);

            return redirect()->route('seo.index')
                ->with('success', 'SEO atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar SEO: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao atualizar SEO. Por favor, tente novamente.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $seo = Seo::findOrFail($id);
            
            if (!auth()->user()->can('acessar-recurso', $seo)) {
                return redirect()->route('seo.index')
                    ->with('error', 'Você não tem permissão para excluir este SEO.');
            }

            $seo->delete();

            Log::info('SEO excluído com sucesso', [
                'user' => auth()->user()->name,
                'unidade_id' => $seo->unidade_id
            ]);

            return redirect()->route('seo.index')
                ->with('success', 'SEO excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir SEO: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao excluir SEO. Por favor, tente novamente.');
        }
    }

    public function show($id)
    {
        $seo = Seo::findOrFail($id);
        
        if (!auth()->user()->can('acessar-recurso', $seo)) {
            return redirect()->route('seo.index')
                ->with('error', 'Você não tem permissão para visualizar este SEO.');
        }

        return view('seo.show', compact('seo'));
    }
}