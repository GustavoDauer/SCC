DROP TABLE IF EXISTS `scc`.`Baixado` ;

CREATE TABLE IF NOT EXISTS `scc`.`Baixado` (
  `idBaixado` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(250) NULL,
  `situacao` VARCHAR(250) NULL,
  `turma` INT NULL,
  `cia` VARCHAR(25) NULL,
  `amparo` VARCHAR(2500) NULL,
  `dataAtualizacao` DATE NULL,
  `Posto_idPosto` INT NOT NULL,
  `diagnostico` VARCHAR(2500) NULL,
  `bi` VARCHAR(520) NULL,
  `bar` VARCHAR(520) NULL,
  `dispensa` VARCHAR(2500) NULL,
  `acao` VARCHAR(2500) NULL,
  PRIMARY KEY (`idBaixado`),
  INDEX `fk_Baixado_Posto1_idx` (`Posto_idPosto` ASC) ,
  CONSTRAINT `fk_Baixado_Posto1`
    FOREIGN KEY (`Posto_idPosto`)
    REFERENCES `scc`.`Posto` (`idPosto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
