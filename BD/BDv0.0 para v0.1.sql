ALTER TABLE `scc`.`Processo` 
ADD COLUMN `dataPrazo` DATE NULL AFTER `prorrogacaoPrazo`;

DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '1');
DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '2');
DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '3');
DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '4');
DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '5');
DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '7');
DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '8');
DELETE FROM `scc`.`Classe` WHERE (`idClasse` = '10');

