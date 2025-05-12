@extends('adminlte::page')

@section('title', 'Criar usuário')

@section('content_header')
    <h1>Criar usuário</h1>
@stop

@section('content')
    <div class="card">
        <form id="form1" action={{ route('usuarios.store') }} method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome" >Nome</label>
                    <input type="text" name="nome" id="nome" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="emial">Email</label>
                    <input type="email" name="email" id="email" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" required class="form-control">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@stop
