CREATE TABLE IF NOT EXISTS `scc`.`Providencia` (
  `idProvidencia` INT NOT NULL AUTO_INCREMENT,
  `providencia` VARCHAR(2500) NULL,
  `Material_idMaterial` INT NOT NULL,
  PRIMARY KEY (`idProvidencia`),
  INDEX `fk_Providencia_Material1_idx` (`Material_idMaterial` ASC),
  CONSTRAINT `fk_Providencia_Material1`
    FOREIGN KEY (`Material_idMaterial`)
    REFERENCES `scc`.`Material` (`idMaterial`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO Situacao(situacao) VALUES('Missão');

ALTER TABLE `scc`.`Material` 
ADD COLUMN `secaoResponsavel` VARCHAR(25) NULL AFTER `Classe_idClasse`;

