<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();

    $sql = $db->prepare('SELECT nome, nivel FROM usuarios');
    $sql->execute();
    $result = $sql->fetchall(PDO::FETCH_ASSOC);
?>
<form id="filtros">
    <div class="row">
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="palavra">Empresa Solicitante:</label>
                <input name="palavra" type="text" class="form-control flexdatalist" placeholder="Empresa" id="empresafiltro" >
        </div>
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="status">Status:</label>
            <select name="status" class="form-control">
                <option value="">
                </option>
                <option value="Aberto">Aberto
                </option>
                <option value="Finalizado">Finalizado
                </option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="usuario">Responsável: </label>
            <select name="usuario" class="form-control">
                <option></option>       
                <?php
                    foreach ($result as $row) {
                        if ($row["nivel"] != 1) {
                            echo '<option>'.$row['nome'].'</option>';
                        }
                    }
                ?>
            </select>
    </div>
    <div class="row">
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="datainicio">Data inicial:</label>
                <input type="date" name="datainicio" class="form-control">
        </div>
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
            <label for="datafinal">Data final:</label>
                <input type="date" name="datafinal" class="form-control">
        </div>
    </div>
    <div class="form-group text-center">
        <button id="buscar" name="buscar" class="btn btn-group-lg btn-primary">Buscar</button>
        <button id="refresh" type="reset" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="bottom" title="Refresh"><i class="fas fa-sync-alt"></i></button>
    </div>
</form> 