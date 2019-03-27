# Germantech Chamados
Sistema de atendimento Help Desk utilizado pela German Tech sistemas.

#Deploy em produção
php automate.phar deploy production master
php automate.phar deploy --ambiente --repository


ALTER TABLE `chamadoespera` ADD `dataagendamento` TIMESTAMP NULL ;
ALTER TABLE `chamado` ADD `usuario_id` INT NOT NULL AFTER `enderecado`;
ALTER TABLE `chamadoespera` ADD `usuario_id` INT NOT NULL AFTER `enderecado`
ALTER TABLE `plantao` ADD `usuario_id` INT NOT NULL
ALTER TABLE `historicochamado` ADD `usuario_id` INT NOT NULL
ALTER TABLE `usuarios` ADD `enviarEmail` BOOLEAN NOT NULL DEFAULT TRUE AFTER `cadastro`;
ALTER TABLE `chamadoespera` ADD `emailEnviado` BOOLEAN NULL DEFAULT FALSE AFTER `dataagendamento`;
ALTER TABLE `chamado` ADD `cnpj` VARCHAR(50) NULL AFTER `empresa`;
ALTER TABLE `chamadoespera` ADD `cnpj` VARCHAR(50) NULL AFTER `empresa`;
ALTER TABLE `plantao` ADD `cnpj` VARCHAR(50) NULL AFTER `empresa`;

UPDATE chamadoespera cha
INNER JOIN usuarios usu ON usu.nome = cha.usuario
SET cha.usuario_id = usu.id

UPDATE chamado cha
INNER JOIN usuarios usu ON usu.nome = cha.usuario
SET cha.usuario_id = usu.id

UPDATE plantao cha
INNER JOIN usuarios usu ON usu.nome = cha.usuario
SET cha.usuario_id = usu.id

UPDATE historicochamado cha
INNER JOIN usuarios usu ON usu.nome = cha.usuario
SET cha.usuario_id = usu.id

UPDATE chamado cha 
INNER JOIN empresa emp ON emp.nome = cha.empresa 
SET cha.cnpj = emp.cnpj

UPDATE plantao cha 
INNER JOIN empresa emp ON emp.nome = cha.empresa 
SET cha.cnpj = emp.cnpj

UPDATE chamadoespera cha 
INNER JOIN empresa emp ON emp.nome = cha.empresa 
SET cha.cnpj = emp.cnpj

ALTER TABLE `chamadoespera` ADD `datacadastro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE `categoria` ( `id` INT(10) NOT NULL , `categoria` VARCHAR(255) NOT NULL , `descricao` VARCHAR(255) NOT NULL , `datacadastro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

ALTER TABLE `plantao` CHANGE `categoria` `categoria` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL;


util pra debugar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);