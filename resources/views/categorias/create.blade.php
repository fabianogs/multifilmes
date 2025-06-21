@extends('adminlte::page')

@section('title', 'Nova Categoria')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Nova Categoria</h3>
                </div>
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                            @error('nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="video">URL do Vídeo</label>
                            <input type="url" class="form-control @error('video') is-invalid @enderror" id="video" name="video" value="{{ old('video') }}" placeholder="https://www.youtube.com/watch?v=...">
                            @error('video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="imagem">Ícone (30x20 px)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="icone" id="icone" class="custom-file-input" onchange="previewImage(this)">
                                    <label class="custom-file-label" for="icone">Escolha um ícone</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                            </div>
                        </div>                             

                        <div class="form-group">
                            <label>Soluções</label>
                            <div class="row">
                                @foreach($solucoes as $solucao)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                name="solucoes[]" 
                                                value="{{ $solucao->id }}" 
                                                id="solucao_{{ $solucao->id }}"
                                                {{ is_array(old('solucoes')) && in_array($solucao->id, old('solucoes')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="solucao_{{ $solucao->id }}">
                                                {{ $solucao->titulo }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('solucoes')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .imagePreview{
            display: none;
            width: 50%;
            height: 50%;
            object-fit: cover; /* Mantém a proporção sem distorcer */
            margin-top: 10px;
            border-radius: 8px; /* Borda arredondada opcional */
        }
    </style>       
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
    @if(session('toastr'))
        <script>
            toastr.{{ session('toastr.type') }}('{{ session('toastr.message') }}', '{{ session('toastr.title') }}', {
                timeOut: 1000,
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right"
            });
        </script>
    @endif
@stop
