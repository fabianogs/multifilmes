@extends('adminlte::page')

@section('title', 'Usuários')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>Lista de usuários</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Cadastrar usuário</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-sm" id="table1">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->username}}</td>
                            <td width="130px">
                                <form action="{{ route('usuarios.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-default text-danger mx-1 shadow delete" title="Apagar" data-id={{$item->id}}>
                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </button>
                                    <a href="{{ route('usuarios.edit', $item->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        new DataTable('#table1', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
            }});
    </script>

    <script>
        $(document).ready(function () {
            @if (session('success'))
                $(document).Toasts('create', {
                    title: 'Sucesso',
                    class: 'bg-success',
                    autohide: true,
                    delay: 2100,
                    body: 'Operação realizada com sucesso.'
                })
            @endif
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.delete').click(function () {
                const id = $(this).data('id');
                const confirmation = window.confirm("Tem certeza que quer apagar?");
                if (confirmation) {
                    // User confirmed, submit the form for deletion
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@stop
