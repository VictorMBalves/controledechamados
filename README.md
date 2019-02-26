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