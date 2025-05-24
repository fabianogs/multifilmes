@extends('adminlte::page')

@section('title', 'Editar Usuário')

@section('content')
    <br>
        <div class="card card-primary card-outline">
            <div class="card-header">
                Editar usuário
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
                <form action="{{ route('usuarios.update', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nome (*)</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail (*)</label>
                        <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $user->email) }}">
                    </div>       
                    <div class="form-group">
                        <label for="password">Nova Senha (deixe em branco para manter a atual)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>                      
                    <div class="form-group">
                        <label for="role">Tipo de Usuário</label>
                        <select name="role" id="role" class="form-control">
                            <option value="franqueado" {{ old('role', $user->role) == 'franqueado' ? 'selected' : '' }}>Franqueado</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>    
                    <div class="form-group">
                        <label for="unidade_id">Unidade</label>
                        <select name="unidade_id" id="unidade_id" class="form-control">
                            <option value="">Selecione uma unidade</option>
                            @foreach($unidades as $unidade)
                                <option value="{{ $unidade->id }}" {{ old('unidade_id', $user->unidade_id) == $unidade->id ? 'selected' : '' }}>
                                    {{ $unidade->nome }}
                                </option>
                            @endforeach
                        </select>
                        @if($user->unidade_id)
                            <small class="form-text text-muted">
                                Unidade atual: {{ $user->unidade->nome }}
                            </small>
                        @endif
                    </div>     
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                        <a href="{{route('usuarios.index')}}" class="btn btn-sm btn-secondary">Voltar</a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                            <i class="fas fa-trash"></i> Apagar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
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

        function deleteUser(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não pode ser desfeita! O usuário será permanentemente excluído.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, apagar!',
                cancelButtonText: 'Cancelar',
                customClass: {
                    title: 'text-center',
                    content: 'text-center'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/usuarios/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Apagado!',
                                    text: 'O usuário foi removido com sucesso.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        title: 'text-center',
                                        content: 'text-center'
                                    }
                                }).then(() => {
                                    window.location.href = "{{ route('usuarios.index') }}";
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao tentar apagar o usuário.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                customClass: {
                                    title: 'text-center',
                                    content: 'text-center'
                                }
                            });
                        }
                    });
                }
            });
        }
    </script>
@stop
