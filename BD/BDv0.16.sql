ALTER TABLE `scc`.`Sped` 
ADD COLUMN `assunto` VARCHAR(250) NULL AFTER `tipo`,
ADD COLUMN `arquivo` BLOB NULL AFTER `assunto`;

ALTER TABLE `scc`.`Pessoa` 
ADD COLUMN `telefone` VARCHAR(14) NULL AFTER `dataExpiracao`;

ALTER TABLE `scc`.`Sped` 
DROP COLUMN `responsavel`,
ADD COLUMN `Pessoa_idPessoa` INT NULL AFTER `arquivo`,
ADD INDEX `fk_Pessoa_idPessoa_idx` (`Pessoa_idPessoa` ASC) VISIBLE;
;
ALTER TABLE `scc`.`Sped` 
ADD CONSTRAINT `fk_Pessoa_idPessoa`
  FOREIGN KEY (`Pessoa_idPessoa`)
  REFERENCES `scc`.`Pessoa` (`idPessoa`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

