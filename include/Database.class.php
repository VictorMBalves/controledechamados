<?php
/**
 * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
 * Modo de Usar:
 * require_once './Database.class.php';
 * $db = Database::conexao();
 * @since 1.0.0
 * @author Victor
 */
class Database
{
    protected static $db;

    private function __construct()
    {   
        //$db_host = "192.168.33.10";
        $db_host = "192.168.25.241";
        $db_nome = "chamados";
        $db_usuario = "root";
        $db_senha = "d8hj0ptr";
        //$db_senha = "ledZeppelin";
        $db_driver = "mysql";
        $sistema_titulo = "Controle de chamados";
        $sistema_email = "victormatheusbotassoli@gmail.com";
        
        try
        {
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        }
        catch (PDOException $e)
        {
            mail($sistema_email, "PDOException em $sistema_titulo", $e->getMessage());
            die("Connection Error: " . $e->getMessage());
        }
    }
    public static function conexao()
    {
        if (!self::$db)
        {
            new Database();
        }
        return self::$db;
    }
}

function formatDateDiff($start, $end=null) { 
    if(!($start instanceof DateTime)) { 
        $start = new DateTime($start); 
    } 
    
    if($end === null) { 
        $end = new DateTime(); 
    } 
    
    if(!($end instanceof DateTime)) { 
        $end = new DateTime($start); 
    } 
    
    $interval = $end->diff($start); 
    $doPlural = function($nb,$str){return $nb>1?$str.'':$str;}; // adds plurals 
    
    $format = array(); 
    if($interval->y !== 0) { 
        $format[] = "%y ".$doPlural($interval->y, "Ano"); 
    } 
    if($interval->m !== 0) { 
        $format[] = "%m ".$doPlural($interval->m, "mêses"); 
    } 
    if($interval->d !== 0) { 
        $format[] = "%d ".$doPlural($interval->d, "dia"); 
    } 
    if($interval->h !== 0) { 
        $format[] = "%h ".$doPlural($interval->h, "h"); 
    } 
    if($interval->i !== 0) { 
        $format[] = "%i ".$doPlural($interval->i, "min"); 
    } 
    if($interval->s !== 0) { 
        if(!count($format)) { 
            return "há menos de um minuto"; 
        } else { 
            $format[] = "%s ".$doPlural($interval->s, "s"); 
        } 
    } 
    
    // We use the two biggest parts 
    if(count($format) > 1) { 
        $format = array_shift($format)." e ".array_shift($format); 
    } else { 
        $format = array_pop($format); 
    } 
    
    // Prepend 'since ' or whatever you like 
    return $interval->format($format); 
} 