<?php
    include '../validacoes/verificaSession.php';
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $id=$_GET['id_plantao'];
    $sql = $db->prepare("SELECT 	
                            DATE_FORMAT(p.data,'%d/%m/%Y') as data,
                            p.id_plantao,
                            p.empresa,
                            p.contato,
                            p.formacontato,
                            p.telefone,
                            p.sistema,
                            p.categoria,
                            p.horainicio,
                            p.horafim,
                            p.descproblema,
                            p.descsolucao,
                            categoria_id,
                            usu.nome AS usuario
                        FROM plantao p
                        LEFT JOIN usuarios usu ON usu.id = p.usuario_id
                        WHERE id_plantao=$id");
    $sql->execute();
    $plantao = $sql->fetch(PDO::FETCH_ASSOC);

    $idCategorias = $plantao['categoria_id'];
    $categorias = [];
    if($idCategorias != null){
        $sql = $db->prepare("SELECT * FROM categoria WHERE id in ($idCategorias)");
        $sql->execute();
        $categorias = $sql->fetchall(PDO::FETCH_ASSOC);
    }
?>
<div class="modal" tabindex="-1" role="dialog" id="modalCon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div  class="modal-title">
                        <h4>Consulta Plantão Nº <?php echo $id ?></h4>
                        <div class="row m-1" data-toggle="tooltip" data-placement="bottom" title="Categorias do chamado">
                                <?php
                                    foreach($categorias as $categoria){
                                        $style = "";
                                        $icon = "";
                                        switch($categoria['categoria']){
                                            case 'ERROS':
                                                $style = "badge-danger";
                                                $icon = "<i class='fas fa-bug'></i>";
                                                break;
                                            case 'DÚVIDAS':
                                                $style = "badge-warning";
                                                $icon = "<i class='fas fa-question'></i>";
                                                break;
                                            default:
                                                $style = "badge-info";
                                                $icon = "<i class='fas fa-cubes'></i>";
                                                break;
                                        }
                                        echo '<span class="badge '.$style.' m-1 text-uppercase">'.$icon.' '.$categoria['descricao'].'</span>';
                                    }
                                    if($chamado['categoria'])
                                        echo '<span class="badge badge-info m-1 text-uppercase">'.$icon.' '.$chamado['categoria'].'</span>';
                                ?>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="empresa">Empresa solicitante:</label>
                            <input value='<?php echo $plantao['empresa'];?>' name="empresa" type="text" disabled class="form-control disabled">
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="contato">Contato:</label>
                                <input value='<?php echo $plantao['contato'];?>' id="nome" name="contato" type="text" disabled class="form-control disabled">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="formacontato">Forma de contato:</label>
                                <input value="<?php echo $plantao['formacontato'];?>" type="text" name="formacontato" class="form-control disabled" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="telefone">Telefone:</label>
                                <input value='<?php echo $plantao['telefone'];?>' disabled name="telefone" type="text" class="form-control disabled">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="sistema">Sistema:</label>
                                <input type="text" value="<?php  echo $plantao['sistema'];?>" name="sistema" class="form-control disabled" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datainicio">Data inicio: </label>
                                <input class="form-control disabled" name="datainicio" disabled value='<?php echo $plantao['data'].' '.$plantao['horainicio'];?>'>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datafim">Data término:</label>
                                <input class="form-control forma disabled" name="datafim" disabled value='<?php echo $plantao['data'].' '.$plantao['horafim'];?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="responsavel">Responsável:</label>
                            <input class="form-control disabled" name="responsavel" disabled value='<?php echo $plantao['usuario']?>'>
                        </div>
                        <div class="form-group">
                            <label for="descproblema">Descrição do problema:</label>
                            <textarea name="descproblema" class="form-control disabled" disabled><?php echo $plantao['descproblema'];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="descsolucao">Solução:</label>
                            <textarea name="descsolucao" class="form-control disabled" disabled><?php echo $plantao['descsolucao'];?></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-center">
                        <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary" data-dismiss="modal">Retornar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>