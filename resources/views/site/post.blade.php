@extends('layouts.site')

@section('content')
<main class="in in-post">
    <section class="section-banner">
        <div class="item"><img src="img/banner.jpg" alt="">
            <div class="item-row">
                <div class="item-text">
                    <h1>Películas<br>Automotivas</h1>
                    <h2>conheça a PPF - PELÍCULA PROTETORA DE PINTURA</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col md-up-offset-1 md-up-10">
                <div class="video">
                    <iframe width="100%" height="600" src="https://www.youtube.com/embed/tkTTqI3DXUM"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe></div>
                <div class="block mg-top-30">
                    <p class="block-text">{{ $post->conteudo }}</p>
                </div>
            </div>
        </div>
        @if($post->imagensGaleria->count() > 0)
        <div class="row mg-top-40 a-center">
            <div class="col md-up-10 md-up-offset-1">
                <div class="carousel" data-ix="carousel" data-carousel-autoplay="false" data-carousel-loop="false"
                    data-carousel-margin="0" data-carousel-margin-991="0" data-carousel-items="1"
                    data-carousel-items-1200="1" data-carousel-items-991="1" data-carousel-items-767="1"
                    data-carousel-items-480="1" data-carousel-items-0="1" data-carousel-center="false"
                    data-carousel-dots="false" data-carousel-nav="false" data-carousel-auto-width="false"
                    data-carousel-auto-height="false" data-carousel-mouse-drag="false" data-carousel-touch-drag="true"
                    data-carousel-pull-drag="true" data-carousel-auto-play-timeout="3500"
                    data-carousel-auto-play-hover-pause="true" data-carousel-thumbs="true"
                    data-carousel-thumbs-image="true"> 
                        @foreach($post->imagensGaleria as $imagem)
                            <img src="{{asset('storage/'.$imagem->imagem)}}" alt="">
                        @endforeach
                    </div>
            </div>
        </div>
        @endif
    </section>
</main>
@endsection