ALTER TABLE `scc`.`Material` 
ADD COLUMN `secaoResponsavel` VARCHAR(250) NULL AFTER `motivoDetalhado`;

CREATE TABLE IF NOT EXISTS `scc`.`Visitante` (
  `idVisitante` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `cpf` VARCHAR(16) NULL,
  `telefone` VARCHAR(14) NULL,
  `destino` VARCHAR(250) NULL,
  `dataEntrada` DATETIME NULL,
  `dataSaida` DATETIME NULL,
  PRIMARY KEY (`idVisitante`))
ENGINE = InnoDB;

insert into Secao(secao) values('RP');
