<footer class="footer">
    <div class="row">
        <div class="col md-up-offset-1 md-up-4 sm-6">
            <div class="bd"><a href="home" class="footer-logo"><img src="img/logo.png" alt=""></a>
                <div class="div"><span>MULTIFILMES WINDOW FILM LTDA</span> CNPJ: 13.499.040/0001-71</div>
                <div class="div"><span>Central de Negócios</span> Rua Lêda Vassimon, 570 – Jd. Nova Aliança<br>Ribeirão
                    Preto - SP (16) 3234-5002</div>
                <div class="footer-social">
                    @if(!empty($config->whatsapp))
                        <a href="{{ $config->whatsapp}}"><i class="fab fa-whatsapp"></i></a>
                    @endif
                    @if(!empty($config->youtube)) 
                        <a href="{{ $config->youtube }}"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if(!empty($config->instagram))
                        <a href="{{ $config->instagram}}"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($config->facebook))
                        <a href="{{ $config->facebook}}"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($config->linkedin))
                        <a href="{{ $config->linkedin}}"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                </div>
                <div class="footer-copy"><a href="">Política de Privacidade</a> © Copyright 2021<br>Todos s direitos
                    reservados a Multifilmes Window Film</div>
            </div>
        </div>
        <div class="col md-up-4 sm-6">
            <nav class="footer-menu">
                <ul>
                    <li><a href="{{ route('site.quem-somos')}}">Sobre nós</a></li>
                    <li><a href="{{route('site.solucoes', 'automotivas')}}">Automotivas</a></li>
                    <li><a href="{{route('site.solucoes', 'residenciais-corporativas')}}">Residenciais e Corporativas</a></li>
                    <li><a href="{{route('site.unidades')}}">Unidades</a></li>
                    <li><a href="blog">Universo Multifilmes</a></li>
                </ul>
            </nav>
            <div class="footer-form">
                <form action="">
                    <ul>
                        <li>
                            <legend>PORTAL DO FRANQUEADO</legend>
                        </li>
                        <li><input type="text" placeholder="Usuário"> 
                            <input type="text" placeholder="Senha"> 
                            <button class="btn"><i class="fas fa-arrow-circle-right"></i></button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col md-up-offset-1 md-up-10">
            <div class="footer-franchisee">
                <div class="image"><img src="img/junior.png" alt=""></div>
                <div class="text">
                    <h3>Seja um <strong>FRANQUEADO</strong></h3>
                    <p>Se você esta em busca do primeiro negócio, é um empreendedor, é apaixonado por carro, casas
                        modernas, ou ainda quer ter seu próprio negócio? A Multifilmes é uma excelente oportunidade para
                        você iniciar a sua vida empresarial, são mais de 70 unidades em todo Brasil, com total suporte
                        de quem mais entende do assunto.</p>
                </div>
                <div class="d-flex jc-bet a-center mg-top-40"><a href="https://sejafranqueado.multifilmes.com.br/"
                        target="_blank" class="btn">QUERO SABER MAIS</a>
                    <div class="d-flex a-center"><img src="img/logo2.png" alt=""> <img src="img/abf.png"
                            alt="" class="mg-left-20"></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div data-cookie>
    <p>Usamos cookies para personalizar conteúdos e melhorar a sua experiência. Ao navegar neste site, você concorda com
        a nossa <a href="#">Política de Privacidade.</a></p><a class="btn"
        data-cookie-btn>Entendi</a>
</div>