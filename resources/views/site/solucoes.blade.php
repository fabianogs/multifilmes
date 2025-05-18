@extends('layouts.site')

@section('content')
    <main class="in in-about">
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
            <div class="row mg-top-40 a-center">
                <div class="col md-up-offset-1 md-up-10 pd-horizontal-0">
                    <div class="d-flex fw-wrap"> 
                        @foreach ($categorias as $categoria)
                            <div class="col md-up-3 sm-4"> 
                                <a href="" class="box" data-fancybox data-src="#lightbox">
                                    <div class="box-icon"><img src="media/img/icons/car.png" alt=""></div>
                                    <h4 class="box-title">Películas de Controle Solar</h4>
                                    <p class="box-text">Estilo e segurança unidos em um só produto</p>
                                </a>
                                <div id="lightbox" class="lightbox">
                                    <div class="lightbox-content">
                                        <div class="lightbox-image"><img src="holder.js/520x300?auto=yes" alt=""></div>
                                        <div class="lightbox-text">
                                            <h2><span>Película</span> Automotiva</h2>
                                            <p>Estilo e segurança unidos em um só produto. Seu carro com a estética diferenciada, valorizando ainda mais
                                                suas conquistas, além de proteção contra raios solares, antivandalismo e muito mais privacidade,
                                                aumentando a experiência e o conforto de dirigir.</p>
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