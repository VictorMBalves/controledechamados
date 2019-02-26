<?php $time = date("Y-m-d");?>
    <div class="row">
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">    
            <label for="empresaPlantao">Empresa solicitante:</label>  
            <input name="empresaPlantao" type="text" id="empresaPlantao" class="form-control">
            <div id="empresaBloqueada" class="text-danger hidden"><small>Empresa bloqueada</small></div>
        </div>
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">  
            <label for="contatoPlantao">Contato:</label>
            <input name="contatoPlantao" id="contatoPlantao" type="text" class="form-control">
        </div>
    </div>
    <div class="row">                
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4"> 
            <label for="formacontato">Forma de contato:</label>  
            <select name="formacontato" id="formacontato" class="form-control">
                <option>
                </option>
                <option value="Cliente ligou">Cliente ligou
                </option>
                <option value="Ligado para o cliente">Ligado para o cliente
                </option>
                <option value="Whatsapp">Whatsapp
                </option>
                <option value="Team Viewer">Team Viewer
                </option>
                <option value="Skype">Skype
                </option>
            </select>
        </div>
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4"> 
            <label for="telefonePlantao">Telefone</label>  
            <input name="telefonePlantao" id="telefonePlantao" type="text" class="form-control" >
        </div>
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
            <label for="versaoPlantao">Versão:</label>
            <input name="versaoPlantao" id="versaoPlantao" type="text" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
            <label for="data">Data:</label>  
            <input type="date" name="data" id="data" value="<?php echo $time?>"class="form-control">
        </div>
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
            <label for="horainicio">Horario de ínicio:</label>  
            <input name="horainicio" id="horainicio" type="time" class="form-control"  onchange="validarHorario()">
        </div>
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
            <label for="horafim">Horario de término:</label>  
            <input name="horafim" id="horafim" type="time" class="form-control"  onchange="validarHorario()">      
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
            <label for="sistemaPlantao">Sistema:</label>
            <input name="sistemaPlantao" id="sistemaPlantao" type="text" class="form-control" >
        </div>
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
            <label for="backup">Backup:</label>
            <select id="backup" name="backup" type="text" class="form-control" >
                <option></option>
                <option value="1">Google drive configurado</option>
                <option value="0">Google drive não configurado</option>
            </select>
        </div>
        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
            <label for="categoria">Categoria:</label>  
            <select name="categoria" id="categoria" type="text" class="form-control" >
                <option></option>
                <option value="Erro">Erro</option>
                <option value="Duvida">Duvida</option>
                <option value="Atualização sistema">Atualização sistema</option>
                <option value="Sugestão de melhoria">Sugestão de melhoria</option>
                <option value="Retorno">Retorno</option>
                <option value="Outros">Outros</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="descproblema">Descrição do problema:</label>  
        <textarea name="descproblema" id="descproblema" type="text" class="form-control" ></textarea>
    </div>
    <div class="form-group">
        <label for="descsolucao">Descrição da solução:</label>  
        <textarea name="descsolucao" id="descsolucao" type="text" class="form-control" ></textarea>      
    </div>  
    <div class="form-group text-center">
        <?php include "../utilsPHP/statusDados.php";?>
        <button id="salvarPlantao" name="salvarPlantao" class="btn btn-group-lg btn-primary">Salvar</button>
        <button id="cancel" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning">Cancelar</button>
    </div>