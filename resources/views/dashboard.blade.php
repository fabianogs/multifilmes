@extends('adminlte::page')

@section('title', 'Dashboard - Multifilmes')

@section('content_header')
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    <p>Bem-vindo ao painel administrativo da Multifilmes</p>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Cards de Estatísticas -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{ route('marcas.index') }}" class="small-box-footer">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $marcas ?? 0 }}</h3>
                            <p>Marcas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('categorias.index') }}" class="small-box-footer">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $categorias ?? 0 }}</h3>
                            <p>Categorias</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-fw fa-medal"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('unidades.index') }}" class="small-box-footer">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $unidades ?? 0 }}</h3>
                            <p>Unidades</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-fw fa-store"></i>
                        </div>
                    </div>
                </a>
            </div>          
            <div class="col-lg-3 col-6">
                <a href="{{ route('solucoes.index') }}" class="small-box-footer">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $solucoes ?? 0 }}</h3>
                            <p>Soluções</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-fw fa-lightbulb"></i>
                        </div>
                    </div>
                </a>
            </div>              
        </div>

        <!-- Novos Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{ route('posts.index') }}" class="small-box-footer">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $posts ?? 0 }}</h3>
                            <p>Posts do Blog</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('banners.index') }}" class="small-box-footer">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $banners ?? 0 }}</h3>
                            <p>Banners Ativos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-images"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('usuarios.index') }}" class="small-box-footer">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $usuarios ?? 0 }}</h3>
                            <p>Usuários</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('config.index') }}" class="small-box-footer">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{ $configs ?? 0 }}</h3>
                            <p>Configurações</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Seção de Conteúdo Dinâmico -->
        <div class="row">
            <!-- Posts Recentes -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-newspaper"></i> Posts Recentes
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Novo Post
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($postsRecentes) && count($postsRecentes) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Status</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($postsRecentes as $post)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('posts.edit', $post->id) }}">
                                                        {{ Str::limit($post->titulo, 30) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($post->ativo)
                                                        <span class="badge badge-success">Ativo</span>
                                                    @else
                                                        <span class="badge badge-secondary">Inativo</span>
                                                    @endif
                                                </td>
                                                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Nenhum post encontrado.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Banners Ativos -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-images"></i> Banners Ativos
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('banners.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Novo Banner
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($bannersAtivos) && count($bannersAtivos) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Subtítulo</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bannersAtivos as $banner)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('banners.edit', $banner->id) }}">
                                                        {{ Str::limit($banner->titulo, 20) }}
                                                    </a>
                                                </td>
                                                <td>{{ Str::limit($banner->subtitulo, 25) }}</td>
                                                <td>
                                                    @if($banner->ativo)
                                                        <span class="badge badge-success">Ativo</span>
                                                    @else
                                                        <span class="badge badge-secondary">Inativo</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Nenhum banner ativo encontrado.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de Ações Rápidas -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt"></i> Ações Rápidas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ route('posts.create') }}" class="btn btn-outline-primary btn-block">
                                    <i class="fas fa-plus"></i><br>
                                    Criar Post
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('banners.create') }}" class="btn btn-outline-success btn-block">
                                    <i class="fas fa-image"></i><br>
                                    Criar Banner
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('usuarios.create') }}" class="btn btn-outline-warning btn-block">
                                    <i class="fas fa-user-plus"></i><br>
                                    Novo Usuário
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('config.index') }}" class="btn btn-outline-info btn-block">
                                    <i class="fas fa-cog"></i><br>
                                    Configurações
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Sistema -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i> Informações do Sistema
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Dados do Usuário</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Nome:</strong> {{ auth()->user()->name }}</li>
                                    <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                                    <li><strong>Função:</strong> 
                                        @if(auth()->user()->isAdmin())
                                            <span class="badge badge-danger">Administrador</span>
                                        @elseif(auth()->user()->isFranqueado())
                                            <span class="badge badge-warning">Franqueado</span>
                                        @else
                                            <span class="badge badge-secondary">Usuário</span>
                                        @endif
                                    </li>
                                    @if(auth()->user()->unidade)
                                        <li><strong>Unidade:</strong> {{ auth()->user()->unidade->nome }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Estatísticas Gerais</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Total de Posts:</strong> {{ $posts ?? 0 }}</li>
                                    <li><strong>Total de Banners:</strong> {{ $banners ?? 0 }}</li>
                                    <li><strong>Total de Usuários:</strong> {{ $usuarios ?? 0 }}</li>
                                    <li><strong>Total de Unidades:</strong> {{ $unidades ?? 0 }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <style>
        .small-box {
            transition: transform 0.3s ease;
        }
        .small-box:hover {
            transform: translateY(-5px);
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
        }
        .btn-block {
            height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 14px;
        }
        .btn-block i {
            font-size: 24px;
            margin-bottom: 5px;
        }
    </style>
@stop

@section('js')
    <script>
        // Auto-refresh dos dados a cada 5 minutos
        setInterval(function() {
            location.reload();
        }, 300000);
    </script>
@stop
