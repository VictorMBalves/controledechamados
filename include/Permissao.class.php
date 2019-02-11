<?php
    class Permissao {

        function __construct($dbConnection) {
            $this->dbConnection = $dbConnection;
        }

        public $permitirLancarCadastro = true,
        
        $permitirLancarAviso = true,
    
        $dbConnection;


       //
       public function load_by_id($id) {
            $stmt = $this->dbConnection->prepare('SELECT * FROM permissao WHERE id=?');
            $stmt->execute([$id]);
            return $stmt->fetchObject(__CLASS__);
        }
    }
?>