@extends('adminlte::page')

@section('title', 'Dashboard')

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
                <form action="{{ route('banners.store') }}" method="post">
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
                        <label for="ativo">Ativo?</label>
                        <select name="ativo" id="ativo" class="form-control">
                            <option value="1" {{ old('ativo') == 1 ? 'selected' : '' }}>Sim</option>
                            <option value="0" {{ old('ativo') == 0 ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>    
                    <div class="form-group">
                        <label for="midia_id">Imagem (1920x980 px)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="midia_id" id="exampleInputFile" class="custom-file-input" >
                                <label for="exampleInputFile" class="custom-file-label">Escolha</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Enviar</span>
                            </div>
                        </div>
                    </div>     
                    <div class="form-group">
                        <img id="fotoPreview" src="#" alt="Pré-visualização da foto" class="foto-preview">
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
    </script>
@stop