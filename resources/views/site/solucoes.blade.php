@extends('layouts.site')

@section('content')
    <main class="in in-about">
        <section class="section-banner">
            <div class="item"><img src="{{ asset('storage/' . $banners->imagem) }}" alt="">
                <div class="item-row">
                    <div class="item-text">
                        <h1>{{$banners->titulo}}</h1>
                        <h2>{{$banners->subtitulo}}</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col md-up-offset-1 md-up-10">
                    <div class="video"><iframe width="100%" height="600" src="{{ $solucao->categorias->first()->video ?? 'https://www.youtube.com/embed/C6Ficu-tySQ?si=8au-1zZa_Zm0vGq1' }}"
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
                                <a href="" class="box" data-fancybox data-src="#lightbox-{{ $categoria->id }}">
                                    <div class="box-icon">
                                        @if($categoria->icone)
                                            <img src="{{ asset('storage/' . $categoria->icone) }}" alt="{{ $categoria->nome }}">
                                        @else
                                            <i class="fas fa-image"></i>
                                        @endif
                                    </div>
                                    <h4 class="box-title">{{$categoria->nome}}</h4>
                                    <p class="box-text">{{$categoria->descricao}}</p>
                                </a>
                                
                                <div id="lightbox-{{ $categoria->id }}" class="lightbox">
                                    <div class="lightbox-content">
                                        <div class="lightbox-image">
                                            @if($categoria->imagem)
                                                <img src="{{ asset('storage/' . $categoria->imagem) }}" alt="{{ $categoria->nome }}">
                                            @else
                                                <img src="holder.js/520x300?auto=yes" alt="{{ $categoria->nome }}">
                                            @endif
                                        </div>
                                        <div class="lightbox-text">
                                            <h2>{{$categoria->nome}}</h2>
                                            <p>{{$categoria->descricao}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection