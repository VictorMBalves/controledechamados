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
        $db_host = "localhost";
        $db_nome = "chamados";
        $db_usuario = "root";
        $db_senha = "ledZeppelin";
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