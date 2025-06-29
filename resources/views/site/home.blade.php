@extends('layouts.site')

@section('content')
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
        <section class="section-about">
            <div class="row">
                <div class="col md-up-offset-1 md-up-10">
                    <article>
                        <h3>Conheça a <strong>MULTIFILMES</strong></h3>
                        <p>A Multifilmes nasceu em 1999, especializada em aplicação de películas de alta performance para
                            vidros. Estamos presentes no Brasil e Estados Unidos, com operações nos dois países. Somos
                            apaixonados pelo que fazemos, não há nada mais importante para nós do que a excelência em nossos
                            serviços e a satisfação total do cliente. Temos produtos que oferecem conforto, privacidade,
                            controle solar, segurança, estilo em decoração, personalizações de automóveis e imóveis. Seja no
                            seu imóvel ou no seu automóvel, sempre prestaremos o melhor serviço de acordo com sua demanda.
                        </p>
                        <div class="d-flex mg-top-30"><a href="{{ route('site.quem-somos') }}" class="btn">saiba mais</a></div>
                    </article>
                </div>
            </div>
        </section>
        @foreach ($solucoes as $solucao)
            <section class="section">
                <div class="row">
                    <div class="col md-up-offset-1 md-up-10">
                        <div class="block">
                            <h3 class="block-title">Soluções
                                <strong>{{ $solucao->titulo }}</strong>
                            </h3>
                            <p class="block-text">
                                {{ $solucao->descricao }}
                            </p>
                        </div>
                    </div>

                    <div class="col md-up-offset-1 md-up-10 pd-horizontal-0">
                        <div class="d-flex fw-wrap">
                            @foreach ($solucao->categorias->chunk(4) as $linha)
                                <div class="row w-100">
                                    @foreach ($linha as $categoria)
                                        <div class="col md-up-3 sm-6">
                                            <a href="{{route('site.categorias_solucao',$solucao->slug)}}" class="box">
                                                <div class="box-icon">
                                                    @if($categoria->icone)
                                                        <img src="{{ asset('storage/' . $categoria->icone) }}" alt="{{ $categoria->nome }}">
                                                    @else
                                                        <i class="fas fa-image"></i>
                                                    @endif
                                                </div>
                                                <h4 class="box-title">{{ $categoria->nome }}</h4>
                                                <p class="box-text">{{ $categoria->descricao }}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
        <a name="unidades"></a>
        <section class="section section-units">
            <div class="row">
                <div class="col md-up-offset-1 md-up-10">
                    <div class="box-unit">
                        <form action="">
                            <ul>
                                <li>
                                    <legend>Unidades</legend>
                                    <p>Conheça nossas unidades espalhadas pelo mundo. Selecione uma das cidades na listagem abaixo:</p>
                                </li>
                                <li class="d-flex mg-top-30">
                                    <select name="">
                                        @foreach ($unidades as $unidade)
                                            <option value="{{$unidade->id}}">{{ $unidade->cidade }}</option>
                                        @endforeach
                                    </select> 
                                    <button>OK</button></li>
                            </ul>
                        </form><img src="img/units.jpg" alt="">
                    </div>
                </div>
            </div>
        </section>
        <section class="section-blog">
            <div class="row">
                <div class="col md-up-offset-1 md-up-10">
                    <div class="block block-white">
                        <h3 class="block-title block-title-big">Universo Multifilmes</h3>
                        <p class="block-text">Nosso blog é amplo em novidades, notícias e oportunidades, vem com a gente
                            nesta experiência inspiradora:</p>
                    </div>
                </div>
                <div class="col">
                    <div class="carousel" data-ix="carousel" data-carousel-autoplay="false" data-carousel-loop="true"
                        data-carousel-margin="20" data-carousel-margin-991="20" 
                        data-carousel-items="{{ count($posts) }}"
                        data-carousel-items-1200="{{ count($posts) }}" 
                        data-carousel-items-991="{{ count($posts) }}" 
                        data-carousel-items-767="2"
                        data-carousel-items-480="1" 
                        data-carousel-items-0="1" 
                        data-carousel-center="false"
                        data-carousel-dots="false" 
                        data-carousel-nav="true" 
                        data-carousel-auto-width="false"
                        data-carousel-auto-height="false" 
                        data-carousel-mouse-drag="false" 
                        data-carousel-touch-drag="true"
                        data-carousel-pull-drag="true" 
                        data-carousel-auto-play-timeout="3500"
                        data-carousel-auto-play-hover-pause="true" 
                        data-carousel-thumbs="false"
                        data-carousel-thumbs-image="false"> 
                        @foreach ($posts as $post)
                            <a href="{{ route('site.post', $post->slug) }}" class="item">
                                <div class="item-image">
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="">
                                </div>
                                <div class="item-title">
                                    <h4>{{ $post->chamada_curta }}</h4><span>ler mais</span>
                                </div>
                            </a> 
                        @endforeach
                        </div>
                    <div class="button"><a href="blog" class="btn">mais postagens</a></div>
                </div>
            </div>
        </section>
@endsection
