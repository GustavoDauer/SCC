CREATE TABLE IF NOT EXISTS `scc`.`Requisicao` (
  `idRequisicao` INT NOT NULL AUTO_INCREMENT,
  `dataRequisicao` DATE NULL,
  `ne` VARCHAR(25) NULL,
  `nc` VARCHAR(25) NULL,
  `pe` VARCHAR(25) NULL,
  `ug` INT NULL,
  `pi` VARCHAR(25) NULL,
  `empresa` VARCHAR(45) NULL,
  `descricao` VARCHAR(70) NULL,
  `valor` VARCHAR(25) NULL,
  `om` VARCHAR(25) NULL,
  `dataEnvioNE` DATE NULL,
  `valorLiquidar` VARCHAR(25) NULL,
  `secao` VARCHAR(25) NULL,
  `chegadaMaterial` TINYINT(1) NULL DEFAULT 0,
  `numeroDiex` VARCHAR(100) NULL,
  `numeroOficio` VARCHAR(100) NULL,
  `dataEntregaMaterial` DATE NULL,
  `processoAdministrativo` VARCHAR(250) NULL,
  `boletim` VARCHAR(45) NULL,
  `solucaoProcessoAdministrativo` TEXT(5000) NULL,
  PRIMARY KEY (`idRequisicao`))
ENGINE = InnoDB;

insert into Secao(secao) values('S3');
insert into Secao(secao) values('Fiscalizacao');
