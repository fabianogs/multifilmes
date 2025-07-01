@extends('layouts.site')

@section('content')
    <main class="in in-blog">
        <section class="section-banner">
            <div class="item"><img src="{{ asset('storage/' . $banners->imagem) }}" alt="">
                <div class="item-row">
                    <div class="item-text">
                        <h1>Nossas<br>Postagens</h1>
                        <h2>conheça a PPF - PELÍCULA PROTETORA DE PINTURA</h2>
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
                        <p class="block-text">Estilo e segurança unidos em um só produto. Seu carro com a estética
                            diferenciada, valorizando ainda mais suas conquistas, além de proteção contra raios solares,
                            antivandalismo e muito mais privacidade, aumentando a experiência e o conforto de dirigir. Ainda
                            contamos com opções de películas com um fator de proteção solar (FPS) superior a 1.000.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-blog">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col md-up-4 sm-6">
                        <a href="{{ route('site.post', ['slug' => $post->slug]) }}" class="item">
                            <div class="item-image"><img src="{{ asset('storage/' . $post->thumbnail) }}" alt=""></div>
                            <div class="item-title">
                                <h4>{{$post->chamada_curta}}</h4><span>ler mais</span>
                            </div>
                        </a>
                    </div>                    
                @endforeach
            </div>
        </section>
    </main>
@endsection