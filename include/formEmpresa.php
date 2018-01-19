<form class="form-inline" method="POST" action="buscaempresa.php">
    <div class="text-left col-sm-6">
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
        <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar</button>
    </div>
    <div class="text-right col-md-6">
    <button type="reset" class="btn btn-group-lg btn-success" onclick="cadastrar()">Cadastrar nova empresa</button>
    </div>
</form>