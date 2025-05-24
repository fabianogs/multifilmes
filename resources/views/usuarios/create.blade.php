@extends('adminlte::page')

@section('title', 'Usuários')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    Criar usuário
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('usuarios.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome (*)</label>
                            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail (*)</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                        </div>       
                        <div class="form-group">
                            <label for="password">Senha (*)</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>                      
                        <div class="form-group">
                            <label for="role">Tipo de Usuário</label>
                            <select name="role" id="role" class="form-control" onchange="toggleUnidadeField()">
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>                                
                                <option value="franqueado" {{ old('role') == 'franqueado' ? 'selected' : '' }}>Franqueado</option>
                            </select>
                        </div>    
                        <div class="form-group" id="unidadeField" style="display: {{ old('role') == 'franqueado' ? 'block' : 'none' }}">
                            <label for="unidade_id">Unidade (*)</label>
                            <select name="unidade_id" id="unidade_id" class="form-control">
                                <option value="">Selecione uma unidade</option>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}" {{ old('unidade_id') == $unidade->id ? 'selected' : '' }}>
                                        {{ $unidade->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>     
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                            <a href="{{route('usuarios.index')}}" class="btn btn-sm btn-secondary">Voltar</a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function toggleUnidadeField() {
            var role = document.getElementById('role').value;
            var unidadeField = document.getElementById('unidadeField');
            var unidadeSelect = document.getElementById('unidade_id');
            
            if (role === 'franqueado') {
                unidadeField.style.display = 'block';
                unidadeSelect.setAttribute('required', 'required');
            } else {
                unidadeField.style.display = 'none';
                unidadeSelect.removeAttribute('required');
                unidadeSelect.value = '';
            }
        }

        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Sucesso!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        title: 'text-center',
                        content: 'text-center'
                    }
                });
            @elseif (session('error'))
                Swal.fire({
                    title: 'Erro!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        title: 'text-center',
                        content: 'text-center'
                    }
                });
            @endif
        });
    </script>
@stop
