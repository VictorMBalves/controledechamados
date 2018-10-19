<?php include '../validacoes/verificaSession.php'?>
<!Doctype html>
<html>
    <head>
        <title>Controle de chamados</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="../imagem/favicon.ico" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="../datatables/datatables.min.css">
        <link rel="stylesheet" href="../datatables/responsive.dataTables.min.css" >
        <link rel="stylesheet" href="../datatables/rowReorder.dataTables.min.css" >
        <link href="../assets/css/toastr.css" rel="stylesheet"/>
        <style>
            .my-table {
                overflow-x: auto;
            }

            table.width {
                width: 100%; /* Optional */
                border-collapse:collapse;
                white-space: nowrap; 
            }
            .material-switch > input[type="checkbox"] {
                display: none;   
            }

            .material-switch > label {
                cursor: pointer;
                height: 0px;
                position: relative; 
                width: 40px;  
            }

            .material-switch > label::before {
                background: rgb(0, 0, 0);
                box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
                border-radius: 8px;
                content: '';
                height: 16px;
                margin-top: -8px;
                position:absolute;
                opacity: 0.3;
                transition: all 0.4s ease-in-out;
                width: 40px;
            }
            .material-switch > label::after {
                background: rgb(255, 255, 255);
                border-radius: 16px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
                content: '';
                height: 24px;
                left: -4px;
                margin-top: -8px;
                position: absolute;
                top: -4px;
                transition: all 0.3s ease-in-out;
                width: 24px;
            }
            .material-switch > input[type="checkbox"]:checked + label::before {
                background: inherit;
                opacity: 0.5;
            }
            .material-switch > input[type="checkbox"]:checked + label::after {
                background: inherit;
                left: 20px;
            }
        </style>
    </head>
    <body>
        <?php include '../include/menu.php'; ?>
        <div class="container-fluid" style="margin-top:60px; margin-bottom:50px;">
            <h3>Empresas inertes</h3>
            <div class="form-inline" id="filtros">
                <div class="form-group">
                    <label for="Situação">Situação:</label>
                        <select id="situacao" type="text" class="form-control">
                            <option>Todas</option>
                            <option>Bloqueada</option>
                            <option>Ativo</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="versão">Versão a partir de:</label>
                        <input id="versao" type="text" name="versao" class="form-control" placeholder="Ex: 4.40.0">
                </div>
                <div class="form-group">
                    <label for="ignoreBlocked" class="control-label">Ignorar empresas bloqueadas</label>
                    <input type="checkbox" class="form-control" id="ignoreBlocked" data-toggle="tooltip" data-placement="top" title="Ignorar empresas bloqueadas">
                </div>
                <div class="form-group">
                    <label for="ignorePhoneNull" class="control-label">Ignorar empresas sem telefone</label>
                    <input type="checkbox" class="form-control" id="ignorePhoneNull">
                </div>
                <div class="form-group">
                    <button id="buscar" name="buscar" class="btn btn-group-lg btn-primary" data-toggle="tooltip" data-placement="top" title="Busca na API conforme a versão informada">Buscar</button>
                    <button id="refresh" type="reset" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="top" title="Recria a tabela com os filtros informados"><span class="glyphicon glyphicon-refresh"></span></button>
                    <!-- <button id="gerarReport" type="reset" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="top" title="Gera relatório detalhado">Gerar relatório</button> -->
                </div>
            </div> 
            <div id="resultadobusca"></div>
            <div class="row">
                <hr>
            </div>
            <div class="my-table">
                <table id="tabela" class="width table table-stripped">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Empresa</th>
                            <th>CNPJ</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Situação</th>
                            <th>Responsável</th>
                            <th>Telefone</th>
                            <th>Telefone 2</th>
                            <th>Celular</th>
                            <th>Versão</th>
                            <th>Sistema</th>
                            <th>Mensalidade</th>
                            <th>Dias sem acessar o sistema</th>
                        </tr>
                        <tbody id ="tbody">
                        </tbody>
                    </thead>
                    <div class="col-sm-12 text-center" id="loading"></div>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" tabindex="-1" role="dialog" id="modalReport">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gerar Relatório</h5>
            </div>
            <div class="modal-body">
                <form id="formAviso" class="form-horizontal">
                    <div class="form-group">
                        <label for="versão" class="control-label col-sm-2">Versão a partir de:</label>
                        <div class="col-sm-4">
                            <input id="versaoReport" type="text" name="versao" class="form-control" placeholder="Ex: 4.40.0">
                        </div>
                        <label for="versão" class="control-label col-sm-2">Dias sem acessar:</label>
                        <div class="col-sm-4">
                            <input id="diasSemAcessar" type="number" name="diasSemAcessar" min="0" class="form-control disabled" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="panelSituacao" class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading ">situação</div>
                            <!-- List group -->
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Todos
                                    <div class="material-switch pull-right">
                                        <input id="todos" name="todos" type="checkbox"/>
                                        <label for="todos" class="label-info"></label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    Ativo
                                    <div class="material-switch pull-right">
                                        <input id="ativo" name="ativo" type="checkbox"/>
                                        <label for="ativo" class="label-info"></label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    Bloqueado
                                    <div class="material-switch pull-right">
                                        <input id="bloqueado" name="bloqueado" type="checkbox"/>
                                        <label for="bloqueado" class="label-info"></label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    Teste
                                    <div class="material-switch pull-right">
                                        <input id="teste" name="teste" type="checkbox"/>
                                        <label for="teste" class="label-info"></label>
                                    </div>
                                </li>
                                <!-- <li class="list-group-item">
                                    Desistente
                                    <div class="material-switch pull-right">
                                        <input id="desistente" name="desistente" type="checkbox"/>
                                        <label for="desistente" class="label-info"></label>
                                    </div>
                                </li> -->
                            </ul>
                        </div>            
                    </div>
                    <div class="form-group">
                        <label for="agrupamento" class="control-label col-sm-3">Agrupar por:</label>
                        <div class="col-sm-8">
                            <select id="agrupamento" type="text" name="agrupamento" class="form-control">
                                <option value="estado">Estado</option>
                                <option value="sistema">Sistema</option>
                                <!-- <option value="dias">Dias sem acesso</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ordenacao" class="control-label col-sm-3">Ordenar por:</label>
                        <div class="col-sm-8">
                            <select id="ordenacao" type="text" name="ordenacao" class="form-control">
                                <option value="alfabetica">Alfabética</option>
                                <option value="dias">Dias DESC</option>
                                <option value="mensalidade">Mensalidade DESC</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="rodape">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-primary" id="modal-salvar">Gerar</button>
                    <button type="button" class="btn btn-secundary" id="modal-retornar">Cancelar</button>
                </div>
            </div>
            </div>
        </div>
    </div>

        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/js/jquery.maskedinput.min.js"></script>
        <script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../datatables/datatables.min.js"></script>
        <script src="../datatables/responsive.min.js"></script>
        <script src="../datatables/rowReorder.min.js"></script>
        <script src="../js/tabelas/dadosempresainerteapi.js"></script>
        <script src="../js/gerarReportEmpInertes.js"></script>
    </body>
</html>
