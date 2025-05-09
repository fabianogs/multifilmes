@extends('adminlte::page')

@section('title', 'Novo Post')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Novo Post</h3>
                </div>
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="chamada_curta">Chamada Curta</label>
                            <input type="text" class="form-control @error('chamada_curta') is-invalid @enderror" id="chamada_curta" name="chamada_curta" value="{{ old('chamada_curta') }}">
                            @error('chamada_curta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="conteudo">Conteúdo</label>
                            <textarea class="form-control @error('conteudo') is-invalid @enderror" id="conteudo" name="conteudo">{{ old('conteudo') }}</textarea>
                            @error('conteudo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card">
                            <div class="card-header bg-light">
                                <h5>Mídia Principal</h5>
                                <small class="text-muted">É necessário informar ao menos um dos campos: Imagem Principal ou Link de Vídeo</small>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="imagem_principal">Imagem Principal (1030x600px)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('imagem_principal') is-invalid @enderror" id="imagem_principal" name="imagem_principal" accept="image/*">
                                        <label class="custom-file-label" for="imagem_principal">Escolher arquivo</label>
                                    </div>
                                    <div class="mt-2" id="preview-imagem-principal"></div>
                                    @error('imagem_principal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="link_video">Link do Vídeo</label>
                                    <input type="url" class="form-control @error('link_video') is-invalid @enderror" id="link_video" name="link_video" value="{{ old('link_video') }}" placeholder="https://www.youtube.com/watch?v=...">
                                    @error('link_video')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="thumbnail">Thumbnail (180x120px)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                                <label class="custom-file-label" for="thumbnail">Escolher arquivo</label>
                            </div>
                            <div class="mt-2" id="preview-thumbnail"></div>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <label for="galeria">Galeria de Imagens (1030x600px)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('galeria') is-invalid @enderror" id="galeria" name="galeria[]" accept="image/*" multiple>
                                <label class="custom-file-label" for="galeria">Escolher arquivos</label>
                            </div>
                            <small class="form-text text-muted">Você pode selecionar múltiplas imagens</small>
                            @error('galeria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mt-3" id="preview-container">
                            <!-- Aqui serão exibidas as pré-visualizações das imagens -->
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="ativo" name="ativo" {{ old('ativo') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="ativo">Publicar</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="exibir_franqueado" name="exibir_franqueado" {{ old('exibir_franqueado') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="exibir_franqueado">Exibir para Franqueado</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .preview-image-container {
            position: relative;
            margin-bottom: 15px;
        }
        .preview-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }
        .remove-image {
            position: absolute;
            top: 5px;
            right: 20px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            cursor: pointer;
        }
        .preview-box {
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .preview-principal-image {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin: 0 auto;
            border-radius: 4px;
        }
        .preview-thumbnail-image {
            max-width: 100%;
            max-height: 150px;
            display: block;
            margin: 0 auto;
            border-radius: 4px;
        }
        .preview-dimensions {
            text-align: center;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-pt-BR.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#conteudo').summernote({
                height: 300,
                lang: 'pt-BR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for(let i=0; i < files.length; i++) {
                            uploadImage(files[i], this);
                        }
                    }
                }
            });

            function uploadImage(file, editor) {
                let formData = new FormData();
                formData.append('file', file);

                $.ajax({
                    url: '{{ route("posts.upload") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(url) {
                        $(editor).summernote('insertImage', url);
                    },
                    error: function(data) {
                        console.error('Erro ao fazer upload da imagem:', data);
                    }
                });
            }

            // Atualiza o nome do arquivo nos inputs de arquivo
            document.querySelectorAll('.custom-file-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    var fileName = '';
                    if (this.files && this.files.length > 1) {
                        fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                    } else if (this.files && this.files.length === 1) {
                        fileName = e.target.files[0].name;
                    }
                    
                    var nextSibling = e.target.nextElementSibling;
                    nextSibling.innerText = fileName;
                    
                    // Exibir previews com base no ID do input
                    if (this.id === 'galeria' && this.files) {
                        displayImagePreviews(this.files);
                    } else if (this.id === 'imagem_principal' && this.files && this.files[0]) {
                        displaySingleImagePreview(this.files[0], 'preview-imagem-principal', 'preview-principal-image');
                    } else if (this.id === 'thumbnail' && this.files && this.files[0]) {
                        displaySingleImagePreview(this.files[0], 'preview-thumbnail', 'preview-thumbnail-image');
                    }
                });
            });

            // Exibir preview das imagens da galeria
            function displayImagePreviews(files) {
                const container = document.getElementById('preview-container');
                container.innerHTML = '';
                
                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 preview-image-container';
                        col.innerHTML = `
                            <img src="${e.target.result}" class="preview-image" alt="Preview">
                            <div class="remove-image" data-index="${index}">×</div>
                            <input type="hidden" name="imagens_indices[]" value="${index}">
                        `;
                        container.appendChild(col);
                        
                        // Adicionar evento para remover imagem
                        col.querySelector('.remove-image').addEventListener('click', function() {
                            col.remove();
                        });
                    }
                    reader.readAsDataURL(file);
                });
            }
            
            // Exibir preview de uma única imagem com dimensões
            function displaySingleImagePreview(file, containerId, imageClass) {
                const container = document.getElementById(containerId);
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Criar elemento de imagem para obter dimensões
                    const img = new Image();
                    img.src = e.target.result;
                    
                    img.onload = function() {
                        const width = this.width;
                        const height = this.height;
                        
                        // Criar preview com informações
                        container.innerHTML = `
                            <div class="preview-box">
                                <img src="${e.target.result}" class="${imageClass}" alt="Preview">
                                <div class="preview-dimensions">
                                    Dimensões originais: ${width}x${height}px
                                </div>
                            </div>
                        `;
                    };
                }
                
                reader.readAsDataURL(file);
            }

            // Validação para garantir que pelo menos imagem_principal ou link_video esteja preenchido
            $('#postForm').on('submit', function(e) {
                const imagemPrincipal = $('#imagem_principal').val();
                const linkVideo = $('#link_video').val();
                
                if (!imagemPrincipal && !linkVideo) {
                    e.preventDefault();
                    toastr.error('É necessário informar uma Imagem Principal ou um Link de Vídeo', 'Erro de validação', {
                        timeOut: 3000,
                        closeButton: true
                    });
                }
            });
        });

        @if(session('toastr'))
            toastr.{{ session('toastr.type') }}('{{ session('toastr.message') }}', '{{ session('toastr.title') }}', {
                timeOut: 1000,
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right"
            });
        @endif

        $('#postForm').on('submit', function(e) {
            $('#conteudo').val($('#conteudo').summernote('code'));

            const imagemPrincipal = $('#imagem_principal').val();
            const linkVideo = $('#link_video').val();

            if (!imagemPrincipal && !linkVideo) {
                e.preventDefault();
                toastr.error('É necessário informar uma Imagem Principal ou um Link de Vídeo', 'Erro de validação', {
                    timeOut: 3000,
                    closeButton: true
                });
            }
        });


    </script>
@stop