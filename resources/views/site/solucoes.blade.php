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
                    <div class="video"><iframe width="100%" height="600" src="{{$categoria->video}}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe></div>
                    <div class="block mg-top-30">
                        <p class="block-text">{{ $categoria->descricao }}</p>
                    </div>
                </div>
            </div>
            <div class="row mg-top-40 a-center">
                <div class="col md-up-offset-1 md-up-10 pd-horizontal-0">
                    <div class="d-flex fw-wrap"> 
                        @foreach ($produtos as $produto)
                            <div class="col md-up-3 sm-4"> 
                                <a href="" class="box" data-fancybox data-src="#lightbox">
                                    <div class="box-icon">
                                        <img src="{{ asset('storage/' . $categoria->icone) }}" alt="">
                                    </div>
                                    <h4 class="box-title">{{$produto->nome}}</h4>
                                    <p class="box-text">{{$produto->descricao}}</p>
                                </a>
                                
                                <div id="lightbox" class="lightbox">
                                    <div class="lightbox-content">
                                        <div class="lightbox-image">
                                            <img src="{{ asset('storage/' . $produto->imagem) }}" alt="">
                                        </div>
                                        <div class="lightbox-text">
                                            <h2>{{$produto->nome}}</h2>
                                            <p>{{$produto->descricao}}</p>
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