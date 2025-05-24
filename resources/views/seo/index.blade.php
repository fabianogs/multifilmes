@extends('adminlte::page')

@section('title', 'SEO')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    SEO
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm" id="table1">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th width="3%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($seos as $seo)
                                <tr class="clickable-row" data-id="{{ $seo->id }}">
                                    <td>{{ $seo->nome }}</td>
                                    <td>{{ $seo->tipo }}</td>
                                    <td>{{ $seo->unidade->cidade }}</td>
                                    <td>
                                        <span class="badge {{ $seo->status ? 'badge-success' : 'badge-danger' }}">
                                            {{ $seo->status ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('seo.edit', $seo->id) }}" title="Editar">
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
                            window.location.href = "{{ route('seo.create') }}";
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
                window.location.href = "{{ route('seo.edit', ['id' => ':id']) }}".replace(':id', id);
            });
        });

        $('.toggle-exibir').change(function() {
            var seoId = $(this).data('id');
            var checkbox = $(this);

            $.ajax({
                url: "{{ route('seo.update', ['id' => ':id']) }}".replace(':id', seoId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exibir: checkbox.prop('checked')
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Status de exibição atualizado com sucesso.');
                    } else {
                        toastr.error('Erro ao atualizar status de exibição.');
                        checkbox.prop('checked', !checkbox.prop('checked'));
                    }
                },
                error: function() {
                    toastr.error('Erro ao atualizar status de exibição.');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
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
