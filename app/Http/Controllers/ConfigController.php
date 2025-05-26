<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Unidade;
class ConfigController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            // Se for admin, mostra a lista de unidades com suas configurações
            $configs = Config::with('unidade')->get();
            return view('config.index', compact('configs'));
        } else {
            // Se for franqueado, redireciona para a edição da configuração da sua unidade
            $config = Config::where('unidade_id', $user->unidade_id)->first();
            
            if (!$config) {
                // Se não existir configuração para a unidade, cria uma nova
                $config = Config::create([
                    'unidade_id' => $user->unidade_id,
                    'email' => '',
                    'endereco' => '',
                    'cnpj' => '',
                    'expediente' => '',
                    'razao_social' => $user->unidade->nome,
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
            }
            
            return redirect()->route('config.edit', ['id' => $config->id]);
        }
    }
    
    public function edit()
    {
        $user = auth()->user();
        $unidade = Unidade::find($user->unidade_id);
        
        if ($user->role === 'admin') {
            $config = Config::findOrFail(1);
        } else {
            // Se for franqueado, busca a configuração da unidade dele
            // Buscar o nome da cidade da unidade
            $config = Config::where('unidade_id', $user->unidade_id)->first();
            
            if (!$config) {
                // Se não existir configuração para a unidade, cria uma nova
                $config = Config::create([
                    'unidade_id' => $user->unidade_id,
                    'email' => '',
                    'endereco' => '',
                    'cnpj' => '',
                    'expediente' => '',
                    'razao_social' => $user->unidade->nome,
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
            }
        }
        return view("config.edit", compact("config", "unidade"  ));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $config = Config::findOrFail($id);
        
        // Verifica se o usuário tem permissão para editar esta configuração
        if ($user->role === 'franqueado' && $config->unidade_id !== $user->unidade_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Você não tem permissão para editar esta configuração.');
        }

        if ($request->texto_contrato) {
            $config->texto_contrato = $request->texto_contrato;
        } else {
            $config->celular = $request->celular;
            $config->whatsapp = $request->whatsapp;
            $config->fone1 = $request->fone1;
            $config->fone2 = $request->fone2;
            $config->facebook = $request->facebook;
            $config->instagram = $request->instagram;
            $config->email = $request->email;
            $config->twitter = $request->twitter;
            $config->endereco = $request->endereco;
            $config->maps = $request->maps;
            $config->youtube = $request->youtube;
            $config->linkedin = $request->linkedin;
            $config->form_email_to = $request->form_email_to;
            $config->email_port = $request->email_port;
            $config->email_username = $request->email_username;
            $config->email_password = $request->email_password;
            $config->email_host = $request->email_host;
            $config->cnpj = $request->cnpj;
        }

        try {
            $config->save();
            Log::info('Dados de configuração editados.', [
                'usuario' => auth()->user()->name,
                'config' => $config->razao_social,
            ]);

            return redirect()->route('config')->with('success', 'Configuração atualizada com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao editar configuração: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao atualizar configuração.');
        }
    }

    public function edit_lgpd()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $config = Config::findOrFail(1);
        } else {
            $config = Config::where('unidade_id', $user->unidade_id)->first();
        }
        
        if (request()->is('area_restrita*')) {
            return view("admin.lgpd.edit", compact("config"));
        }
        return response()->json(['config' => $config]);
    }

    public function edit_contrato()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $config = Config::findOrFail(1);
        } else {
            $config = Config::where('unidade_id', $user->unidade_id)->first();
        }
        
        return view("admin.config.edit_contrato", compact("config"));
    }

    public function show()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $config = Config::findOrFail(1);
        } else {
            $config = Config::where('unidade_id', $user->unidade_id)->first();
        }
        
        return response()->json(['config' => $config->makeHidden('texto_contrato')]);
    }
}