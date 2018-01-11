@include('header')

<div id="container">
    <form method="post" action="{{url('/login')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="username-instagram">
                Nome de usu&aacute;rio:
            </label>
            <input type="text" name="usuario" id="username-instagram" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="password-instagram" class="bold">
                Senha:
            </label>
            <input type="password" name="senha" id="password-instagram"
                   class="form-control"/>
        </div>
        <p id="login-message" class="no-margin login-message">&nbsp;</p>
        <div id="lower">
            <p>
                <a href="https://instagram.com/accounts/password/reset/" target="_blank">Esqueci minha senha</a>
                <button type="submit" class="instafollow-button" id="login-botao-entrar"> Entrar</button>
            </p>
        </div>
    </form>
</div>
<div class="corpo-post">
    <h3><p class="billabong titulo-apresentacao-home">O que &eacute;?</p></h3>
    <img src="https://igoodigital.com/novoinsta/img/cloud_home.png" border="0" class="pull-left"/>
    <p align="justify" class="pull-left apresentacao-home-texto">
        O Instafollow &eacute; um aplicativo cujo objetivo &eacute; conseguir mais seguidores para o seu
        perfil na rede social instagram.
    </p>
    <div class="clear"></div>
    <hr class="hr-home"/>
    <!-- -->

    <h3><p class="billabong titulo-apresentacao-home">Como funciona?</p></h3>
    <img src="https://igoodigital.com/novoinsta/img/tools_home.png" border="0" class="pull-left"/>
    <p align="justify" class="pull-left apresentacao-home-texto">
        O sistema InstaFollow consiste na troca de seguidores entre usu&aacute;rios cadastrados no
        sistema(site).
        Funciona da seguinte forma:
        Voc&eacute; entra no sistema com seu login e senha de sua conta no Instagram e sua conta ser&aacute;
        criada automaticamente no nosso site.
        E dentro desse nosso painel voc&ecirc; pode conseguir seus seguidores, em troca disso, o sistema
        utilizar&aacute; seu perfil para seguir futuramente novos usu&aacute;rios que usar&atilde;o o
        sistema.
        Quanto mais voc&ecirc; utilizar mais seguidores voc&ecirc; ter&aacute;, e menos pessoas voc&ecirc;
        seguir&aacute;.
    </p>
    <div class="clear"></div>
    <hr class="hr-home"/>
    <!-- -->
    <h3><p class="billabong titulo-apresentacao-home">Nosso objetivo</p></h3>
    <img src="https://igoodigital.com/novoinsta/img/objetivo_home.png" border="0" class="pull-left"/>
    <p align="justify" class="pull-left apresentacao-home-texto">
        O foco do site &eacute; o aumento de popularidade, deixar todos usu&aacute;rios e clientes com
        seguidores para que possam interagir e/ou divulgar sua marca ou produtos.
    </p>
    <div class="clear"></div>
    <!-- -->
</div>

@include('footer')