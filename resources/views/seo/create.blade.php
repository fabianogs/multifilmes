@extends('adminlte::page')

@section('title', 'SEO')

@section('content')
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                Criar SEO
            </div>
            <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('seo.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="unidade_id" value="{{ $unidade_id }}">
                <div class="form-group">
                    <label for="nome">Nome (*)</label>
                    <input type="text" name="nome" id="nome" class="form-control" required value="{{ old('nome') }}">
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo (*)</label>
                    <select name="tipo" id="tipo" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="head" {{ old('tipo') == 'head' ? 'selected' : '' }}>Head</option>
                        <option value="body" {{ old('tipo') == 'body' ? 'selected' : '' }}>Body</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="script">Script</label>
                    <textarea name="script" id="script" class="form-control" rows="5">{{ old('script') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status (*)</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    <a href="{{ route('seo.index') }}" class="btn btn-sm btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @elseif (session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        });
    </script>
@stop
