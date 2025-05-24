@extends('adminlte::page')

@section('title', 'Editar Banner')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    Editar Banner
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
                <form action="{{ route('banners.update', $banner->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="titulo">Título (*)</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required value="{{ old('titulo', $banner->titulo) }}">
                    </div>
                    <div class="form-group">
                        <label for="subtitulo">Subtítulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" class="form-control" required value="{{ old('subtitulo', $banner->subtitulo) }}">
                    </div>       
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" name="link" id="link" class="form-control" required value="{{ old('link', $banner->link) }}">
                    </div>                      
                    <div class="form-group">
                        <label for="ativo">Ativo?</label>
                        <select name="ativo" id="ativo" class="form-control">
                            <option value="1" {{ old('ativo', $banner->ativo) == 1 ? 'selected' : '' }}>Sim</option>
                            <option value="0" {{ old('ativo', $banner->ativo) == 0 ? 'selected' : '' }}>Não</option>
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
                            @if($banner->imagem)
                                <img id="currentImage" src="{{ asset('storage/' . $banner->imagem) }}" alt="Imagem atual" style="max-width: 200px;">
                            @endif
                            <img id="imagePreview" src="#" alt="Preview da nova imagem" style="max-width: 200px; display: none;">
                        </div>
                    </div>     
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                        <a href="{{route('banners.index')}}" class="btn btn-sm btn-secondary">Voltar</a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteBanner({{ $banner->id }})">
                            <i class="fas fa-trash"></i> Apagar Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @elseif (session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        });

        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const currentImage = document.getElementById('currentImage');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                if (currentImage) {
                    currentImage.style.display = 'block';
                }
            }
        }

        function deleteBanner(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não pode ser desfeita! O banner será permanentemente excluído.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, apagar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/area_restrita/banners/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Apagado!',
                                    'O banner foi removido com sucesso.',
                                    'success'
                                ).then(() => {
                                    window.location.href = "{{ route('banners.index') }}";
                                });
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao tentar apagar o banner.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@stop
