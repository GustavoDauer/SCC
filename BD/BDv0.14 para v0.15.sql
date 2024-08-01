/*INSERT INTO Secao(secao) VALUES('Identidade');*/
DELETE FROM AuditoriaPessoa;
DELETE FROM AuditoriaVeiculo;
DELETE FROM Veiculo;
DELETE FROM Pessoa;
DELETE FROM Vinculo;
DROP TABLE `scc`.`Veiculo`;
DROP TABLE `scc`.`Pessoa`;
DROP TABLE `scc`.`Vinculo`;
DROP TABLE `scc`.`AuditoriaPessoa`;
DROP TABLE `scc`.`AuditoriaVeiculo`;
CREATE TABLE IF NOT EXISTS `scc`.`Vinculo` (
  `idVinculo` INT NOT NULL AUTO_INCREMENT,
  `vinculo` VARCHAR(25) NULL,
  PRIMARY KEY (`idVinculo`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `scc`.`Pessoa` (
  `idPessoa` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `nomeGuerra` VARCHAR(125) NULL,
  `Posto_idPosto` INT NULL,
  `cpf` VARCHAR(15) NULL,
  `identidadeMilitar` VARCHAR(12) NULL,
  `preccp` VARCHAR(12) NULL,
  `foto` VARCHAR(250) NULL,
  `Vinculo_idVinculo` INT NOT NULL,
  `dataCadastro` DATETIME NULL,
  `dataExpiracao` DATE NULL,
  PRIMARY KEY (`idPessoa`),
  INDEX `fk_Pessoa_Posto1_idx` (`Posto_idPosto` ASC) VISIBLE,
  INDEX `fk_Pessoa_Vinculo1_idx` (`Vinculo_idVinculo` ASC) VISIBLE,
  CONSTRAINT `fk_Pessoa_Posto1`
    FOREIGN KEY (`Posto_idPosto`)
    REFERENCES `scc`.`Posto` (`idPosto`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Pessoa_Vinculo1`
    FOREIGN KEY (`Vinculo_idVinculo`)
    REFERENCES `scc`.`Vinculo` (`idVinculo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `scc`.`Veiculo` (
  `idVeiculo` INT NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(70) NULL,
  `modelo` VARCHAR(70) NULL,
  `anoFabricacao` INT NULL,
  `anoModelo` INT NULL,
  `cor` VARCHAR(7) NULL,
  `placa` VARCHAR(8) NULL,
  `placaEB` VARCHAR(25) NULL,
  `tipo` VARCHAR(25) NULL,
  `Pessoa_idPessoa` INT NULL,
  PRIMARY KEY (`idVeiculo`),
  INDEX `fk_Veiculo_Pessoa1_idx` (`Pessoa_idPessoa` ASC) VISIBLE,
  CONSTRAINT `fk_Veiculo_Pessoa1`
    FOREIGN KEY (`Pessoa_idPessoa`)
    REFERENCES `scc`.`Pessoa` (`idPessoa`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `scc`.`AuditoriaVeiculo` (
  `idAuditoriaVeiculo` INT NOT NULL AUTO_INCREMENT,
  `Veiculo_idVeiculo` INT NULL,
  `dataEntrada` DATETIME NULL,
  `dataSaida` DATETIME NULL,
  `local` VARCHAR(25) NULL,
  `autorizacao` TINYINT(1) NULL,
  `preccp` VARCHAR(14) NULL,
  `placa` VARCHAR(8) NULL,
  `nome` VARCHAR(70) NULL,
  INDEX `fk_AuditoriaVeiculo_Veiculo1_idx` (`Veiculo_idVeiculo` ASC) VISIBLE,
  PRIMARY KEY (`idAuditoriaVeiculo`),
  CONSTRAINT `fk_AuditoriaVeiculo_Veiculo1`
    FOREIGN KEY (`Veiculo_idVeiculo`)
    REFERENCES `scc`.`Veiculo` (`idVeiculo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `scc`.`AuditoriaPessoa` (
  `idAuditoriaPessoa` INT NOT NULL AUTO_INCREMENT,
  `Pessoa_idPessoa` INT NULL,
  `dataEntrada` DATETIME NULL,
  `dataSaida` DATETIME NULL,
  `local` VARCHAR(25) NULL,
  `autorizacao` TINYINT(1) NULL,
  PRIMARY KEY (`idAuditoriaPessoa`),
  INDEX `fk_AuditoriaPessoa_Pessoa1_idx` (`Pessoa_idPessoa` ASC) VISIBLE,
  CONSTRAINT `fk_AuditoriaPessoa_Pessoa1`
    FOREIGN KEY (`Pessoa_idPessoa`)
    REFERENCES `scc`.`Pessoa` (`idPessoa`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (1, 'Ativa');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (2, 'PTTC');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (3, 'Reserva');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (4, 'Beneficiário FuSEx');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (5, 'Beneficiário SVP');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (6, 'Servidor Civil');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (7, 'Outros');



