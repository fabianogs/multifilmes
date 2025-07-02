<header class="header">
    <div class="row a-center">
        <div class="col md-up-3"><a href="{{ route('site.home') }}" class="header-logo"><img
                    src="{{ asset('img/logo.png') }}" alt=""></a>
            <div class="burger"><span></span> <span></span> <span></span> <span></span></div>
        </div>
        <div class="col md-up-9">
            <nav class="header-menu">
                <ul>
                  <li>
                    <a>Soluções</a>
                    <div class="header-menu-dropdown">
                      @if(isset($headerSolucoes) && $headerSolucoes->count() > 0)
                        @foreach($headerSolucoes as $solucao)
                          <a href="{{ route('site.categorias_solucao', $solucao->slug) }}">{{ $solucao->titulo }}</a>
                        @endforeach
                      @else
                        <a href="">Nenhuma solução cadastrada</a>
                      @endif
                    </div>
                  </li>
                  <li><a href="home#unidades">unidades</a> </li>
                  <li><a href="{{ route('site.blog') }}">universo multifilmes</a></li>
                </ul>
            </nav>
        </div>
    </div><a href="https://sejafranqueado.multifilmes.com.br/" target="_blank" class="btn-franchisee"><i
            class="far fa-thumbs-up"></i> seja um franqueado!</a>
</header><a href="" class="whatsapp-fixed" target="_blank"><i class="fab fa-whatsapp"></i></a>