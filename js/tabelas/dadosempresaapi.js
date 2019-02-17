$(document).ready(function() {
    $("#loading").html('<img src="../imagem/loading.gif">');
    
    $.ajax({
        type: 'POST',
        url: '../utilsPHP/callTodasEmpresas.php',
        dataType:"json", //to parse string into JSON object,
        success: function(data){ 
            if(data){
                var len = data.length;
                var txt = "";
                if(len > 0){
                    for(var i=0;i<len;i++){
                        if(data[i].name){
                            if(data[i].phone == null){
                                data[i].phone = "Sem Telefone";
                            }
                            if(data[i].version == null){
                                data[i].version = "Sem dados de versão";
                            }
                            if(data[i].system == null){
                                data[i].system = "Sem dados de sistema";
                            }
                            if(data[i].is_blocked) 
                                txt += '<tr class="danger">';
                            else
                                txt += '<tr>';    
                            txt += "<td>"+data[i].name+"</td><td>"+ data[i].phone +"</td><td>"+data[i].version+"</td><td>"+data[i].system+"</td></tr>";
                        }
                    }
                    if(txt != ""){
                        $("#loading").html('');
                        $("#myTable").append(txt);
                        $('#myTable').DataTable(
                            {
                                pageLength: 10,
                                responsive: isCelular(),
                                "language": {
                                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
                                },
                                "initComplete": function(settings, json) {
                                    $('[data-toggle="tooltip"]').tooltip()
                                  }
                        }
                        );
                    }
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
    return false;//suppress natural form submission
});