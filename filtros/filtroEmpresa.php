<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $stmt = $db->prepare("SELECT DISTINCT versao FROM empresa ORDER BY versao DESC");
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);
?>
<form  id="filtros">
    <div class="row">
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="palavra">Razão Social:</label>
            <input name="palavra" type="text" class="form-control" placeholder="Empresa" id="empresafiltro">
        </div>
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="situacao">Situação:</label>
            <select name="situacao" class="form-control">
                <option value="">
                </option>
                <option value="ATIVO">Ativo
                </option>
                <option value="DESISTENTE">Desistente
                </option>
                <option value="BLOQUEADO">Bloqueado
                </option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="sistema">Sistema:</label>
            <select name="sistema" class="form-control">
                <option value="">
                </option>
                <option value="GermanTech Light">Light
                </option>
                <option value="GermanTech Manager">Manager
                </option>
                <option value="GermanTech Gourmet">Gourmet
                </option>
            </select>
        </div>
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="versao">Versão:</label>
            <input type="checkbox" name="negaVersao" value="negaVersao" data-toggle="tooltip" data-placement="top" title="Versão diferente de:">
            <select name="versao" class="form-control">
                <option></option>
                <?php  
                    foreach ($resultado as $row) {
                        if($row['versao'] != null)
                            echo '<option value='.$row['versao'].'>'.$row['versao'].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group text-center">
        <button id="buscar" name="buscar" class="btn btn-group-lg btn-primary">Buscar</button>
        <button id="refresh" type="reset" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fas fa-sync-alt"></i></button>
        <button id="novo" type="button" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="top" title="Cadastrar novo cliente"><i class="fas fa-plus"></i></button>
    </div>
</form>