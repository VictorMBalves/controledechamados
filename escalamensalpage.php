<br/>
<div class="alert alert-success" role="alert">
        <center>Escala mensal Sobreaviso</center>
    </div>
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
<script src="js/md5.js"></script>
<script type="text/javascript">

    $( function() {
        $( "#lista" ).sortable({
        placeholder: "ui-state-highlight"
        });
        $( "#lista" ).disableSelection();
    });

    function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
        window.location.assign("chamadoespera.php");
    }
    $(function() {
        $("#usuarios").autocomplete({
            source: 'searchusers.php'
        });
    });

    $("#adc").on("click", function(){
        adcusuario();
    });

    $( "#usuarios" ).on( "keydown", function(event) {
      if(event.which == 13){ 
        adcusuario();
        $("#usuarios").val("");
        return false;
      }
    });
    
    function adcusuario(){
        var usuario = $("#usuarios").val();
        var hash = '"'+md5(usuario)+'"';
        if(usuario == "" || usuario == null){
            alert("Nenhum usuário selecionado");
            return;
        }else{
            $( "#lista" ).append("<a href='#' class='list-group-item' id="+hash+">"+usuario+"<button class='btn btn-xs glyphicon glyphicon-remove pull-right' onclick='remover("+hash+")'></button></a>");
            $("#usuarios").val("");
        }
    }

    function remover(id){
    $("#"+id).remove();
    }

    $("#gerar").on("click", function(){
        var users = [];
        var mes = $("#mes").val();
        
        $( "#lista" ).each(function() {
            $(this).find("a").each(function() {
                users.push($( this ).html());
            });
        });
        
        if (users === undefined || users.length == 0) {
            return alert("Nenhum usuário selecionado");
        }

        var data = [];
        data.push({name: 'mes', value: mes});
        $.ajax({
            type: "POST",
            url: "gerarPDFescala.php",
            data:data,
            success: function(data){
                if(data == 'null'){
                    alert("Nenhum usuário salvo para escala mensal!");
                    return;
                }
                window.location = 'downloadpdf.php';
            }
        });
    });

    $("#salvar").on("click", function(){
        var users = [];
        var mes = $("#mes").val();

        $( "#lista" ).each(function() {
            $(this).find("a").each(function() {
                users.push($( this ).html());
            });
        });

        if (users === undefined || users.length == 0) {
            return alert("Nenhum usuário selecionado");
        }
        
        var data = [];
        data.push({name: 'usuarios', value: users});
        data.push({name: 'mes', value: mes});

        $.ajax({
            type: "POST",
            url: "escalamensal.php",
            data:data,
            success: function(data){
                getUsuarios();
                alert("Escala salva com sucesso");
            }
        });
    });

     $("#excluir").on("click", function(){
       if($( "#excluir" ).hasClass( "disabled" )){
           return;
       }
        var mes = $("#mes").val();
        var data = [];
        data.push({name: 'mes', value: mes});
        $.ajax({
            type: "POST",
            url: "excluirescala.php",
            data:data,
            success: function(data){
                data = data.trim();
                if(data == 'success'){
                    getUsuarios();
                    alert("Escala excluída com sucesso!");
                }else{
                    alert("Erro ao excluir");
                }
            }
        });
    });

    function getUsuarios() {
        var mes = $("#mes").val();
        $("#lista").html('');
        $.getJSON(
        'getusermes.php',
        { mes: mes },
        function( json )
        {
            if (json == null) {
                $("#lista").html('');
                $("#excluir").addClass("disabled");
            }else{
                $("#excluir").removeClass("disabled");
                jQuery.each(json, function(i, val) {
                    usuario = val;
                    var hash = '"'+md5(usuario)+'"';
                    $( "#lista" ).append("<a href='#' class='list-group-item' id="+hash+">"+usuario+"<button class='btn btn-xs glyphicon glyphicon-remove pull-right' onclick='remover("+hash+")'></button></a>");
                });
            }
        }); 
    }
</script>