# Germantech Chamados
Sistema de atendimento Help Desk utilizado pela German Tech sistemas.

#Deploy em produção
php automate.phar deploy production master
php automate.phar deploy --ambiente --repository


ALTER TABLE `chamadoespera` ADD `dataagendamento` TIMESTAMP NULL ;