@extends('adminlte::page')

@section('title', 'Categorias')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    Categorias
                </div>                
                <div class="card-body">
                    <table class="table table-hover table-sm" id="categoriasTable">
                        <thead>
                            <tr>
                                <th width="50">Ícone</th>
                                <th>Categoria</th>
                                <th>Solução</th>
                                <th width="15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                                <tr class="clickable-row" data-id="{{ $categoria->id }}">
                                    <td>
                                        @if($categoria->icone)
                                            <img src="{{ asset('storage/' . $categoria->icone) }}" alt="{{ $categoria->nome }}" class="img-thumbnail" style="max-width: 40px; max-height: 40px;">
                                        @else
                                            <i class="fas fa-image text-muted" style="font-size: 24px;"></i>
                                        @endif
                                    </td>
                                    <td>{{ $categoria->nome }}</td>
                                    <td>
                                        @if($categoria->solucoes->isNotEmpty())
                                            {{ $categoria->solucoes->pluck('titulo')->implode(', ') }}
                                        @else
                                            <em>Sem solução</em>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('{{ route('categorias.destroy', $categoria) }}')" title="Excluir">
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
    <link rel="stylesheet" href={{ asset('css/admin_custom.css') }}>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            max-width: 100%;
            height: auto;
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

    <script>
        $(document).ready(function() {
            $('#categoriasTable').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    {
                        text: 'Inserir',
                        className: 'btn btn-primary',
                        action: function (e, dt, node, config) {
                            window.location.href = "{{ route('categorias.create') }}";
                        }
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
                },
                pageLength: 10,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [0, 3] } // Desabilita ordenação nas colunas de ícone e ações
                ]
            });

            $('.clickable-row').on('dblclick', function () {
                const id = $(this).data('id');
                const editUrl = `{{ url('categorias') }}/` + id + `/edit`;
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
    </script>
@stop 