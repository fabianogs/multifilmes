@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detalhes da Categoria</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle me-1"></i>
                    Informações da Categoria
                </div>
                <div>
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary btn-sm">
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
                            <td>{{ $categoria->id }}</td>
                        </tr>
                        <tr>
                            <th>Nome:</th>
                            <td>{{ $categoria->nome }}</td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td>{{ $categoria->slug }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $categoria->ativo ? 'success' : 'danger' }}">
                                    {{ $categoria->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Imagem</h5>
                    @if($categoria->imagem)
                        <img src="{{ asset('storage/' . $categoria->imagem) }}" alt="Imagem da categoria" class="img-fluid">
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
                            {!! nl2br(e($categoria->descricao)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 