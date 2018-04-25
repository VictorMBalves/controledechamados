
function callApi(empresa) {         
    var telefone = $("input[name='telefone']");
    var versao = $("input[name='versao']");
    var sistema = $("input[name='sistema']");
    var bloqueado = false;
    var notafiscal= false;
    var notafiscalconsumidor = false;
    var conhecimentotrasporte = false;
    var manifestoeletronico = false;
    var notafiscalservico = false;
    var consultabloqueio = false;
    var cupomfiscaleletronicosat = false;
    var emissordocumentosfiscaiseletronicos = false;
    var empresa = $('#skills').val();

    versao.val('');
    sistema.val('');

    $.getJSON(
            '../utilsPHP/callAPI.php', {
                empresa: empresa,
            }
        )
        .done(function(data) {
                bloqueado = data.is_blocked;
                if(data.phone == null){
                    callBanco(empresa);
                }else{
                    telefone.val(data.phone);
                }
                versao.val(data.version);
                sistema.val(data.system);
                notafiscal = data.nota_fiscal;
                notafiscalconsumidor = data.nota_fiscal_consumidor;
                conhecimentotrasporte = data.conhecimento_trasporte;
                manifestoeletronico = data.manifesto_eletronico;
                notafiscalservico = data.nota_fiscal_servico;
                consultabloqueio = data.consulta_bloqueio;
                cupomfiscaleletronicosat = data.cupom_fiscal_eletronico_sat;
                emissordocumentosfiscaiseletronicos = data.emissor_documentos_fiscais_eletronicos;
                if(emissordocumentosfiscaiseletronicos == true){
                    sistema.val('GermanTech Emissor');
                }
                    //Verifica o bloqueio do sistema
                $.get('../utilsPHP/verificabloqueio.php?bloqueio=' + bloqueado, function(bl) {
                    $('#resultado').html(bl);
                });
                if(document.getElementById('verModulo') != null){
                    document.getElementById('verModulo').disabled = false;
                }
                $.ajax({
                    type: "POST",
                    url: "../utilsPHP/visualizaModulo.php",
                    data: {
                    nf:notafiscal,
                    nfc:notafiscalconsumidor,
                    cte:conhecimentotrasporte,
                    mdf:manifestoeletronico,
                    nfs:notafiscalservico,
                    conbloq:consultabloqueio,
                    sat:cupomfiscaleletronicosat,
                    emissor:emissordocumentosfiscaiseletronicos,
                    empresa:empresa,
                    sistema:data.system,
                    versao:data.version    
                    },
                    success: function(mod) {
                    $('#modulos').html(mod);
                    },
                    error: function(jqXhr, textStatus, errorThrown){
                    console.log(errorThrown);
                }
                });
                if(data.version == null || data.system == null){
                    $("#infoLoad").addClass("hidden");
                    $("#alertLoad").removeClass("hidden");
                }else{
                    $("#infoLoad").addClass("hidden");
                    $("#successLoad").removeClass("hidden");
                }
        }).error(function(data){
                $("#infoLoad").addClass("hidden");
                $("#erroLoad").removeClass("hidden");
                callBanco(empresa);
        });
}
 function callBanco(empresa) {
    var $telefone = $("input[name='telefone']");
    var $celular;
    var $backup = $("input[name='backup']");
    var select = document.getElementById('backup');
    var empresa = $('#skills').val();

        $.getJSON(
        '../utilsPHP/gettelefone.php',
        { empresa: empresa },
        function( json )
        {
            if (json.backup == 0){
            $(select).val("0");
            }else{
            $(select).val("1");
            }
            if (json.telefone == "(000)0000-0000") {
                $telefone.val(json.celular);
              } else {
                $telefone.val(json.telefone);
              }
        }); 
}

$(document).ready(function(){$("input[name='empresa']").blur(function(){
    $("#alertLoad").addClass("hidden");
    $("#successLoad").addClass("hidden");
    $("#erroLoad").addClass("hidden");
    $("#infoLoad").removeClass("hidden");
    callApi();
    callBanco();
    });
});
$(document).ready(function(){$("button[name='verModulos']").click(function(){
    callApi();
    });
});
$(document).ready(function(){$("input[name='cnpj']").blur(function(){
    callApi();
    });
});



