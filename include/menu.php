<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Controle de chamados</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="../pages/home"><span class="glyphicon glyphicon-home"></span>&nbsp&nbspHome</a>
                </li>
                <li>
                    <a href="../pages/empresa"><span class="glyphicon glyphicon-folder-open"></span>&nbsp&nbspClientes</a>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list"></span>&nbsp&nbspChamados 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                            if($_SESSION['UsuarioNivel'] != 1) {
                                echo '<li>
                                        <a href="../pages/chamados">Atendimentos</a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="../pages/cad_chamado">Novo Chamado</a>
                                    </li>
                                    <li role="separator" class="divider"></li>';
                                }
                            ?>
                        <li>
                            <a href="../pages/chamadoespera">Novo Chamado Em Espera</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php 
                    if($_SESSION['UsuarioNivel'] != 1) { 
                        echo'
                            <li>
                                <a href="../pages/plantao"><span class="glyphicon glyphicon-plus"></span>&nbsp&nbspPlantão</a>
                            </li>
                                <ul class="nav navbar-nav" style="padding-left:15px;">
                                    <li class="dropdown">
                                        <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span>&nbsp&nbspRelatórios 
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="../pages/relatorio">Chamados por atendente</a>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="../pages/relatorioempre">Empresas Solicitantes </a>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="../pages/dadosempresasapi">Dados empresas API </a>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="../pages/empresasinertes">Dados empresas inertes API </a>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                        </ul>
                                    </li>
                                </ul>';
                    }
                ?>
                <ul class="nav navbar-nav" style="padding-left:15px;">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> 
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a style="padding-left:10px;" href="../pages/meuschamados"><?php echo "<img src='https://www.gravatar.com/avatar/$email' width='25px'>";?>
                                    <?php echo $_SESSION['UsuarioNome']; ?> 
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>

                            <?php
                                if($_SESSION['UsuarioNivel'] == 3){
                                    echo ' <li role="separator" class="divider"></li>         
                                            <li>
                                                <a href="../pages/cad_usuario">Cadastrar usuário</a>
                                            </li>';
                                }
                            ?>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="../pages/alterasenha">Alterar senha</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="../utilsPHP/logout">Sair</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="#">versão 1.1.1</a>
                            </li>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                </ul>
            </ul>
        </div>
    </div>
</nav>