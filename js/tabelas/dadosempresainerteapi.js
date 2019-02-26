$(document).ready(function() {
    $("#loading").html('<img src="../imagem/loading.gif">');
    loadTable();
    $("#liRelatorio").addClass("active")
}); 


$("#versao").keypress(function (e) {
    if (e.which < 46 || e.which > 57)
        return false;
});

$("#buscar").on("click", function(){
    $("#loading").html('<img src="../imagem/loading.gif">');
    versao = $('#versao').val();
    regex = /[0-9]{1,2}([.][0-9]{1,2})/;
    if(!regex.test(versao)){
        $("#loading").html('');
        notificationWarningOne("Formato de versão invalida");
        return;
    }
    var data = [];
    data.push({name: 'versao', value: versao});

    $.ajax({
        type: 'POST',
        url: '../utilsPHP/callEmpresasInertes.php',
        data: data,
        dataType:"json",
        success: function(data){ 
            $('#tabela').DataTable().destroy();
            $('#tbody').empty();
            if(data){
                buildTable(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
    return false;
});

$("#refresh").on("click", function(){
    $("#versao").val("");
    $("#loading").html('<img src="../imagem/loading.gif">');
    $('#tabela').DataTable().destroy();
    $('#tbody').empty();
    loadTable();
    return false;
});

function loadTable(){
    $.ajax({
        type: 'POST',
        url: '../utilsPHP/callEmpresasInertes.php',
        dataType:"json",
        success: function(data){ 
            if(data){
                buildTable(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function buildTable(data){
    var len = data.length;
    var txt = "";
    var semFone = 0;
    var posicao = 1;
    var situacao = $("#situacao").val();
    if(len > 0){
        for(var i=0;i<len;i++){
            if(data[i].count_days_dont_access == null){
                data[i].count_days_dont_access = 0;
            }
            if($("#ignorePhoneNull").is(':checked')){
                if(data[i].phone == "Sem Telefone"){
                    semFone++;
                    continue;
                }
            }
            if($("#ignoreBlocked").is(':checked')){
                if(data[i].is_blocked){
                    continue;
                }
            }

            if(situacao != "todas"){
                if(situacao == "Bloqueada" && !data[i].is_blocked){
                    continue;
                }if(situacao == "Ativo" && data[i].is_blocked){
                    continue;
                }
            }
            if(data[i].name){
                if(data[i].version == null){
                    data[i].version = "Sem dados de versão";
                }
                if(data[i].system == null){
                    data[i].system = "Sem dados de sistema";
                }
                txt += '<tr>';    
                txt += "<td>"+ (posicao++) +"</td>";
                txt += "<td>"+data[i].name+"</td>";
                txt += "<td>"+data[i].cnpj+"</td>";
                txt += "<td>"+data[i].city+"</td>";
                txt += "<td>"+data[i].state+"</td>";

                if(data[i].is_blocked)
                    txt += "<td>Bloqueada</td>"
                else if(data[i].test_system)
                    txt += "<td>Em teste</td>"
                else
                    txt += "<td>Ativo</td>"

                txt += "<td>"+data[i].responsible+"</td>";
                txt += "<td>"+data[i].phone+"</td>";
                txt += "<td>"+data[i].phone2+"</td>";
                txt += "<td>"+data[i].celular+"</td>";
                txt += "<td>"+data[i].version+"</td>";
                txt += "<td>"+data[i].system+"</td>";
                txt += "<td>"+data[i].payment+"</td>";
                txt += "<td>"+Number(data[i].count_days_dont_access)+"</td>";
                txt += "</tr>";
            }
        }
        if(semFone > 0){
            $("#resultadobusca").html("<p class='text-warning'><small>"+semFone+" empresas ignoradas</small></p>")
        }else{
            $("#resultadobusca").html("")
        }
        if(txt != ""){
            $("#loading").html('');
            $("#tabela").append(txt);
            $('#tabela').DataTable({
                pageLength: 10,
                responsive: isCelular(),
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
                },
                "initComplete": function(settings, json) {
                    $('[data-toggle="tooltip"]').tooltip()
                  }
            });
        }else{
            $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhum registro encontrado com os filtros informados</div>');
        }
    }
}