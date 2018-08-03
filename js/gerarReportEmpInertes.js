$(document).ready(function() {
    $("#todos").click();
}); 
$("#gerarReport").on("click", function(){
    $('#modalReport').modal({backdrop: 'static', keyboard: false}) 
    $("#modalReport").modal('show');
})
$("#modal-retornar").on("click", function(){
    $("#modalReport").modal('hide');
})

$('#todos').click(function() {
    $("#ativo").prop( 'checked', $("#todos").is( ":checked" ) )
    $("#bloqueado").prop( 'checked', $("#todos").is( ":checked" ) )
    $("#teste").prop( 'checked', $("#todos").is( ":checked" ) )
    // $("#desistente").prop( 'checked', $("#todos").is( ":checked" ) )
});

$( "input[type=checkbox]" ).click(function() {
    if($("#ativo").is( ":checked" ) && $("#bloqueado").is( ":checked" ) && $("#teste").is( ":checked" ))// && $("#desistente").is( ":checked" ))
        $("#todos").prop( 'checked', true )
    else
        $("#todos").prop( 'checked', false )
});

$("#modal-salvar").click(function(){
    if(!$("#ativo").is( ":checked" ) && !$("#bloqueado").is( ":checked" ) && $("#teste").is( ":checked" )){// && !$("#desistente").is( ":checked" )){
        notificationWarningOne("Informe pelo menos uma situação");
        return;
    }
    versao = $('#versaoReport').val();
    regex = /[0-9]{1,2}([.][0-9]{1,2})/;
    if(!regex.test(versao)){
        $("#loading").html('');
        notificationWarningOne("Formato de versão invalida");
        return;
    }
    var data = [];

    var situacao;
    if($("#ativo").is( ":checked" ))
        situacao = 'ativo,';
    if($("#bloqueado").is( ":checked" ))
        situacao != null ? situacao += 'bloqueado,' : situacao = 'bloqueado,';
    if($("#teste").is( ":checked" ))
        situacao != null ? situacao += 'teste' : situacao = 'teste';
    // if($("#desistente").is( ":checked" ))
    //     situacao += 'desistente';
    bloqueiaCampos()

    data.push({name: 'versao', value: versao});
    data.push({name: 'situacao', value: situacao})
    data.push({name: 'order', value:$("#ordenacao").val()})
    data.push({name: 'group', value:$("#agrupamento").val()})
    data.push({name: 'days_dont_access', value:$("#diasSemAcessar").val()})

    // progressReport("Gerando relatório");
    $.ajax({
        type: "POST",
        url: "../utilsPHP/geraReportEmpInerte.php",
        data:data,
        success: function(data){
            if(data == 'null'){
                notificationWarning("Alerta","Erro ao gerar relatório");
                toastr.clear();
                return;
            }
            bloqueiaCampos()
            $("#modal-salvar").html('Gerar')
            $("#modalReport").modal('hide')
            window.location = '../utilsPHP/downloadpdf.php';
        },error: function(data){
            notificationWarning("Alerta","Erro ao gerar relatório");
            bloqueiaCampos()
            $("#modalReport").modal('hide')
            $("#modal-salvar").html('Gerar')
        }
    });
    return false;
});

function bloqueiaCampos(){
    $("#modal-salvar").toggleClass('disabled')
    $("#modal-retornar").toggleClass('disabled')
    $("#todos").toggleClass('disabled').prop('disabled', function(i, v) { return !v; });
    $("#ativo").toggleClass('disabled').prop('disabled', function(i, v) { return !v; });
    $("#bloqueado").toggleClass('disabled').prop('disabled', function(i, v) { return !v; });
    $('#versaoReport').toggleClass('disabled').prop('disabled', function(i, v) { return !v; });
    $("#ordenacao").toggleClass('disabled').prop('disabled', function(i, v) { return !v; });
    $("#agrupamento").toggleClass('disabled').prop('disabled', function(i, v) { return !v; });
    // $("#diasSemAcessar").toggleClass('disabled').prop('disabled', function(i, v) { return !v; });
    $("#modal-salvar").html('Gerando relatório <img src="../imagem/ajax-loader.gif">')
}