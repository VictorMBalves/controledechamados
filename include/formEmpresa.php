<form class="form-inline" method="POST" action="buscaempresa.php">
    <div class="text-left col-sm-10">
        <div class="form-group">
            <label for="palavra">Razão Social:</label>
            <input name="palavra" type="text" class="form-control" placeholder="Empresa" id="skills">
        </div>
        <div class="form-group">
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
        <div class="form-group">
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
        <div class="form-group">
            <label for="versao">Versão:</label>
            <input type="checkbox" name="negaVersao" value="negaVersao" data-toggle="tooltip" data-placement="top" title="Versão diferente de:">
            <select name="versao" class="form-control">
                <option></option>
                <?php  
                    $versao = "SELECT versao FROM empresa";
                   $rs = mysqli_query($conn, $versao);
                    while ($w = mysqli_fetch_assoc($rs)) {
                        if($w['versao'] != null)
                            echo '<option value='.$w['versao'].'>'.$w['versao'].'</option>';
                    }
                ?>
            </select>
        </div>
        <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar</button>
    </div>
    <div class="text-right col-md-2">
    <button type="reset" class="btn btn-group-lg btn-success" onclick="cadastrar()">Cadastrar nova empresa</button>
    </div>
</form>