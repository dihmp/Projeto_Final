<nav class="navbar navbar-expand-sm navbar-light" role="navigation" style="background-color: #F8F8F8">
    <a class="navbar-brand" href="/arterepo/index.php" style="color: #2AB9DD; padding-left: 70px">
        <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>Acervo de Artes
    </a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

    <div id="navMenu" class="navbar-collapse collapse">
        <ul class="navbar-nav mr-auto"></ul>
        <ul class="navbar-nav" style="padding-right: 70px">
            <li class="nav-item">
                <a class="nav-link" href="/arterepo/artista/artistas.php" style="color: #2AB9DD; padding-right: 20px">Artistas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/arterepo/arte/artes.php" style="color: #2AB9DD; padding-right: 20px">Obras de Artes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/arterepo/museu/museus.php" style="color: #2AB9DD; padding-right: 20px">Museus</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #2AB9DD">
                  Minha Conta
                </a>
                <div class="dropdown-menu" aria-labelledby="navMenu">
                    <?php if($uid==0){ ?>
                        <a class="dropdown-item" href="/arterepo/conta/entrar_conta.php">Entrar</a>
                        <a class="dropdown-item" href="/arterepo/conta/criar_conta.php">Cadastrar</a>
                    <?php }else{ ?>
                        <?php if($permissao_usuario['adicionar_arte']=='1' || 
                                 $permissao_usuario['editar_arte']=='1' ||
                                 $permissao_usuario['editar_todas_artes']=='1'){ ?>
                            <a class="dropdown-item" href="/arterepo/arte/minhas_artes.php">Minhas Artes</a>
                        <?php } ?>
                        <?php if($permissao_usuario['adicionar_artista']=='1' || 
                                 $permissao_usuario['editar_artista']=='1' ||
                                 $permissao_usuario['editar_todos_artistas']=='1'){ ?>
                            <a class="dropdown-item" href="/arterepo/artista/meus_artistas.php">Meus Artistas</a>
                        <?php } ?>
                        <?php if($permissao_usuario['adicionar_museu']=='1' || 
                                 $permissao_usuario['editar_museu']=='1' ||
                                 $permissao_usuario['editar_todos_museus']=='1'){ ?>
                            <a class="dropdown-item" href="/arterepo/museu/meus_museus.php">Meus Museus</a>
                        <?php } ?>
                        <?php if($permissao_usuario['editar_profissao']=='1' || $permissao_usuario['adicionar_profissao']=='1'){ ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/arterepo/profissao/profissoes.php">Profissões</a>
                        <?php } ?>
                        <?php if($permissao_usuario['adicionar_genero']=='1' || $permissao_usuario['editar_genero']=='1'){ ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/arterepo/genero/generos.php">Editar Genero</a>
                        <?php } ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/arterepo/conta/sair_conta.php">Sair</a>
                    <?php } ?>
                </div>
            </li>
        </ul>
    </div>
</nav>