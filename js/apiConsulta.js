
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
            'callAPI.php', {
                empresa: empresa,
            }
        )
        .done(function(data) {
            
            bloqueado = data.is_blocked;
            telefone.val(data.phone);
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
            $.get('verificabloqueio.php?bloqueio=' + bloqueado, function(bl) {
                $('#resultado').html(bl);
            });
            
            document.getElementById('verModulo').disabled = false;
            
            $.ajax({
                type: "POST",
                url: "visualizaModulo.php",
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

            //if ($bloqueado == true) {
            //   if (!document.getElementById('salvar').disabled) document.getElementById('salvar').disabled = true;
            //} else if ($bloqueado == false) {
            //if (document.getElementById('salvar').disabled) document.getElementById('salvar').disabled = false;
            //}
        });
}
 function callBanco(empresa) {
    var $backup = $("input[name='backup']");
    var select = document.getElementById('backup');
    var empresa = $('#skills').val();

        $.getJSON(
        'gettelefone.php',
        { empresa: empresa },
        function( json )
        {
            if (json.backup == 0){
            $(select).val("0");
            }else{
            $(select).val("1");
            }
        }); 
}

$(document).ready(function(){$("input[name='empresa']").blur(function(){
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


