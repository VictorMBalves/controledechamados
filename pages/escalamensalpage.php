    <br>
    <br>
    <form class="form-horizontal">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="titulo" class="control-label col-sm-2">Mês</label>
                    <div class="col-sm-10">
                        <select name="mes" type="text" class="form-control" title="Selecione um mês" id="mes" onchange="getUsuarios()">
                            <option value="01">Janeiro</option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="titulo" class="control-label col-sm-2">Usuário</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" id="usuarios" placeholder="Usuário ...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="adc"><i class="glyphicon glyphicon-plus"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Usuários</h3>
                    </div>
                    <div class="panel-body">
                        <div id="lista" class="list-group">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success" id="salvar">Salvar</button>
                <button type="button" class="btn btn-info" id="gerar">Gerar relatório</button>
                <button type="button" class="btn btn-danger disabled" id="excluir">Excluir escala</button>
            </div>
        </div>
    </form>
</div>
<br/>
<br/>