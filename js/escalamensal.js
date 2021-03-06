
    $( document ).ready(function() {
        var date = new Date().toISOString().substr(5, 2);
        $("#mes").val(date).change();
    });
    
    $( function() {
        $( "#lista" ).sortable({
        placeholder: "ui-state-highlight"
        });
        $( "#lista" ).disableSelection();
    });
    $(function () {
        $.getJSON('../utilsPHP/searchusers.php').done(function(response){
            $('#usuariosEscala').flexdatalist({
                minLength: 1,
                searchIn: 'nome',
                data: response,
                noResultsText: 'Sem resultados para "{keyword}"',
            })
        });
    });

    $("#adc").on("click", function(){
        adcusuario();
    });

    $( "#usuariosEscala" ).on( "keydown", function(event) {
      if(event.which == 13){ 
        adcusuario();
        $("#usuariosEscala").val("");
        return false;
      }
    });
    
    function adcusuario(){
        var usuario = $("#usuariosEscala").val();
        var hash = '"'+hex_md5(usuario)+'"';
        if(usuario == "" || usuario == null){
            return notificationWarning("Alerta","Nenhum usuário selecionado");
        }else{
            $( "#lista" ).append("<a href='#' class='list-group-item' id="+hash+">"+usuario+"<button class='btn btn-xs float-right' onclick='remover("+hash+")'><i class='fas fa-times'></i></button></a>");
            $("#usuariosEscala").val("");
        }
    }

    function remover(id){
    $("#"+id).remove();
    }

    $("#gerar").on("click", function(){
        progressReport("Gerando relatório de escala mensal");
        var users = [];
        var mes = $("#mes").val();
        
        $( "#lista" ).each(function() {
            $(this).find("a").each(function() {
                users.push($( this ).html());
            });
        });
        
        if (users == undefined || users.length == 0) {
            notificationWarning("Alerta","Nenhum usuário selecionado");
            toastr.clear();
            return;
        }

        var data = [];
        data.push({name: 'mes', value: mes});
        $.ajax({
            type: "POST",
            url: "../utilsPHP/gerarPDFescala.php",
            data:data,
            success: function(data){
                if(data == 'null'){
                    notificationWarning("Alerta","Nenhum usuário selecionado");
                    toastr.clear();
                    return;
                }
                window.location = '../utilsPHP/downloadpdf.php';
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

        if (users == undefined || users.length == 0) {
            return notificationWarning("Alerta","Nenhum usuário selecionado");
        }
        
        var data = [];
        data.push({name: 'usuarios', value: users});
        data.push({name: 'mes', value: mes});

        $.ajax({
            type: "POST",
            url: "../utilsPHP/escalamensal.php",
            data: data,
            success: function(data){
                getUsuarios();
                notificationSuccess("Registro cadastrado","Escala salva com sucesso");
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
            url: "../deletes/excluiEscala.php",
            data:data,
            success: function(data){
                data = data.trim();
                if(data == 'success'){
                    getUsuarios();
                    notificationSuccess("Registro exluído","Escala excluída com sucesso!");
                }else{
                    notificationError("Erro ao excluir:", data);
                }
            }
        });
    });

    function getUsuarios() {
        var mes = $("#mes").val();
        $("#lista").html('');
        $.getJSON(
        '../utilsPHP/getusermes.php',
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
                    var hash = '"'+hex_md5(usuario)+'"';
                    $( "#lista" ).append("<a href='#' class='list-group-item' id="+hash+">"+usuario+"<button class='btn btn-xs float-right' onclick='remover("+hash+")'><i class='fas fa-times'></i></button></a>");
                });
            }
        }); 
    }