@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detalhes do Produto</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle me-1"></i>
                    Informações do Produto
                </div>
                <div>
                    <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('produtos.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informações Básicas</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $produto->id }}</td>
                        </tr>
                        <tr>
                            <th>Nome:</th>
                            <td>{{ $produto->nome }}</td>
                        </tr>
                        <tr>
                            <th>Marca:</th>
                            <td>{{ $produto->marca->nome }}</td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td>{{ $produto->slug }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $produto->ativo ? 'success' : 'danger' }}">
                                    {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Imagem</h5>
                    @if($produto->imagem)
                        <img src="{{ asset('storage/' . $produto->imagem) }}" alt="Imagem do produto" class="img-fluid">
                    @else
                        <p class="text-muted">Nenhuma imagem cadastrada</p>
                    @endif
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5>Descrição</h5>
                    <div class="card">
                        <div class="card-body">
                            {!! nl2br(e($produto->descricao)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 