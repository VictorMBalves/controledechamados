
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