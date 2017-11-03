<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="utf-8" />
            <link rel="shortcut icon" href="imagem/favicon.ico" />
            <title>Controle de Chamados German Tech</title>
            <script src='js/jquery.min.js'></script>
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/links.js" ></script>
            <style>
                /*table, tr, td, th{
                    border:1px solid black;
                }*/
                .rel{
                    margin-left:15px;
                    margin-right:15px;   
                }
                th, td{
                  padding:5px;
                  border: 0.5px solid black;
                  border-left:0px;
                  border-right:0px;  
                }
                th{
                    background-color:#eee;
                }
                table{
                    width:100%;
                }
                .foot{
                    width:500px;
                }
                .assin{
                    float:right;
                    margin-right:150px;
                    margin-top:80px;
                    width:400px;
                    weight:150px;
                }
                
            </style>
        </head>
        <body onload="self.print();self.close();">
            <?php
            header("Content-type: text/html; charset=utf-8");
            // A sessão precisa ser iniciada em cada página diferente
            if (!isset($_SESSION)) session_start();
            // Verifica se não há a variável da sessão que identifica o usuário
            if($_SESSION['UsuarioNivel'] == 1) {
            echo'<script>erro()</script>';
            } else {
            if (!isset($_SESSION['UsuarioID'])) {
            // Destrói a sessão por segurança
            session_destroy();
            // Redireciona o visitante de volta pro login
            header("Location: index.php"); exit;
            }}
            $email = md5( $_SESSION['Email']);
               include 'include/dbconf.php';
                    $data1=$_POST['data1'];
                    $data2=$_POST['data2'];
                    $usuario=$_SESSION['UsuarioNome'];

                    $conn->exec('SET CHARACTER SET utf8');   
                    $query = $conn->prepare("SELECT id_plantao, datainicio, date(datainicio), empresa, contato, descsolucao, descproblema, datafinal, data, horainicio, horafim FROM plantao where date(datainicio) BETWEEN '$data1' and '$data2' OR data BETWEEN '$data1' and '$data2' and usuario = '$usuario' ORDER BY id_plantao desc");
                    $query->execute();
                    $resultado = $query->fetchall(); 
            ?>

                <div class="container">
             <div class="row">
                <h1>
            <div class="row">
                Relatório de sobreaviso:
                </h1>
            </div>
            <br>
             </div>
                <div class="text-center">
                   <h4> <p> Relatório referente do período <strong><?php echo $data1?></strong> ao <strong><?php echo $data2 ?></strong> </p></h5>
                    </div>
                 <div class="row">
                    <hr/>
                </div>
            <div class="rel text-ceter">
                
                <table class="table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Empresa</th>
                        <th>Contato</th>
                        <th>Horário ínicio</th>
                        <th>Horário término</th>
                        <th>Desc. Problema</th>
                        <th>Desc. Solução</th>
                    </tr>
                   
                    <tbody>
                        <?php foreach($resultado as $row){ 
                            $horai = substr($row['datainicio'], 11, 8);
                            $horaf = substr($row['datafinal'], 11, 8);
                        
                            echo '<tr>';
                                echo'<td>'.$row['id_plantao'].'</td>';
                                echo'<td>'; if(is_null($row['date(datainicio)'])){ echo $row['data'];}  else{ echo $row['date(datainicio)'];} echo'</td>';
                                echo'<td>'.$row['empresa'].'</td>';
                                echo'<td>'.$row['contato'].'</td>';
                                echo'<td>';if(is_null($row['date(datainicio)'])){ echo $row['horainicio'].':00';}  else{ echo $horai;} echo'</td>';
                                echo'<td>';if(is_null($row['date(datainicio)'])){ echo $row['horafim'].':00';}  else{ echo $horaf;} echo'</td>';
                                echo'<td>'.$row['descproblema'].'</td>';
                                echo'<td>'.$row['descsolucao'].'</td>';
                            echo'</tr>';
                         }?>   
                    </tbody>

                </table>
            </div>
            <div class="row">
                    <hr/>
                </div>
            <div class="footer">
                    <table class="foot">
                    <tr>   
                        <th>Segunda à Sexta Feira: 12:01 às 13:29 e 18:01 às 22:00. Sábados, domingos e feriados: 08:00 às 22:00.</th>
                    </tr>
                    <tr>
                        <td>TOTAL DIARIO SEGUNDA A SEXTA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>05:27:00</strong></td>
                    </tr>
                    <tr>
                        <td>SABÁDO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>14:00:00</strong></td>
                    </tr>
                    <tr>
                        <td>DOMINGO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>14:00:00</strong></td>
                    </tr>
                    <tr>
                        <td>TOTAL SEMANA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>51:14:00</strong></td>
                    </tr>
                    <div class="assin">
                        <hr style="border-color:black;"/>
                        <center><h3><?php echo $_SESSION['UsuarioNome'];?></h3></center>
                    </div>
                    </table>

                    
            </div>

        </body>
    </html>
