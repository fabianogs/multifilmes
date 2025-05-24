@extends('adminlte::page')

@section('title', 'Banners')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    Banners
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm" id="table1">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Título</th>
                                <th>Subtítulo</th>
                                <th>Ativo?</th>
                                <th width="3%">Ações</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $item)
                                <tr  class="clickable-row" data-id="{{ $item->id }}">
                                    <td>
                                        @if($item->imagem)
                                            <img src="{{ asset('storage/' . $item->imagem) }}" alt="{{ $item->titulo }}" style="max-width: 100px; max-height: 50px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Sem imagem</span>
                                        @endif
                                    </td>
                                    <td>{{$item->titulo}}</td>
                                    <td>{{$item->subtitulo}}</td>
                                    <td style="text-align: center;">
                                        <input type="checkbox" class="toggle-status" data-id="{{ $item->id }}" 
                                            {{ $item->ativo? 'checked' : '' }} data-toggle="switch">
                                    </td>
                                    <td style="text-align: center;"><a href="{{ route('banners.edit', $item->id) }}" title="Editar"><i class="fas fa-edit"></i></a></td>                                    
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
                            window.location.href = "{{ route('banners.create') }}";
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
                const editUrl = `{{ url('banners') }}/` + id + `/edit`;
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

        // Função para ativar/desativar banner
        $('.toggle-status').on('change', function() {
            const id = $(this).data('id');
            const ativo = $(this).prop('checked');
            
            fetch(`/banners/${id}/set_ativo`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ativo: ativo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Status do banner atualizado com sucesso!', 'Sucesso', {
                        timeOut: 1000,
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right"
                    });
                } else {
                    toastr.error('Erro ao atualizar status do banner', 'Erro', {
                        timeOut: 1000,
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right"
                    });
                    // Reverte o checkbox em caso de erro
                    $(this).prop('checked', !ativo);
                }
            })
            .catch(error => {
                toastr.error('Erro ao atualizar status do banner', 'Erro', {
                    timeOut: 1000,
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right"
                });
                // Reverte o checkbox em caso de erro
                $(this).prop('checked', !ativo);
            });
        });
    </script>
@stop 