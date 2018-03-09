<form class="form-inline" method="POST" action="busca.php">
    <div class="form-group">
        <label for="palavra">Empresa Solicitante:</label>
            <input name="palavra" type="text" class="form-control" placeholder="Empresa" id="skills">
    </div>
    <div class="form-group">
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
    <div class="form-group">
        <label for="data">Data:</label>
            <input type="date" name="data" class="form-control">
    </div>
    <div class="form-group">
        <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar</button>
    </div>
</form> 