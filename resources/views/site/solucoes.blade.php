@extends('layouts.site')

@section('content')
    <main class="in in-about">
        <section class="section-banner">
            <div class="item"><img src="{{ asset('img/banner.jpg') }}" alt="{{ $solucao->titulo }}">
                <div class="item-row">
                    <div class="item-text">
                        <h1>{{ $solucao->titulo }}</h1>
                        <h2>{{ $solucao->descricao }}</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col md-up-offset-1 md-up-10">
                    <div class="video"><iframe width="100%" height="600" src="https://www.youtube.com/embed/tkTTqI3DXUM"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe></div>
                    <div class="block mg-top-30">
                        <p class="block-text">{{ $solucao->descricao }}</p>
                    </div>
                </div>
            </div>
            <div class="row mg-top-40 a-center">
                <div class="col md-up-offset-1 md-up-10 pd-horizontal-0">
                    <div class="d-flex fw-wrap"> 
                        @foreach ($solucao->categorias as $categoria)
                            <div class="col md-up-3 sm-4"> 
                                <a href="{{ route('site.solucoes', $solucao->slug) }}" class="box">
                                    <div class="box-icon">
                                        @if($categoria->icone)
                                            <img src="{{ asset('storage/' . $categoria->icone) }}" alt="{{ $categoria->nome }}">
                                        @else
                                            <i class="fas fa-image text-muted" style="font-size: 24px;"></i>
                                        @endif
                                    </div>
                                    <h4 class="box-title">{{ $categoria->nome }}</h4>
                                    <p class="box-text">{{ $categoria->descricao }}</p>
                                </a>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection