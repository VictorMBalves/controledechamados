<?php
  /**
   * função que devolve em formato JSON os dados do cliente
   */
  function retorna( $nome, $db )
  {
    $sql = "SELECT `telefone`, `celular`,`backup`
      FROM `empresa` WHERE `nome` = '{$nome}' ";

    $query = $db->query( $sql );

    $arr;
    if( $query->num_rows )
    {
      while( $dados = $query->fetch_object() )
      {
        $arr['telefone'] = $dados->telefone;
        $arr['celular'] = $dados->celular;
        $arr['backup'] = $dados->backup;
      }
    }
    return json_encode( $arr );
  }

/* só se for enviado o parâmetro, que devolve os dados */
if( isset($_GET['empresa']) )
{
  $db = new mysqli('localhost', 'root', 'ledZeppelin', 'chamados');
  echo retorna($_GET['empresa'], $db );
}