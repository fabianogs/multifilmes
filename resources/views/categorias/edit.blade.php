@extends('adminlte::page')

@section('title', 'Editar Categoria')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Editar Categoria</h3>
                </div>
                <form action="{{ route('categorias.update', $categoria) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $categoria->nome) }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3" >{{ old('descricao', $categoria->descricao) }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="video">URL do Vídeo</label>
                            <input type="url" class="form-control @error('video') is-invalid @enderror" id="video" name="video" value="{{ old('video', $categoria->video) }}" placeholder="https://www.youtube.com/watch?v=...">
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="imagem">Imagem (520x300 px)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="imagem" id="imagem" class="custom-file-input" onchange="previewImagem(this)">
                                    <label class="custom-file-label" for="imagem">Escolha uma imagem</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                @if($categoria->imagem)
                                    <img id="imagemPreview" src="{{ asset('storage/' . $categoria->imagem) }}" alt="Preview" style="max-width: 200px;">
                                @else
                                    <img id="imagemPreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                @endif
                            </div>
                            @error('imagem')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="icone">Ícone (30x20 px)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="icone" id="icone" class="custom-file-input" onchange="previewImage(this)">
                                    <label class="custom-file-label" for="icone">Escolha um ícone</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                @if($categoria->icone)
                                    <img id="imagePreview" src="{{ asset('storage/' . $categoria->icone) }}" alt="Preview" style="max-width: 200px;">
                                @else
                                    <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                @endif
                            </div>
                            @error('icone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Soluções</label>
                            <div class="form-check">
                                @foreach($solucoes as $solucao)
                                    <div class="mb-1">
                                        <input class="form-check-input" type="checkbox" 
                                            name="solucoes[]" 
                                            value="{{ $solucao->id }}"
                                            id="solucao_{{ $solucao->id }}"
                                            {{ in_array($solucao->id, old('solucoes', $categoria->solucoes->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="solucao_{{ $solucao->id }}">
                                            {{ $solucao->titulo }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('solucoes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('categorias.index') }}" class="btn btn-default">Cancelar</a>
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
            object-fit: cover;
            margin-top: 10px;
            border-radius: 8px;
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

        function previewImagem(input) {
            const preview = document.getElementById('imagemPreview');
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

        // Atualiza o nome do arquivo no input file
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });

        @if(session('toastr'))
            toastr.{{ session('toastr.type') }}('{{ session('toastr.message') }}', '{{ session('toastr.title') }}', {
                timeOut: 1000,
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right"
            });
        @endif
    </script>
@stop 