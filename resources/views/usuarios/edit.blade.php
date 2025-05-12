@extends('adminlte::page')

@section('title', 'Editar usuário')

@section('content_header')
    <h1>Editar usuário</h1>
@stop

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('usuarios.update', $user->id)}}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="nome" >Nome</label>
                    <input type="text" name="name" id="name" required class="form-control" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required class="form-control" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="new_password">Nova senha</label>
                    <input type="text" name="new_password" id="new_password" class="form-control" placeholder="Digite apenas se quiser mudar a senha deste usuário">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{route('usuarios.index')}}" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
@stop
