<form class="form-inline" id="filtros">
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
                $versao = "SELECT DISTINCT versao FROM empresa";
                $rs = mysqli_query($conn, $versao);
                while ($w = mysqli_fetch_assoc($rs)) {
                    if($w['versao'] != null)
                        echo '<option value='.$w['versao'].'>'.$w['versao'].'</option>';
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <button id="buscar" name="buscar" class="btn btn-group-lg btn-primary">Buscar</button>
        <button id="refresh" type="reset" class="btn btn-group-lg btn-success"><span class="glyphicon glyphicon-refresh"></span></button>
        <button id="novo" type="button" class="btn btn-group-lg btn-success" onclick="cadastrar()">Nova</button>
    </div>
</form>