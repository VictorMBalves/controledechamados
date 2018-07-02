<?php $time = date("Y-m-d");?>
    <br/>
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label>  
            <div id="empresa-div" class="col-sm-10">      
                <input name="empresa" type="text" id="empresa" class="form-control">
            </div>
        </div>
        <div class="form-group">               
            <label class="col-md-2 control-label" for="contato">Contato:</label>
            <div id="contato-div" class="col-sm-10">  
                <input name="contato" id="contato" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">                
            <label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>  
            <div id="formacontato-div" class="col-sm-2">
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
            <label class="col-md-2 control-label" for="telefone">Telefone</label>  
            <div id="telefone-div" class="col-sm-2">
                <input name="telefone" id="telefone" type="text" class="form-control" >
            </div>
            <label class="col-md-2 control-label" for="versao">Versão:</label>
            <div id="versao-div" class="col-sm-2">
                <input name="versao" id="versao" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="data">Data:</label>  
            <div id="data-div" class="col-sm-2">
                <input name="data" id="data" type="date" value="<?php echo $time?> "class="form-control">
            </div>
            <label class="col-md-2 control-label" for="horainicio">Horario de ínicio:</label>  
            <div id="horainicio-div" class="col-sm-2">
                <input name="horainicio" id="horainicio" type="time" class="form-control"  onchange="validarHorario()">
            </div>
            <label class="col-md-2 control-label" for="horafim">Horario de término:</label>  
            <div id="horafim-div" class="col-sm-2">
                <input name="horafim" id="horafim" type="time" class="form-control"  onchange="validarHorario()">      
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="sistema">Sistema:</label>
            <div id="sistema-div" class="col-sm-2">
                <input name="sistema" id="sistema" type="text" class="form-control" >
            </div>
            <label class="col-md-2 control-label" for="backup">Backup:</label>
            <div id="backup-div" class="col-sm-2">
                <select id="backup" name="backup" type="text" class="form-control" >
                    <option></option>
                    <option value="1">Google drive configurado</option>
                    <option value="0">Google drive não configurado</option>
                </select>
            </div>
            <label class="col-md-2 control-label" for="categoria">Categoria:</label>  
                <div id="categoria-div" class="col-sm-2">
                    <select name="categoria" id="categoria" type="text" class="form-control" >
                        <option></option>
                        <option value="Erro">Erro</option>
                        <option value="Duvida">Duvida</option>
                        <option value="Atualização sistema">Atualização sistema</option>
                        <option value="Sugestão de melhoria">Sugestão de melhoria</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>  
            <div id="descproblema-div" class="col-sm-10">
                <textarea name="descproblema" id="descproblema" type="text" class="form-control" ></textarea>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-2 control-label" for="descsolucao">Descrição da solução:</label>  
            <div id="descsolucao-div" class="col-sm-10">
                <textarea name="descsolucao" id="descsolucao" type="text" class="form-control" ></textarea>      
            </div>
        </div>  
        <div class="col-md-12 text-center">
            <?php include "../utilsPHP/statusDados.php";?>
            <button id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Salvar</button>
            <button id="cancel" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning">Cancelar</button>
        </div>
    </div>