@extends('adminlte::page')

@section('title', 'Editar SEO')

@section('content_header')
    <h1>Editar SEO</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="form1" action={{ route('seo.update', $seo->id) }} method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" value="{{$seo->nome}}">
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control">
                        @if ($seo->tipo == 'head')
                            <option value="head" selected>Head</option>
                            <option value="body">Body</option>
                        @else
                            <option value="head">Head</option>
                            <option value="body" selected>Body</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        @if ($seo->status == '1')
                            <option value="1" selected>Sim</option>
                            <option value="0">Não</option>
                        @else
                            <option value="1">Sim</option>
                            <option value="0" selected>Não</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="script">Script</label>
                    <textarea name="script" id="script" cols="30" rows="5" class="form-control">{{$seo->script}}</textarea>
                </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
            <a href="{{route('seo.index')}}" class="btn btn-secondary btn-sm">Voltar</a>
        </div>
            </form>
    </div>
@stop
