@extends('adminlte::page')

@section('title', 'Usuários')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    Usuários
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm" id="table1">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Tipo</th>
                                <th>Unidade</th>
                                <th width="3%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="clickable-row" data-id="{{ $user->id }}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role === 'admin' ? 'Administrador' : 'Franqueado' }}</td>
                                    <td>
                                        @if($user->role === 'franqueado' && $user->unidade)
                                            {{ $user->unidade->nome }}
                                        @else
                                            Todas
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('usuarios.edit', $user->id) }}" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href={{ asset('css/admin_custom.css') }}>
@stop

@section('js')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#table1').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    {
                        text: 'Inserir',
                        className: 'btn btn-primary',
                        action: function (e, dt, node, config) {
                            window.location.href = "{{ route('usuarios.create') }}";
                        }
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
                },
                pageLength: 10,
                responsive: true
            });

            $('.clickable-row').on('dblclick', function () {
                const id = $(this).data('id');
                const editUrl = `{{ url('usuarios') }}/` + id + `/edit`;
                window.location.href = editUrl;
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
    </script>
@stop
