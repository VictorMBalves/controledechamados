<?php $time = date("Y-m-d");?>
    <br/>
    <form name="formplantao"class="form-horizontal" action="../inserts/insere_plantao2.php" method="POST">
        <div class="form-group">
            <label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label>  
            <div class="col-sm-10">      
                <input name="empresa" type="text" id="empresa" class="form-control" required="">
            </div>
        </div>
        <div class="form-group">               
            <label class="col-md-2 control-label" for="contato">Contato:</label>
            <div class="col-sm-10">  
                <input name="contato" type="text" class="form-control" required="">
            </div>
        </div>
        <div class="form-group">                
            <label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>  
            <div class="col-sm-2">
                <select name="formacontato" type="text" class="form-control" required="">
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
            <div class="col-sm-2">
                <input name="telefone" type="text" class="form-control" required="">
            </div>
            <label class="col-md-2 control-label" for="versao">Versão:</label>
            <div class="col-sm-2">
                <input name="versao" type="text" class="form-control" required="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="data">Data:</label>  
            <div class="col-sm-2">
                <input name="data" type="date" value="<?php echo $time?>"class="form-control" required="">
            </div>
            <label class="col-md-2 control-label" for="horainicio">Horario de ínicio:</label>  
            <div class="col-sm-2">
                <input name="horainicio" type="time" class="form-control" required="" onchange="validarHorario()">
            </div>
            <label class="col-md-2 control-label" for="horafim">Horario de término:</label>  
            <div class="col-sm-2">
                <input name="horafim" type="time" class="form-control" required="" onchange="validarHorario()">      
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="sistema">Sistema:</label>
            <div class="col-sm-2">
                <input name="sistema" type="text" class="form-control" required="">
            </div>
            <label class="col-md-2 control-label" for="backup">Backup:</label>
            <div class="col-sm-2">
                <select id="backup" name="backup" type="text" class="form-control" required="">
                    <option></option>
                    <option value="1">Google drive configurado</option>
                    <option value="0">Google drive não configurado</option>
                </select>
            </div>
            <label class="col-md-2 control-label" for="categoria">Categoria:</label>  
                <div class="col-sm-2">
                    <select name="categoria" type="text" class="form-control" required="">
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
            <div class="col-sm-10">
                <textarea name="descproblema" type="text" class="form-control" required=""></textarea>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-2 control-label" for="descsolucao">Descrição da solução:</label>  
            <div class="col-sm-10">
                <textarea name="descsolucao" type="text" class="form-control" required=""></textarea>      
            </div>
        </div>  
        <div class="col-md-12 text-center">
            <?php include "../utilsPHP/statusDados.php";?>
            <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary" onclick="validarHorario()">Gravar</button>
            <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning">Cancelar</button>
        </div>
    </form>