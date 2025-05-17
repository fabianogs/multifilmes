@extends('adminlte::page')

@section('title', 'Posts')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-body">
                    <table class="table table-hover table-sm" id="postsTable">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Chamada Curta</th>
                                <th>Status</th>
                                <th width="15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr class="clickable-row" data-id="{{ $post->id }}">
                                    <td>{{ $post->titulo }}</td>
                                    <td>{{ $post->chamada_curta }}</td>
                                    <td>
                                        <input 
                                            type="checkbox" 
                                            class="toggle-ativo btn-sm" 
                                            data-id="{{ $post->id }}" 
                                            {{ $post->ativo ? 'checked' : '' }} 
                                            data-toggle="toggle" 
                                            data-on="Ativo" 
                                            data-off="Inativo" 
                                            data-onstyle="success" 
                                            data-offstyle="danger">
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('{{ route('posts.destroy', $post->id) }}')" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href={{ asset('css/admin_custom.css') }}>

    <style>
        /* Força altura menor no botão principal */
        .toggle.btn {
            height: 1.4rem !important;
            min-height: 1.4rem !important;
            padding: 0 0.4rem !important;
            font-size: 0.6rem !important;
            line-height: 1.1rem !important;
        }
    
        /* Ajusta altura interna dos botões ON/OFF */
        .toggle-group .btn {
            height: 1.4rem !important;
            min-height: 1.4rem !important;
            padding: 0 0.3rem !important;
            font-size: 0.6rem !important;
            line-height: 1.1rem !important;
        }
    
        /* Impede quebra de linha nos textos internos */
        .toggle .toggle-on,
        .toggle .toggle-off {
            white-space: nowrap;
        }
    
        /* Garante que a célula da tabela alinhe verticalmente */
        .table td .toggle {
            margin-top: -2px;
            vertical-align: middle;
        }
    
        /* Ajusta largura do botão toggle para não parecer gigante */
        .toggle.btn-sm {
            width: auto !important;
        }
    </style>
    
    
@stop

@section('js')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#postsTable').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    {
                        text: 'Inserir',
                        className: 'btn btn-primary',
                        action: function (e, dt, node, config) {
                            window.location.href = "{{ route('posts.create') }}";
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
                const editUrl = `{{ url('posts') }}/` + id + `/edit`;
                window.location.href = editUrl;
            });
        });

        function deleteItem(url) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não poderá ser revertida!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Excluído!',
                                data.toastr.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Erro!',
                            'Ocorreu um erro ao excluir o registro.',
                            'error'
                        );
                    });
                }
            });
        }

        @if(session('toastr'))
            toastr.{{ session('toastr.type') }}('{{ session('toastr.message') }}', '{{ session('toastr.title') }}', {
                timeOut: 1000,
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right"
            });
        @endif

        $(document).ready(function () {
            $('.toggle-ativo').change(function () {
                const postId = $(this).data('id');
                const ativo = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route('posts.set_ativo', ':id') }}'.replace(':id', postId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ativo: ativo
                    },
                    success: function (response) {
                        toastr.success(response.message || 'Status atualizado com sucesso!', 'Sucesso');
                    },
                    error: function () {
                        toastr.error('Não foi possível atualizar o status.', 'Erro');
                    }
                });
            });
        });
    </script>
@stop
