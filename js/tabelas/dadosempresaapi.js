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
                        if(data[i].name && data[i].version){
                            if(data[i].phone == null){
                                data[i].phone = "Sem Telefone";
                            }

                            txt += "<tr><td>"+data[i].name+"</td><td>"+ data[i].phone +"</td><td>"+data[i].version+"</td><td>"+data[i].system+"</td></tr>";
                        }
                    }
                    if(txt != ""){
                        $("#loading").html('');
                        $("#myTable").append(txt);
                        var table = $('#myTable').DataTable(
                            {
                            pageLength: 10,
                            rowReorder: {
                                selector: 'td:nth-child(2)'
                            },
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            "ordering": true,
                            buttons: [
                                {extend: 'excel', title: 'Clientes German Tech'},
                                {extend: 'pdf', title: 'Clientes German Tech'}
                            ],
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
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