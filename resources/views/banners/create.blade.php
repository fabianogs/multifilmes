@extends('adminlte::page')

@section('title', 'Banners')

@section('content')
    <br>
        <div class="card card-primary card-outline">
            <div class="card-header">
                Novo banner
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
                <form action="{{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="titulo">Título (*)</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required value="{{old('titulo')}}">
                    </div>
                    <div class="form-group">
                        <label for="subtitulo">Subtítulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" class="form-control" required value="{{old('subtitulo')}}">
                    </div>       
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" name="link" id="link" class="form-control" required value="{{old('link')}}">
                    </div>                      
                    <div class="form-group">
                        <label for="ativo">Ativo?</label>
                        <select name="ativo" id="ativo" class="form-control">
                            <option value="1" {{ old('ativo') == 1 ? 'selected' : '' }}>Sim</option>
                            <option value="0" {{ old('ativo') == 0 ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>    
                    <div class="form-group">
                        <label for="imagem">Imagem (1920x980 px)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="imagem" id="imagem" class="custom-file-input" onchange="previewImage(this)">
                                <label class="custom-file-label" for="imagem">Escolha a imagem</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <img id="imagePreview" src="#" alt="Preview da imagem" style="max-width: 200px; display: none;">
                        </div>
                    </div>     
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                        <a href="{{route('banners.index')}}" class="btn btn-sm btn-secondary">Voltar</a>
                    </div>

                </form>
            </div>
        </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .foto-preview {
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
    <script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
        // Script para pré-visualizar a foto selecionada
        document.getElementById('exampleInputFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('fotoPreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        $(document).ready(function() {
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @elseif (session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        });

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
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
@stop