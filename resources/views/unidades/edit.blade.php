@extends('adminlte::page')

@section('title', 'Editar Unidade')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Editar Unidade</h3>
                </div>
                <form action="{{ route('unidades.update', $unidade) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $unidade->nome) }}" required>
                            @error('nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="uf">Estado</label>
                            <select class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf" required>
                                <option value="">Selecione um estado</option>
                            </select>
                            @error('uf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <select class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade" required>
                                <option value="">Selecione primeiro um estado</option>
                            </select>
                            @error('cidade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url', $unidade->url) }}">
                            @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('unidades.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load estados
            fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
                .then(response => response.json())
                .then(data => {
                    const ufSelect = document.getElementById('uf');
                    data.forEach(estado => {
                        const option = new Option(estado.nome, estado.sigla);
                        ufSelect.add(option);
                    });
                    
                    // Set current value
                    ufSelect.value = '{{ old('uf', $unidade->uf) }}';
                    loadCidades('{{ old('uf', $unidade->uf) }}');
                });

            // Handle estado change
            $('#uf').change(function() {
                const uf = $(this).val();
                loadCidades(uf);
            });

            function loadCidades(uf) {
                const cidadeSelect = document.getElementById('cidade');
                cidadeSelect.innerHTML = '<option value="">Carregando cidades...</option>';

                if (!uf) {
                    cidadeSelect.innerHTML = '<option value="">Selecione primeiro um estado</option>';
                    return;
                }

                fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios?orderBy=nome`)
                    .then(response => response.json())
                    .then(data => {
                        cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                        data.forEach(cidade => {
                            const option = new Option(cidade.nome, cidade.nome);
                            cidadeSelect.add(option);
                        });

                        // Set current value
                        cidadeSelect.value = '{{ old('cidade', $unidade->cidade) }}';
                    });
            }
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