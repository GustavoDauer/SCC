-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema scc
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema scc
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `scc` ;
USE `scc` ;

-- -----------------------------------------------------
-- Table `scc`.`Posto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Posto` ;

CREATE TABLE IF NOT EXISTS `scc`.`Posto` (
  `idPosto` INT NOT NULL AUTO_INCREMENT,
  `posto` VARCHAR(70) NULL,
  PRIMARY KEY (`idPosto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `scc`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(70) NOT NULL,
  `senha` VARCHAR(70) NULL,
  `status` TINYINT NULL,
  `nome` VARCHAR(70) NULL,
  `Posto_idPosto` INT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_Usuario_Posto1_idx` (`Posto_idPosto` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_Posto1`
    FOREIGN KEY (`Posto_idPosto`)
    REFERENCES `scc`.`Posto` (`idPosto`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Secao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Secao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Secao` (
  `idSecao` INT NOT NULL AUTO_INCREMENT,
  `secao` VARCHAR(70) NOT NULL,
  `dataAtualizacao` DATETIME NULL,
  `mensagem` VARCHAR(700) NULL,
  PRIMARY KEY (`idSecao`),
  UNIQUE INDEX `secao_UNIQUE` (`secao` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Usuario_has_Secao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Usuario_has_Secao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Usuario_has_Secao` (
  `Usuario_idUsuario` INT NOT NULL,
  `Secao_idSecao` INT NOT NULL,
  PRIMARY KEY (`Usuario_idUsuario`, `Secao_idSecao`),
  INDEX `fk_Usuario_has_Secao_Secao1_idx` (`Secao_idSecao` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Secao_Usuario_idx` (`Usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Secao_Usuario`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `scc`.`Usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Usuario_has_Secao_Secao1`
    FOREIGN KEY (`Secao_idSecao`)
    REFERENCES `scc`.`Secao` (`idSecao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Processo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Processo` ;

CREATE TABLE IF NOT EXISTS `scc`.`Processo` (
  `idProcesso` INT NOT NULL AUTO_INCREMENT,
  `portaria` VARCHAR(250) NOT NULL,
  `responsavel` VARCHAR(70) NULL,
  `solucao` VARCHAR(250) NULL,
  `dataInicio` DATE NULL,
  `dataFim` DATE NULL,
  `tipo` VARCHAR(70) NULL,
  `assunto` VARCHAR(1000) NULL,
  `prorrogacao` VARCHAR(125) NULL,
  `prorrogacaoPrazo` DATE NULL,
  `dataPrazo` DATE NULL,
  PRIMARY KEY (`idProcesso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Combustivel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Combustivel` ;

CREATE TABLE IF NOT EXISTS `scc`.`Combustivel` (
  `ctc01-celula1` VARCHAR(70) NULL,
  `ctc01-celula2` VARCHAR(70) NULL,
  `ctc01-celula3` VARCHAR(70) NULL,
  `ctc01-celula1-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc01-celula2-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc01-celula3-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc04-celula1` VARCHAR(70) NULL,
  `ctc04-celula2` VARCHAR(70) NULL,
  `ctc04-celula3` VARCHAR(70) NULL,
  `ctc04-celula1-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc04-celula2-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc04-celula3-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `diesel` DECIMAL(10,1) NULL DEFAULT 0.0,
  `gasolina` DECIMAL(10,1) NULL DEFAULT 0.0)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Situacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Situacao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Situacao` (
  `idSituacao` INT NOT NULL AUTO_INCREMENT,
  `situacao` VARCHAR(70) NULL,
  PRIMARY KEY (`idSituacao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Classe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Classe` ;

CREATE TABLE IF NOT EXISTS `scc`.`Classe` (
  `idClasse` INT NOT NULL AUTO_INCREMENT,
  `classe` VARCHAR(70) NULL,
  PRIMARY KEY (`idClasse`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Material` ;

CREATE TABLE IF NOT EXISTS `scc`.`Material` (
  `idMaterial` INT NOT NULL AUTO_INCREMENT,
  `item` VARCHAR(250) NULL,
  `marca` VARCHAR(70) NULL,
  `modelo` VARCHAR(70) NULL,
  `ano` VARCHAR(14) NULL,
  `motivo` VARCHAR(70) NULL,
  `local` VARCHAR(125) NULL,
  `motivoDetalhado` VARCHAR(700) NULL,
  `Situacao_idSituacao` INT NULL,
  `Classe_idClasse` INT NULL,
  `secaoResponsavel` VARCHAR(25) NULL,
  PRIMARY KEY (`idMaterial`),
  INDEX `fk_Material_Situacao1_idx` (`Situacao_idSituacao` ASC) VISIBLE,
  INDEX `fk_Material_Classe1_idx` (`Classe_idClasse` ASC) VISIBLE,
  CONSTRAINT `fk_Material_Situacao1`
    FOREIGN KEY (`Situacao_idSituacao`)
    REFERENCES `scc`.`Situacao` (`idSituacao`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Material_Classe1`
    FOREIGN KEY (`Classe_idClasse`)
    REFERENCES `scc`.`Classe` (`idClasse`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Baixado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Baixado` ;

CREATE TABLE IF NOT EXISTS `scc`.`Baixado` (
  `idBaixado` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `situacao` VARCHAR(70) NULL,
  `turma` INT NULL,
  `cia` VARCHAR(25) NULL,
  `amparo` VARCHAR(250) NULL,
  `dataAtualizacao` DATE NULL,
  `Posto_idPosto` INT NULL,
  `diagnostico` VARCHAR(520) NULL,
  `bi` VARCHAR(520) NULL,
  `bar` VARCHAR(520) NULL,
  `dispensa` VARCHAR(250) NULL,
  `acao` VARCHAR(500) NULL,
  PRIMARY KEY (`idBaixado`),
  INDEX `fk_Baixado_Posto1_idx` (`Posto_idPosto` ASC) VISIBLE,
  CONSTRAINT `fk_Baixado_Posto1`
    FOREIGN KEY (`Posto_idPosto`)
    REFERENCES `scc`.`Posto` (`idPosto`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`MapaDaForca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`MapaDaForca` ;

CREATE TABLE IF NOT EXISTS `scc`.`MapaDaForca` (
  `cel_previsto` SMALLINT NULL DEFAULT 0,
  `tc_previsto` SMALLINT NULL DEFAULT 0,
  `maj_previsto` SMALLINT NULL DEFAULT 0,
  `cap_previsto` SMALLINT NULL DEFAULT 0,
  `1ten_previsto` SMALLINT NULL DEFAULT 0,
  `2ten_previsto` SMALLINT NULL DEFAULT 0,
  `aspof_previsto` SMALLINT NULL DEFAULT 0,
  `cel_existente` SMALLINT NULL DEFAULT 0,
  `tc_existente` SMALLINT NULL DEFAULT 0,
  `maj_existente` SMALLINT NULL DEFAULT 0,
  `cap_existente` SMALLINT NULL DEFAULT 0,
  `1ten_existente` SMALLINT NULL DEFAULT 0,
  `2ten_existente` SMALLINT NULL DEFAULT 0,
  `aspof_existente` SMALLINT NULL DEFAULT 0,
  `sten_previsto` SMALLINT NULL DEFAULT 0,
  `1sgt_previsto` SMALLINT NULL DEFAULT 0,
  `2sgt_previsto` SMALLINT NULL DEFAULT 0,
  `3sgt_previsto` SMALLINT NULL DEFAULT 0,
  `cb_previsto` SMALLINT NULL DEFAULT 0,
  `cbev_previsto` SMALLINT NULL DEFAULT 0,
  `sdep_previsto` SMALLINT NULL DEFAULT 0,
  `sdev_previsto` SMALLINT NULL DEFAULT 0,
  `sten_existente` SMALLINT NULL DEFAULT 0,
  `1sgt_existente` SMALLINT NULL DEFAULT 0,
  `2sgt_existente` SMALLINT NULL DEFAULT 0,
  `3sgt_existente` SMALLINT NULL DEFAULT 0,
  `cb_existente` SMALLINT NULL DEFAULT 0,
  `cbev_existente` SMALLINT NULL DEFAULT 0,
  `sdep_existente` SMALLINT NULL DEFAULT 0,
  `sdev_existente` SMALLINT NULL DEFAULT 0,
  `cel_adido` SMALLINT NULL DEFAULT 0,
  `tc_adido` SMALLINT NULL DEFAULT 0,
  `maj_adido` SMALLINT NULL DEFAULT 0,
  `cap_adido` SMALLINT NULL DEFAULT 0,
  `1ten_adido` SMALLINT NULL DEFAULT 0,
  `2ten_adido` SMALLINT NULL DEFAULT 0,
  `aspof_adido` SMALLINT NULL DEFAULT 0,
  `sten_adido` SMALLINT NULL DEFAULT 0,
  `1sgt_adido` SMALLINT NULL DEFAULT 0,
  `2sgt_adido` SMALLINT NULL DEFAULT 0,
  `3sgt_adido` SMALLINT NULL DEFAULT 0,
  `cb_adido` SMALLINT NULL DEFAULT 0,
  `cbev_adido` SMALLINT NULL DEFAULT 0,
  `sdep_adido` SMALLINT NULL DEFAULT 0,
  `sdev_adido` SMALLINT NULL DEFAULT 0,
  `cel_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `tc_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `maj_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `cap_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `1ten_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `2ten_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `aspof_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `sten_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `1sgt_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `2sgt_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `3sgt_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `cb_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `cbev_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `sdep_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `sdev_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `encostados` VARCHAR(500) NULL DEFAULT 0,
  `agregados` VARCHAR(500) NULL DEFAULT 0,
  `cap_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `1ten_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `2ten_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `sten_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `1sgt_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `2sgt_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `cap_pttc_existente` SMALLINT NULL DEFAULT 0,
  `1ten_pttc_existente` SMALLINT NULL DEFAULT 0,
  `2ten_pttc_existente` SMALLINT NULL DEFAULT 0,
  `sten_pttc_existente` SMALLINT NULL DEFAULT 0,
  `1sgt_pttc_existente` SMALLINT NULL DEFAULT 0,
  `2sgt_pttc_existente` SMALLINT NULL DEFAULT 0,
  `cap_pttc_adido` SMALLINT NULL DEFAULT 0,
  `1ten_pttc_adido` SMALLINT NULL DEFAULT 0,
  `2ten_pttc_adido` SMALLINT NULL DEFAULT 0,
  `sten_pttc_adido` SMALLINT NULL DEFAULT 0,
  `1sgt_pttc_adido` SMALLINT NULL DEFAULT 0,
  `2sgt_pttc_adido` SMALLINT NULL DEFAULT 0,
  `cap_pttc_adidoTexto` VARCHAR(500) NULL,
  `1ten_pttc_adidoTexto` VARCHAR(500) NULL,
  `2ten_pttc_adidoTexto` VARCHAR(500) NULL,
  `sten_pttc_adidoTexto` VARCHAR(500) NULL,
  `1sgt_pttc_adidoTexto` VARCHAR(500) NULL,
  `2sgt_pttc_adidoTexto` VARCHAR(500) NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Providencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Providencia` ;

CREATE TABLE IF NOT EXISTS `scc`.`Providencia` (
  `idProvidencia` INT NOT NULL AUTO_INCREMENT,
  `providencia` VARCHAR(2500) NULL,
  `Material_idMaterial` INT NOT NULL,
  `data` DATE NULL,
  PRIMARY KEY (`idProvidencia`),
  INDEX `fk_Providencia_Material1_idx` (`Material_idMaterial` ASC) VISIBLE,
  CONSTRAINT `fk_Providencia_Material1`
    FOREIGN KEY (`Material_idMaterial`)
    REFERENCES `scc`.`Material` (`idMaterial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`NotaCredito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`NotaCredito` ;

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
  `valorRecolhido` DECIMAL(10,2) NULL,
  PRIMARY KEY (`idNotaCredito`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Categoria` ;

CREATE TABLE IF NOT EXISTS `scc`.`Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(125) NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Requisicao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Requisicao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Requisicao` (
  `idRequisicao` INT NOT NULL AUTO_INCREMENT,
  `dataRequisicao` DATE NULL,
  `om` VARCHAR(70) NULL,
  `Secao_idSecao` INT NULL DEFAULT NULL,
  `NotaCredito_idNotaCredito` INT NULL,
  `Categoria_idCategoria` INT NULL,
  `modalidade` VARCHAR(70) NULL,
  `numeroModalidade` VARCHAR(14) NULL,
  `ug` INT NULL,
  `omModalidade` VARCHAR(125) NULL,
  `empresa` VARCHAR(250) NULL,
  `cnpj` VARCHAR(25) NULL,
  `contato` VARCHAR(520) NULL,
  `dataNE` DATE NULL,
  `tipoNE` VARCHAR(25) NULL,
  `ne` VARCHAR(25) NULL,
  `valorNE` DECIMAL(10,2) NULL,
  `observacaoSALC` VARCHAR(520) NULL,
  `dataEnvioNE` DATE NULL,
  `valorAnulado` DECIMAL(10,2) NULL,
  `justificativaAnulado` VARCHAR(520) NULL,
  `valorReforcado` DECIMAL(10,2) NULL,
  `observacaoReforco` VARCHAR(520) NULL,
  `NotaCredito_idNotaCreditoReforco` INT NULL,
  `dataParecer` DATE NULL,
  `parecer` TINYINT(1) NULL,
  `observacaoConformidade` VARCHAR(520) NULL,
  `dataAssinatura` DATE NULL,
  `dataEnvioNEEmpresa` DATE NULL,
  `dataPrazoEntrega` DATE NULL,
  `diex` VARCHAR(520) NULL,
  `dataDiex` DATE NULL,
  `dataOficio` DATE NULL,
  `Processo_idProcesso` INT NULL,
  `observacaoAlmox` VARCHAR(520) NULL,
  `dataProtocoloSalc1` DATE NULL,
  `dataProtocoloConformidade` DATE NULL,
  `dataProtocoloSalc2` DATE NULL,
  `dataProtocoloAlmox` DATE NULL,
  `tipoNF` VARCHAR(25) NULL,
  `responsavel` VARCHAR(25) NULL,
  PRIMARY KEY (`idRequisicao`),
  INDEX `fk_Requisicao_Secao1_idx` (`Secao_idSecao` ASC) VISIBLE,
  INDEX `fk_Requisicao_NotaCredito1_idx` (`NotaCredito_idNotaCredito` ASC) VISIBLE,
  INDEX `fk_Requisicao_Categoria1_idx` (`Categoria_idCategoria` ASC) VISIBLE,
  INDEX `fk_Requisicao_NotaCredito2_idx` (`NotaCredito_idNotaCreditoReforco` ASC) VISIBLE,
  INDEX `fk_Requisicao_Processo1_idx` (`Processo_idProcesso` ASC) VISIBLE,
  CONSTRAINT `fk_Requisicao_Secao1`
    FOREIGN KEY (`Secao_idSecao`)
    REFERENCES `scc`.`Secao` (`idSecao`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_NotaCredito1`
    FOREIGN KEY (`NotaCredito_idNotaCredito`)
    REFERENCES `scc`.`NotaCredito` (`idNotaCredito`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_Categoria1`
    FOREIGN KEY (`Categoria_idCategoria`)
    REFERENCES `scc`.`Categoria` (`idCategoria`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_NotaCredito2`
    FOREIGN KEY (`NotaCredito_idNotaCreditoReforco`)
    REFERENCES `scc`.`NotaCredito` (`idNotaCredito`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_Processo1`
    FOREIGN KEY (`Processo_idProcesso`)
    REFERENCES `scc`.`Processo` (`idProcesso`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Visitante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Visitante` ;

CREATE TABLE IF NOT EXISTS `scc`.`Visitante` (
  `idVisitante` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `cpf` VARCHAR(16) NULL,
  `telefone` VARCHAR(14) NULL,
  `destino` VARCHAR(250) NULL,
  `dataEntrada` DATETIME NULL,
  `dataSaida` DATETIME NULL,
  `cracha` VARCHAR(25) NULL,
  `temporario` TINYINT(1) NULL,
  `foto` VARCHAR(250) NULL,
  PRIMARY KEY (`idVisitante`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Item` ;

CREATE TABLE IF NOT EXISTS `scc`.`Item` (
  `idItem` INT NOT NULL AUTO_INCREMENT,
  `numeroItem` VARCHAR(7) NULL,
  `descricao` VARCHAR(500) NULL,
  `quantidade` INT NULL,
  `valor` DECIMAL(10,2) NULL,
  `Requisicao_idRequisicao` INT NULL,
  PRIMARY KEY (`idItem`),
  INDEX `fk_Item_Requisicao1_idx` (`Requisicao_idRequisicao` ASC) VISIBLE,
  CONSTRAINT `fk_Item_Requisicao1`
    FOREIGN KEY (`Requisicao_idRequisicao`)
    REFERENCES `scc`.`Requisicao` (`idRequisicao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`NotaFiscal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`NotaFiscal` ;

CREATE TABLE IF NOT EXISTS `scc`.`NotaFiscal` (
  `idNotaFiscal` INT NOT NULL AUTO_INCREMENT,
  `tipoNF` VARCHAR(25) NULL,
  `nf` VARCHAR(70) NULL,
  `codigoVerificacao` VARCHAR(70) NULL,
  `chaveAcesso` VARCHAR(70) NULL,
  `valorNF` DECIMAL(10,2) NULL,
  `descricao` VARCHAR(1000) NULL,
  `dataEmissaoNF` DATE NULL,
  `dataEntrega` DATE NULL,
  `dataRemessaTesouraria` DATE NULL,
  `Requisicao_idRequisicao` INT NOT NULL,
  `dataLiquidacao` DATE NULL,
  `dataPedido` DATE NULL,
  `dataPrazoEntrega` DATE NULL,
  PRIMARY KEY (`idNotaFiscal`),
  INDEX `fk_NotaFiscal_Requisicao1_idx` (`Requisicao_idRequisicao` ASC) VISIBLE,
  CONSTRAINT `fk_NotaFiscal_Requisicao1`
    FOREIGN KEY (`Requisicao_idRequisicao`)
    REFERENCES `scc`.`Requisicao` (`idRequisicao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`NotaFiscal_has_Item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`NotaFiscal_has_Item` ;

CREATE TABLE IF NOT EXISTS `scc`.`NotaFiscal_has_Item` (
  `NotaFiscal_idNotaFiscal` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  `quantidade` INT NULL,
  INDEX `fk_NotaFiscal_has_Item_Item1_idx` (`Item_idItem` ASC) VISIBLE,
  INDEX `fk_NotaFiscal_has_Item_NotaFiscal1_idx` (`NotaFiscal_idNotaFiscal` ASC) VISIBLE,
  CONSTRAINT `fk_NotaFiscal_has_Item_NotaFiscal1`
    FOREIGN KEY (`NotaFiscal_idNotaFiscal`)
    REFERENCES `scc`.`NotaFiscal` (`idNotaFiscal`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_NotaFiscal_has_Item_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `scc`.`Item` (`idItem`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Sped`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Sped` ;

CREATE TABLE IF NOT EXISTS `scc`.`Sped` (
  `idSped` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(1150) NULL,
  `prazo` DATE NULL,
  `data` DATE NULL,
  `resolvido` TINYINT(1) NULL DEFAULT 0,
  `responsavel` VARCHAR(250) NULL,
  `tipo` VARCHAR(70) NULL,
  PRIMARY KEY (`idSped`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Vinculo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Vinculo` ;

CREATE TABLE IF NOT EXISTS `scc`.`Vinculo` (
  `idVinculo` INT NOT NULL AUTO_INCREMENT,
  `vinculo` VARCHAR(25) NULL,
  PRIMARY KEY (`idVinculo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Pessoa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Pessoa` ;

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


-- -----------------------------------------------------
-- Table `scc`.`Veiculo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Veiculo` ;

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


-- -----------------------------------------------------
-- Table `scc`.`AuditoriaVeiculo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`AuditoriaVeiculo` ;

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


-- -----------------------------------------------------
-- Table `scc`.`AuditoriaPessoa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`AuditoriaPessoa` ;

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


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `scc`.`Posto`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Sd EV');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Sd EP');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Cb');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '3º Sgt');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '2º Sgt');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '1º Sgt');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'S Ten');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Asp Of');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '2º Ten');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '1º Ten');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Cap');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Maj');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'TC');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Cel');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Gen');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (1, 'secinfo', '$2y$10$8AeIOzR5MO1TWlAeAGDvgOUlbs.qjuGVLWfZDXEHpk18WKpZygayu', 1, 'SECINFO', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (2, 'comando', '$2y$10$VEExyrp7PAETxVxfGyj1gu1CX0YhgKhGA0qY8/VF/2CTMZrWXosv2', 1, 'COMANDO', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (3, 's1', '$2y$10$.pXuImdlpleQAeWW2980zO4JsUo/nm6t/st8WruyZDJ.54b3xJAt6', 1, 'S1', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (4, 's2', '$2y$10$Skprv.qJCSegfhFf1UoqA.7BoH/MtrWGG0DrqHeWFAPHbZySgPOxy', 1, 'S2', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (5, 's4', '$2y$10$.pmQu398nxnKiZfwx90vx.SUlevgTArayD/AzmnpSPyL000xhjrxi', 1, 'S4', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (6, 'fs', '$2y$10$o7Fx9dM2ikxy3AjwdgEuOO/6Hok1w1J8i0YnX19z6DySz8DeaaId.', 1, 'FS', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (7, 'rp', '$2y$10$iz1ZYComMTtU2m9nz9L5jeFaVGqrzX4277kHknHHb4lMgemfKA0qO', 1, 'RP', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (8, 'fiscalizacao', '$2y$10$TDE61e7tT4vkdmmxsdXakeWyiOHIJNgYB7VdTbWgH7fBoWUjrEiSm', 1, 'FISCALIZACAO', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (9, 'salc', '$2y$10$kfmi7M2ygPJpsrqmSrzQ3eKxdgwsjBTpn28Pb7CRAd5YZKcN./KKW', 1, 'SALC', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (10, 'conformidade', '$2y$10$rJlNnDNvu5leyUow0p7nAuP/u7eCRZAfG8eNkA8jyj4MxzaUbCn8G', 1, 'CONFORMIDADE', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (11, 'almox', '$2y$10$VU4eaLHmx7oClGjb9uUykupaT/jaazID8C8AosSrY4wWSOayHzi1a', 1, 'ALMOX', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (12, 'tesouraria', '$2y$10$sZ.MXDs2yA9sZRK1UwjmruzstslVZ4ewXsCI8GfGGPpibyPAVoAW.', 1, 'TESOURARIA', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (13, 'juridico', '$2y$10$q22an8BklkUDo41gFytQce8Gskyf6UZ6HaKJYqD/00sCM8IouQdti', 1, 'JURIDICO', 1);
INSERT INTO `scc`.`Usuario` (`idUsuario`, `login`, `senha`, `status`, `nome`, `Posto_idPosto`) VALUES (14, 'identidade', '$2y$10$VXpykQbJF3yKt3yPAd5bX./MJyJlEVFnWlDN0ZZPNho8UageSsvSa', 1, 'IDENTIDADE', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Secao`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'SecInfo', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'Comando', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'S1', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'S2', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'S4', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'FS', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'RP', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'Fiscalizacao', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'SALC', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'Conformidade', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'Almox', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'Tesouraria', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'Juridico', NULL, NULL);
INSERT INTO `scc`.`Secao` (`idSecao`, `secao`, `dataAtualizacao`, `mensagem`) VALUES (DEFAULT, 'Identidade', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Usuario_has_Secao`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (1, 1);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (2, 2);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (3, 3);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (4, 4);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (5, 5);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (6, 6);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (7, 7);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (8, 8);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (9, 9);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (10, 10);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (11, 11);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (12, 12);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (13, 13);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (14, 14);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (13, 3);
INSERT INTO `scc`.`Usuario_has_Secao` (`Usuario_idUsuario`, `Secao_idSecao`) VALUES (3, 13);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Combustivel`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Combustivel` (`ctc01-celula1`, `ctc01-celula2`, `ctc01-celula3`, `ctc01-celula1-valor`, `ctc01-celula2-valor`, `ctc01-celula3-valor`, `ctc04-celula1`, `ctc04-celula2`, `ctc04-celula3`, `ctc04-celula1-valor`, `ctc04-celula2-valor`, `ctc04-celula3-valor`, `diesel`, `gasolina`) VALUES ('Cota Batalhão', 'Cota Batalhão', 'Cota Batalhão', 0.0, 0.0, 0.0, 'Cota 2º BFV', 'Cota Batalhão', 'Indisponível', 0.0, 0.0, 0.0, 0.0, 0.0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Situacao`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Disponível');
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Indisponível');
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Cedido');
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Missão');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Classe`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'I');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'II');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'III');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'IV');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'V');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'VI');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'VII');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'VIII');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'IX');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'X');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Material`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Material` (`idMaterial`, `item`, `marca`, `modelo`, `ano`, `motivo`, `local`, `motivoDetalhado`, `Situacao_idSituacao`, `Classe_idClasse`, `secaoResponsavel`) VALUES (DEFAULT, 'Guindaste', 'Ford', 'E-1', '1988', 'Pneus', '2º BE Cmb', 'ND30: R$ 7.000', 1, 1, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`MapaDaForca`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`MapaDaForca` (`cel_previsto`, `tc_previsto`, `maj_previsto`, `cap_previsto`, `1ten_previsto`, `2ten_previsto`, `aspof_previsto`, `cel_existente`, `tc_existente`, `maj_existente`, `cap_existente`, `1ten_existente`, `2ten_existente`, `aspof_existente`, `sten_previsto`, `1sgt_previsto`, `2sgt_previsto`, `3sgt_previsto`, `cb_previsto`, `cbev_previsto`, `sdep_previsto`, `sdev_previsto`, `sten_existente`, `1sgt_existente`, `2sgt_existente`, `3sgt_existente`, `cb_existente`, `cbev_existente`, `sdep_existente`, `sdev_existente`, `cel_adido`, `tc_adido`, `maj_adido`, `cap_adido`, `1ten_adido`, `2ten_adido`, `aspof_adido`, `sten_adido`, `1sgt_adido`, `2sgt_adido`, `3sgt_adido`, `cb_adido`, `cbev_adido`, `sdep_adido`, `sdev_adido`, `cel_adidoTexto`, `tc_adidoTexto`, `maj_adidoTexto`, `cap_adidoTexto`, `1ten_adidoTexto`, `2ten_adidoTexto`, `aspof_adidoTexto`, `sten_adidoTexto`, `1sgt_adidoTexto`, `2sgt_adidoTexto`, `3sgt_adidoTexto`, `cb_adidoTexto`, `cbev_adidoTexto`, `sdep_adidoTexto`, `sdev_adidoTexto`, `encostados`, `agregados`, `cap_pttc_previsto`, `1ten_pttc_previsto`, `2ten_pttc_previsto`, `sten_pttc_previsto`, `1sgt_pttc_previsto`, `2sgt_pttc_previsto`, `cap_pttc_existente`, `1ten_pttc_existente`, `2ten_pttc_existente`, `sten_pttc_existente`, `1sgt_pttc_existente`, `2sgt_pttc_existente`, `cap_pttc_adido`, `1ten_pttc_adido`, `2ten_pttc_adido`, `sten_pttc_adido`, `1sgt_pttc_adido`, `2sgt_pttc_adido`, `cap_pttc_adidoTexto`, `1ten_pttc_adidoTexto`, `2ten_pttc_adidoTexto`, `sten_pttc_adidoTexto`, `1sgt_pttc_adidoTexto`, `2sgt_pttc_adidoTexto`) VALUES (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`NotaCredito`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`NotaCredito` (`idNotaCredito`, `dataNc`, `nc`, `pi`, `valor`, `gestorNc`, `ptres`, `fonte`, `ug`, `valorRecolhido`) VALUES (DEFAULT, '2022-01-01', '2022NC0001', '1', 2500.0, 'COTER', '1', '1', '160477', 0.0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Categoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Categoria` (`idCategoria`, `categoria`) VALUES (DEFAULT, 'Informática');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Requisicao`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Requisicao` (`idRequisicao`, `dataRequisicao`, `om`, `Secao_idSecao`, `NotaCredito_idNotaCredito`, `Categoria_idCategoria`, `modalidade`, `numeroModalidade`, `ug`, `omModalidade`, `empresa`, `cnpj`, `contato`, `dataNE`, `tipoNE`, `ne`, `valorNE`, `observacaoSALC`, `dataEnvioNE`, `valorAnulado`, `justificativaAnulado`, `valorReforcado`, `observacaoReforco`, `NotaCredito_idNotaCreditoReforco`, `dataParecer`, `parecer`, `observacaoConformidade`, `dataAssinatura`, `dataEnvioNEEmpresa`, `dataPrazoEntrega`, `diex`, `dataDiex`, `dataOficio`, `Processo_idProcesso`, `observacaoAlmox`, `dataProtocoloSalc1`, `dataProtocoloConformidade`, `dataProtocoloSalc2`, `dataProtocoloAlmox`, `tipoNF`, `responsavel`) VALUES (DEFAULT, '2022-01-07', '2º BE Cmb', 1, 1, 1, 'pe', '1', 160477, '2º BE Cmb', 'EMPRESA LTDA', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Vinculo`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (1, 'Ativa');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (2, 'PTTC');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (3, 'Reserva');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (4, 'Beneficiário FuSEx');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (5, 'Beneficiário SVP');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (6, 'Servidor Civil');
INSERT INTO `scc`.`Vinculo` (`idVinculo`, `vinculo`) VALUES (7, 'Outros');

COMMIT;


