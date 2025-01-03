ALTER TABLE `scc`.`Pessoa` 
DROP FOREIGN KEY `fk_Pessoa_Vinculo1`;
ALTER TABLE `scc`.`Pessoa` 
CHANGE COLUMN `Vinculo_idVinculo` `Vinculo_idVinculo` INT(11) NOT NULL DEFAULT 1 ;
ALTER TABLE `scc`.`Pessoa` 
ADD CONSTRAINT `fk_Pessoa_Vinculo1`
  FOREIGN KEY (`Vinculo_idVinculo`)
  REFERENCES `scc`.`Vinculo` (`idVinculo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
ALTER TABLE `scc`.`Veiculo` 
DROP COLUMN `dataCadastro`;

