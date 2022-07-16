ALTER TABLE `scc`.`Combustivel` 
CHANGE COLUMN `ctc01-celula1-valor` `ctc01-celula1-valor` DECIMAL(10,1) NULL DEFAULT 0.0000 ,
CHANGE COLUMN `ctc01-celula2-valor` `ctc01-celula2-valor` DECIMAL(10,1) NULL DEFAULT 0.0 ,
CHANGE COLUMN `ctc01-celula3-valor` `ctc01-celula3-valor` DECIMAL(10,1) NULL DEFAULT 0.0 ,
CHANGE COLUMN `ctc04-celula1-valor` `ctc04-celula1-valor` DECIMAL(10,1) NULL DEFAULT 0.0 ,
CHANGE COLUMN `ctc04-celula2-valor` `ctc04-celula2-valor` DECIMAL(10,1) NULL DEFAULT 0.0 ,
CHANGE COLUMN `ctc04-celula3-valor` `ctc04-celula3-valor` DECIMAL(10,1) NULL DEFAULT 0.0 ,
CHANGE COLUMN `diesel` `diesel` DECIMAL(10,1) NULL DEFAULT 0.0 ,
CHANGE COLUMN `gasolina` `gasolina` DECIMAL(10,1) NULL DEFAULT 0.0 ;
UPDATE Material SET item = UPPER(item);
UPDATE Material SET modelo = UPPER(modelo);
INSERT INTO `scc`.`Secao` (`secao`) VALUES ('FS');
CREATE TABLE IF NOT EXISTS `scc`.`Baixado` (
  `idBaixado` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `situacao` VARCHAR(70) NULL,
  `turma` INT NULL,
  `cid` VARCHAR(25) NULL,
  `amparo` VARCHAR(70) NULL,
  `dataAtualizacao` DATE NULL,
  PRIMARY KEY (`idBaixado`))
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `scc`.`Covid` (
  `idCovid` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `situacao` VARCHAR(70) NULL,
  `dataAtualizacao` DATE NULL,
  `Posto_idPosto` INT NOT NULL,
  PRIMARY KEY (`idCovid`),
  INDEX `fk_Covid_Posto1_idx` (`Posto_idPosto` ASC),
  CONSTRAINT `fk_Covid_Posto1`
    FOREIGN KEY (`Posto_idPosto`)
    REFERENCES `scc`.`Posto` (`idPosto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
INSERT INTO Secao(secao) VALUES("Comando");
INSERT INTO Secao(secao) VALUES("S2");
UPDATE `scc`.`Secao` SET `secao` = 'Juridico' WHERE (`secao` = 'Jurídico');

