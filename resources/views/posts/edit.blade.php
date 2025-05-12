@extends('adminlte::page')

@section('title', 'Editar Post')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Editar Post</h3>
                </div>
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="postForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo', $post->titulo) }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="chamada_curta">Chamada Curta</label>
                            <input type="text" class="form-control @error('chamada_curta') is-invalid @enderror" id="chamada_curta" name="chamada_curta" value="{{ old('chamada_curta', $post->chamada_curta) }}">
                            @error('chamada_curta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="conteudo">Conteúdo</label>
                            <textarea class="form-control @error('conteudo') is-invalid @enderror" id="conteudo" name="conteudo">{{ old('conteudo', $post->conteudo) }}</textarea>
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
                                    @if($post->imagem_principal)
                                        <div class="preview-box mb-3" id="imagem-principal-atual">
                                            <img src="{{ asset('storage/' . $post->imagem_principal) }}" class="preview-principal-image" alt="Imagem Principal">
                                            <div class="preview-dimensions">Imagem atual</div>
                                            <div class="text-right mt-2">
                                                <button type="button" class="btn btn-sm btn-danger" id="btn-remover-imagem-principal">
                                                    <i class="fas fa-trash"></i> Remover imagem
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="remover_imagem_principal" name="remover_imagem_principal" value="0">
                                    @endif
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
                                    <input type="url" class="form-control @error('link_video') is-invalid @enderror" id="link_video" name="link_video" value="{{ old('link_video', $post->link_video) }}" placeholder="https://www.youtube.com/watch?v=...">
                                    @error('link_video')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="thumbnail">Thumbnail (180x120px)</label>
                            @if($post->thumbnail)
                                <div class="preview-box mb-3" id="thumbnail-atual">
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="preview-thumbnail-image" alt="Thumbnail">
                                    <div class="preview-dimensions">Thumbnail atual</div>
                                    <div class="text-right mt-2">
                                        <button type="button" class="btn btn-sm btn-danger" id="btn-remover-thumbnail">
                                            <i class="fas fa-trash"></i> Remover thumbnail
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="remover_thumbnail" name="remover_thumbnail" value="0">
                            @endif
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
                            <small class="form-text text-muted">Você pode selecionar múltiplas imagens para adicionar à galeria</small>
                            @error('galeria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mt-3" id="preview-container">
                            <!-- Aqui serão exibidas as pré-visualizações das novas imagens -->
                        </div>

                        @if($post->imagens && count($post->imagens) > 0)
                            <div class="card mt-3">
                                <div class="card-header bg-light">
                                    <h5>Imagens da Galeria Atual</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="galeria-atual">
                                        @foreach($post->imagens as $index => $imagem)
                                            <div class="col-md-3 preview-image-container">
                                                <img src="{{ asset('storage/' . $imagem->caminho) }}" class="preview-image" alt="Imagem da galeria">
                                                <div class="remove-image-existing" data-id="{{ $imagem->id }}">×</div>
                                                <input type="hidden" name="imagens_existentes[]" value="{{ $imagem->id }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group mt-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="ativo" name="ativo" {{ old('ativo', $post->ativo) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="ativo">Publicar</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="exibir_franqueado" name="exibir_franqueado" {{ old('exibir_franqueado', $post->exibir_franqueado) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="exibir_franqueado">Exibir para Franqueado</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
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
        .remove-image, .remove-image-existing {
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
            // Array para armazenar IDs de imagens a serem removidas
            let imagensParaRemover = [];
            
            // Inicializar editor de texto rico
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

            // Função para upload de imagens no editor
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
                        toastr.error('Falha ao fazer upload da imagem', 'Erro');
                    }
                });
            }

            // Atualiza o nome do arquivo nos inputs de arquivo
            document.querySelectorAll('.custom-file-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    var fileName = '';
                    if (this.files && this.files.length > 1) {
                        fileName = (this.getAttribute('data-multiple-caption') || '{0} arquivos selecionados').replace('{0}', this.files.length);
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

            // Exibir preview das novas imagens da galeria
            function displayImagePreviews(files) {
                const container = document.getElementById('preview-container');
                
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

            // Lidar com remoção de imagens existentes da galeria
            $('.remove-image-existing').on('click', function() {
                const imageId = $(this).data('id');
                const container = $(this).closest('.preview-image-container');
                
                // Adicionar ID da imagem à lista de imagens para remover
                imagensParaRemover.push(imageId);
                
                // Adicionar campo hidden para enviar ID da imagem a ser excluída
                $('#postForm').append(`<input type="hidden" name="remover_imagens[]" value="${imageId}">`);
                
                // Remover o container visual da imagem
                container.fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // Validação para garantir que pelo menos imagem_principal ou link_video esteja preenchido
            $('#postForm').on('submit', function(e) {
                const imagemPrincipal = $('#imagem_principal').val();
                const linkVideo = $('#link_video').val();
                const temImagemPrincipalOriginal = {{ $post->imagem_principal ? 'true' : 'false' }};
                const removerImagemPrincipal = $('#remover_imagem_principal').val() === '1';
                
                // Verifica se:
                // - Não há nova imagem principal selecionada
                // - Não há link de vídeo
                // - E a imagem original foi removida ou não existia
                if ((!imagemPrincipal && !linkVideo) && 
                    (removerImagemPrincipal || !temImagemPrincipalOriginal)) {
                    e.preventDefault();
                    toastr.error('É necessário informar uma Imagem Principal ou um Link de Vídeo', 'Erro de validação', {
                        timeOut: 3000,
                        closeButton: true
                    });
                }
                
                // Preparar o conteúdo do editor
                $('#conteudo').val($('#conteudo').summernote('code'));
            });

            // Exibir mensagens toastr, se existirem
            @if(session('toastr'))
                toastr.{{ session('toastr.type') }}('{{ session('toastr.message') }}', '{{ session('toastr.title') }}', {
                    timeOut: 1000,
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right"
                });
            @endif
            
            // Botões para remover imagens existentes
            $('#btn-remover-imagem-principal').on('click', function() {
                $('#remover_imagem_principal').val('1');
                // Remover completamente o preview da imagem principal
                $('#imagem-principal-atual').remove();
                // Limpar o input de arquivo
                $('#imagem_principal').val('');
                $('label[for="imagem_principal"]').text('Escolher arquivo');
                $('#preview-imagem-principal').empty();
                
                // Verificar se há link de vídeo para alertar caso necessário
                if (!$('#link_video').val()) {
                    toastr.warning('Lembre-se que você precisará informar um Link de Vídeo antes de salvar', 'Atenção', {
                        timeOut: 5000,
                        closeButton: true
                    });
                }
            });

            // Não precisamos mais do botão de restaurar, pois o preview foi removido

            $('#btn-remover-thumbnail').on('click', function() {
                $('#remover_thumbnail').val('1');
                // Remover completamente o preview do thumbnail
                $('#thumbnail-atual').remove();
                // Limpar o input de arquivo
                $('#thumbnail').val('');
                $('label[for="thumbnail"]').text('Escolher arquivo');
                $('#preview-thumbnail').empty();
            });

// Remova também os event listeners para os botões de restaurar, já que não vamos mais usá-los
            
            // Se uma nova imagem principal for selecionada, desativar remover e esconder imagem atual
            $('#imagem_principal').on('change', function() {
                if (this.files && this.files.length > 0) {
                    // Nova imagem substituirá a atual, então vamos esconder a atual
                    $('#remover_imagem_principal').val('0');
                    $('#imagem-principal-atual').addClass('text-muted opacity-50');
                    $('#btn-remover-imagem-principal, #btn-restaurar-imagem-principal').hide();
                }
            });
            
            // Se uma nova thumbnail for selecionada, desativar remover e esconder thumbnail atual
            $('#thumbnail').on('change', function() {
                if (this.files && this.files.length > 0) {
                    // Nova thumbnail substituirá a atual, então vamos esconder a atual
                    $('#remover_thumbnail').val('0');
                    $('#thumbnail-atual').addClass('text-muted opacity-50');
                    $('#btn-remover-thumbnail, #btn-restaurar-thumbnail').hide();
                }
            });
        });
    </script>
@stop