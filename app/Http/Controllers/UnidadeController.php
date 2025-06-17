<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Config;
use App\Models\Seo;

class UnidadeController extends Controller
{
    public function index()
    {
        $unidades = Unidade::all();
        return view('unidades.index', compact('unidades'));
    }

    public function create()
    {
        return view('unidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
        ]);

        try {

            $unidade = Unidade::create($request->all());

            // Criar configuração para a nova unidade
            Config::create([
                'unidade_id' => $unidade->id,
                'email' => '',
                'endereco' => '',
                'cnpj' => '',
                'expediente' => '',
                'razao_social' => $unidade->nome,
                'whatsapp' => '',
                'facebook' => '',
                'instagram' => '',
                'twitter' => '',
                'youtube' => '',
                'linkedin' => '',
                'maps' => '',
                'arquivo_lgpd' => '',
                'texto_lgpd' => '',
                'form_email_to' => '',
                'email_port' => '',
                'email_username' => '',
                'email_password' => '',
                'email_host' => '',
                'celular' => '',
                'fone1' => '',
                'fone2' => ''
            ]);

            Log::info('Nova unidade criada.', [
                'usuario' => auth()->user()->name,
                'unidade' => $unidade->nome,
            ]);

            return redirect()->route('unidades.index')
                ->with('success', 'Unidade criada com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao criar unidade: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao criar unidade.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $unidade = Unidade::findOrFail($id);
        return view('unidades.edit', compact('unidade'));
    }

    public function update(Request $request, $id)
    {
        $unidade = Unidade::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'cidade' => 'required|string|max:255',
            'url' => 'nullable|url|max:255'
        ]);

        $unidade->update($request->all());

        return redirect()->route('unidades.index')
            ->with('toastr', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Unidade atualizada com sucesso!'
            ]);
    }

    public function destroy($id)
    {
        try {

            $unidade = Unidade::findOrFail($id);
            
            // Remover configuração e SEO da unidade
            Config::where('unidade_id', $unidade->id)->delete();
            Seo::where('unidade_id', $unidade->id)->delete();
            
            $unidade->delete();

            Log::info('Unidade excluída.', [
                'usuario' => auth()->user()->name,
                'unidade' => $unidade->nome,
            ]);

            return redirect()->route('unidades.index')
                ->with('success', 'Unidade excluída com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir unidade: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao excluir unidade.');
        }
    }
}
