@extends('adminlte::page')

@section('title', 'SEOS')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
<br>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    Scripts para SEO
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Ativo?</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itens as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->nome}}</td>
                                    <td>
                                        <input type="checkbox" class="exibir-checkbox" data-id="{{ $item->id }}" {{ $item->status == '1' ? 'checked' : '' }}>
                                    </td>
                                    <td width="130px">
                                        <form action="{{ route('seo.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-xs btn-default text-danger mx-1 shadow delete" title="Apagar" data-id={{$item->id}}>
                                                <i class="fa fa-lg fa-fw fa-trash"></i>
                                            </button>
                                            <a href="{{ route('seo.edit', $item->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
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
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('css/admin_custom.css') }}>
@endsection

@section('js')
    <script>
        new DataTable('#table1', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
            }});

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

        $(document).ready(function () {
        $('.exibir-checkbox').change(function () {
            var checkbox = $(this);
            var itemId = checkbox.data('id');
            var isChecked = checkbox.prop('checked') ? 1 : 0;

            // Send AJAX request to update the database
            $.ajax({
                type: 'POST',
                url: '{{ route("seo.updateExibir") }}', // Update with your actual route
                data: {
                    _token: '{{ csrf_token() }}',
                    id: itemId,
                    ativo: isChecked
                },
                success: function (response) {
                    // Handle success if needed
                },
                error: function (error) {
                    console.error('Error updating exibir status:', error);
                }
            });
        });
    });
    </script>
@stop
