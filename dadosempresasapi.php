<!Doctype html>
<html>
  <head> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <title>Controle de Chamados
    </title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="datatables/datatables.min.css" rel="stylesheet">
    <link href="datatables/responsive.dataTables.min.css" rel="stylesheet">
    <link href="datatables/rowReorder.dataTables.min.css" rel="stylesheet">
    <style>
        /* .html5buttons, .dataTables_length, .dataTables_info, .dataTables_filter {
            padding: 5px;
            float:none;
            right: 0px;
            width: 200px;
        } */
        </style>
</head>
  <body>
<?php
  header("Content-type: text/html; charset=utf-8");
  if (!isset($_SESSION)) {
      session_start();
  }
  if (!isset($_SESSION['UsuarioID'])) {
      session_destroy();
      header("Location: index.php");
      exit;
  }
  $email = md5($_SESSION['Email']);
  include('include/menu.php');
?>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

<div class="container-fluid">
    
    <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <!-- <div class="html5buttons text-right"></div> -->
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Telefone</th>
                <th>Versão</th>
                <th>Sistema</th>
            </tr>
            <tbody>
                </tbody>
            </thead>
        </table>
    <div class="col-sm-12 text-center" id="loading"></div>
</div>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="js/links.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="datatables/datatables.min.js"></script>
    <script src="datatables/responsive.min.js"></script>
    <script src="datatables/rowReorder.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>      
    <script>  
        $(document).ready(function() {
            $("#loading").html('<img src="imagem/loading.gif">');
            
            $.ajax({
                type: 'POST',
                url: 'callTodasEmpresas.php',
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
         


        
    </script>
</body>
</html> 
