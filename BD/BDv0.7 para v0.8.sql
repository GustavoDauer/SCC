DROP TABLE NotaCredito;
DROP TABLE Item;
DROP TABLE Requisicao;

CREATE TABLE IF NOT EXISTS `scc`.`NotaCredito` (
  `idNotaCredito` INT NOT NULL AUTO_INCREMENT,
  `dataNc` DATE NULL,
  `nc` VARCHAR(25) NOT NULL,
  `pi` VARCHAR(25) NULL,
  `valor` DECIMAL(10,2) NULL,
  `gestorNc` VARCHAR(70) NULL,
  `ptres` VARCHAR(25) NULL,
  `fonte` VARCHAR(25) NULL,
  `ug` VARCHAR(7) NULL,
  PRIMARY KEY (`idNotaCredito`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `scc`.`Requisicao` (
  `idRequisicao` INT NOT NULL AUTO_INCREMENT,
  `dataRequisicao` DATE NULL,
  `NotaCredito_idNotaCredito` INT NULL,
  `om` VARCHAR(250) NULL,
  `Secao_idSecao` INT NULL DEFAULT NULL,
  `descricao` VARCHAR(500) NULL,
  `pe` VARCHAR(25) NULL,
  `ug` INT NULL,
  `ompe` VARCHAR(45) NULL,
  `empresa` VARCHAR(500) NULL,
  `cnpj` VARCHAR(25) NULL,
  `contato` VARCHAR(520) NULL,
  `ne` VARCHAR(50) NULL,
  `observacaoAquisicoes` VARCHAR(1000) NULL,
  `dataEnvioNE` DATE NULL,
  `valorNE` DECIMAL(10,2) NULL,
  `dataAprovacao` DATE NULL,
  `observacaoConformidade` VARCHAR(1000) NULL,
  `parecer` TINYINT(1) NULL,
  `dataEntregaMaterial` DATE NULL,
  `numeroDiex` VARCHAR(100) NULL,
  `processoAdministrativo` VARCHAR(250) NULL,
  `numeroOficio` VARCHAR(100) NULL,
  `boletim` VARCHAR(250) NULL,
  `dataUltimaLiquidacao` DATE NULL,
  `valorLiquidar` VARCHAR(25) NULL,
  PRIMARY KEY (`idRequisicao`),
  INDEX `fk_Requisicao_Secao1_idx` (`Secao_idSecao` ASC),
  INDEX `fk_Requisicao_NotaCredito1_idx` (`NotaCredito_idNotaCredito` ASC),
  CONSTRAINT `fk_Requisicao_Secao1`
    FOREIGN KEY (`Secao_idSecao`)
    REFERENCES `scc`.`Secao` (`idSecao`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_NotaCredito1`
    FOREIGN KEY (`NotaCredito_idNotaCredito`)
    REFERENCES `scc`.`NotaCredito` (`idNotaCredito`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `scc`.`Item` (
  `idItem` INT NOT NULL AUTO_INCREMENT,
  `numeroItem` VARCHAR(7) NULL,
  `descricao` VARCHAR(500) NULL,
  `quantidade` INT NULL,
  `valor` DECIMAL(10,2) NULL,
  `Requisicao_idRequisicao` INT NULL,
  PRIMARY KEY (`idItem`),
  INDEX `fk_Item_Requisicao1_idx` (`Requisicao_idRequisicao` ASC),
  CONSTRAINT `fk_Item_Requisicao1`
    FOREIGN KEY (`Requisicao_idRequisicao`)
    REFERENCES `scc`.`Requisicao` (`idRequisicao`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;

INSERT INTO Secao(secao) VALUES('SecInfo');



