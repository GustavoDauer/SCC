ALTER TABLE `scc`.`Sped` 
ADD COLUMN `secaoResponsavel` VARCHAR(25) NULL AFTER `Pessoa_idPessoa`,
ADD COLUMN `secoesEnvolvidas` VARCHAR(250) NULL AFTER `secaoResponsavel`;

ALTER TABLE `scc`.`Sped` 
DROP COLUMN `secoesEnvolvidas`,
DROP COLUMN `secaoResponsavel`;

ALTER TABLE `scc`.`Sped` 
ADD COLUMN `Secao_idSecao` INT(11) NULL AFTER `Pessoa_idPessoa`,
ADD INDEX `fk_Secao_idSecao_idx` (`Secao_idSecao` ASC) VISIBLE;
;
ALTER TABLE `scc`.`Sped` 
ADD CONSTRAINT `fk_Secao_idSecao`
  FOREIGN KEY (`Secao_idSecao`)
  REFERENCES `scc`.`Secao` (`idSecao`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
CREATE TABLE `scc`.`Sped_has_Secao` (
  `Sped_idSped` INT(11) NOT NULL,
  `Secao_idSecao` INT(11) NOT NULL,
  PRIMARY KEY (`Sped_idSped`, `Secao_idSecao`),
  INDEX `fk_Sped_has_Secao_Secao1_idx` (`Secao_idSecao` ASC) VISIBLE,
  CONSTRAINT `fk_Sped_has_Secao_Sped1`
    FOREIGN KEY (`Sped_idSped`)
    REFERENCES `scc`.`Sped` (`idSped`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sped_has_Secao_Secao1`
    FOREIGN KEY (`Secao_idSecao`)
    REFERENCES `scc`.`Secao` (`idSecao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
  

