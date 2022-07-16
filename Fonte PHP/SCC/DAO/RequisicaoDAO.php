<?php

require_once '../Model/Requisicao.php';
require_once '../include/comum.php';

class RequisicaoDAO {

    function insert($object) {
        try {
            $c = connect();
            $sql = "START TRANSACTION;"
                    . "INSERT INTO `scc`.`Requisicao` (`dataRequisicao`, `NotaCredito_idNotaCredito`, `om`, `Secao_idSecao`, `descricao`, `pe`, `ug`, `ompe`, `empresa`, `cnpj`, `contato`, `ne`, `observacaoAquisicoes`, `dataEnvioNE`, `valorNE`, `dataAprovacao`, `observacaoConformidade`, `parecer`, `dataEntregaMaterial`, `numeroDiex`, `processoAdministrativo`, `numeroOficio`, `boletim`, `dataUltimaLiquidacao`, `valorLiquidar`, `dataNE`, `observacaoAlmox`) "
                    . " VALUES("
                    . (!empty($object->getDataRequisicao()) ? "'" . $object->getDataRequisicao() . "' " : "NULL ")
                    . ", " . (!empty($object->getIdNotaCredito()) ? $object->getIdNotaCredito() : "NULL ")
                    . ", '" . $object->getOm() . "'"
                    . ", " . $object->getIdSecao()
                    . ", '" . $object->getDescricao() . "'"
                    . ", '" . $object->getPe() . "'"
                    . ", " . $object->getUg() . " "
                    . ", '" . $object->getOmpe() . "'"
                    . ", '" . $object->getEmpresa() . "'"
                    . ", '" . $object->getCnpj() . "'"
                    . ", '" . $object->getContato() . "'"
                    . ", '" . $object->getNe() . "'"
                    . ", '" . $object->getObservacaoAquisicoes() . "'"
                    . ", " . (!empty($object->getDataEnvioNE()) ? "'" . $object->getDataEnvioNE() . "' " : "NULL ")
                    . ", '" . (empty($object->getValorNE()) ? "0.0" : $object->getValorNE()) . "'"
                    . ", " . (!empty($object->getDataAprovacao()) ? "'" . $object->getDataAprovacao() . "' " : "NULL ")
                    . ", '" . $object->getObservacaoConformidade() . "'"
                    . ", " . (!empty($object->getParecer()) ? $object->getParecer() : "NULL ")
                    . "," . (!empty($object->getDataEntregaMaterial()) ? "'" . $object->getDataEntregaMaterial() . "' " : "NULL ")
                    . ", '" . $object->getNumeroDiex() . "'"
                    . ", '" . $object->getProcessoAdministrativo() . "'"
                    . ", '" . $object->getNumeroOficio() . "'"
                    . ", '" . $object->getBoletim() . "'"
                    . ", " . (!empty($object->getDataUltimaLiquidacao()) ? "'" . $object->getDataUltimaLiquidacao() . "' " : "NULL ")
                    . ", '" . (empty($object->getValorLiquidar()) ? "0.0" : $object->getValorLiquidar()) . "'"
                    . ", NULL"
                    . ", '" . $object->getObservacaoAlmox() . "'"
                    . ");SET @idRequisicao = LAST_INSERT_ID();";
            $itemList = $object->getItemList();
            foreach ($itemList as $item) {
                $sql .= "INSERT INTO `scc`.`Item` (`numeroItem`, `descricao`, `quantidade`, `valor`, `Requisicao_idRequisicao`) "
                        . "VALUES ("
                        . "'" . $item->getNumeroItem() . "' "
                        . ", '" . $item->getDescricao() . "' "
                        . ", " . (empty($item->getQuantidade()) ? "0" : $item->getQuantidade()) . " "
                        . ", '" . (empty($item->getValor()) ? "0.0" : $item->getValor()) . "' "
                        . ", @idRequisicao "
                        . ");";
            }
            $sql .= "COMMIT;";
            //$stmt = $c->prepare($sql);
            //$sqlOk = $stmt ? $stmt->execute() : false;               
            $sqlOk = $c->multi_query($sql);
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function update($object) {
        try {
            $c = connect();
            $sql = "START TRANSACTION;
                        UPDATE `scc`.`Requisicao`
                        SET "
                    . " dataRequisicao = " . (!empty($object->getDataRequisicao()) ? "'" . $object->getDataRequisicao() . "' " : "NULL ")
                    . ", NotaCredito_idNotaCredito = " . (!empty($object->getIdNotaCredito()) ? $object->getIdNotaCredito() : "NULL ")
                    . ", om = '" . $object->getOm() . "' "
                    . ", Secao_idSecao = " . $object->getIdSecao() . " "
                    . ", descricao = '" . $object->getDescricao() . "' "
                    . ", pe = '" . $object->getPe() . "' "
                    . ", ug= " . $object->getUg()
                    . ", ompe = '" . $object->getOmpe() . "' "
                    . ", empresa = '" . $object->getEmpresa() . "' "
                    . ", cnpj = '" . $object->getCnpj() . "' "
                    . ", contato = '" . $object->getContato() . "' "
                    . ", ne = '" . $object->getNe() . "' "
                    . ", observacaoAquisicoes = '" . $object->getObservacaoAquisicoes() . "' "
                    . ", DataEnvioNE = " . (!empty($object->getDataEnvioNE()) ? "'" . $object->getDataEnvioNE() . "' " : "NULL ")
                    . ", valorNE = '" . (empty($object->getValorNE()) ? "0.0" : $object->getValorNE()) . "' "
                    . ", dataAprovacao = " . (!empty($object->getDataAprovacao()) ? "'" . $object->getDataAprovacao() . "' " : "NULL ")
                    . ", observacaoConformidade = '" . $object->getObservacaoConformidade() . "' "
                    . ", parecer = " . (!empty($object->getParecer()) ? $object->getParecer() : "NULL ")
                    . ", dataEntregaMaterial = " . (!empty($object->getDataEntregaMaterial()) ? "'" . $object->getDataEntregaMaterial() . "' " : "NULL ")
                    . ", numeroDiex = '" . $object->getNumeroDiex() . "' "
                    . ", processoAdministrativo = '" . $object->getProcessoAdministrativo() . "' "
                    . ", numeroOficio = '" . $object->getNumeroOficio() . "' "
                    . ", boletim = '" . $object->getBoletim() . "' "
                    . ", dataUltimaLiquidacao = " . (!empty($object->getDataUltimaLiquidacao()) ? "'" . $object->getDataUltimaLiquidacao() . "' " : "NULL ")
                    . ", valorLiquidar = '" . (empty($object->getValorLiquidar()) ? "0.0" : $object->getValorLiquidar()) . "' ";
            $dataNE = $object->getDataNe();
            if (empty($dataNE) && !empty($object->getNe())) {
                $sql .= ", dataNE = CURRENT_DATE ";
            }
            $sql .= ", observacaoAlmox = '" . $object->getObservacaoAlmox() . "' "
                    . " WHERE idRequisicao = " . $object->getId() . ";";
            $itemList = $object->getItemList();
            foreach ($itemList as $item) {
                $sql .= "INSERT INTO `scc`.`Item` (`numeroItem`, `descricao`, `quantidade`, `valor`, `Requisicao_idRequisicao`) "
                        . "VALUES ("
                        . "'" . $item->getNumeroItem() . "' "
                        . ", '" . $item->getDescricao() . "' "
                        . ", " . (empty($item->getQuantidade()) ? "0" : $item->getQuantidade()) . " "
                        . ", '" . (empty($item->getValor()) ? "0.0" : $item->getValor()) . "' "
                        . ", " . $object->getId()
                        . ");";
            }
            $sql .= "COMMIT;";
            //$stmt = $c->prepare($sql);            
            //$sqlOk = $stmt ? $stmt->execute() : false;       
            $sqlOk = $c->multi_query($sql);
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function delete($id) {
        try {
            $c = connect();
            $sql = "DELETE FROM Requisicao WHERE idRequisicao = $id";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " WHERE idRequisicao = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", DATE_FORMAT(dataRequisicao, '%d/%m/%Y') as dataRequisicaoFormatada "
                    . ", DATE_FORMAT(dataNE, '%d/%m/%Y') as dataNEFormatada "
                    . ", DATE_FORMAT(dataEnvioNE, '%d/%m/%Y') as dataEnvioNEFormatada "
                    . " FROM Requisicao "
                    . " INNER JOIN NotaCredito ON NotaCredito_idNotaCredito";
            if (
                    $filtro["idSecao"] > 0 ||
                    $filtro["idNotaCredito"] > 0 ||
                    !empty($filtro["ug"]) ||
                    !empty($filtro["ne"]) ||
                    $filtro["materiaisEntregues"] === 1 ||
                    $filtro["materiaisEntregues"] === 0
            ) {
                $sql .= " WHERE ";
                if($filtro["idSecao"] > 0) {
                    $sql .= " Secao_idSecao = " . $filtro["idSecao"];
                }
                if($filtro["idNotaCredito"] > 0) {
                    if($filtro["idSecao"] > 0) {
                        $sql .= " AND ";
                    }
                    $sql .= " NotaCredito_idNotaCredito = " . $filtro["idNotaCredito"];
                }
                if(!empty($filtro["ug"])) {
                    if($filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0) {
                        $sql .= " AND ";
                    }
                    $sql .= " NotaCredito.ug = '" . $filtro["ug"] . "'";
                }
                if(!empty($filtro["ne"])) {
                    if($filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0 || !empty($filtro["ug"])) {
                        $sql .= " AND ";
                    }
                    $sql .= " ne = '" . $filtro["ne"] . "'";
                }
                if($filtro["materiaisEntregues"] === 1) {
                    if($filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0 || !empty($filtro["ug"]) || !empty($filtro["ne"])) {
                        $sql .= " AND ";
                    }
                    $sql .= " (dataEntregaMaterial != '' AND dataEntregaMaterial IS NOT NULL) ";
                }
                if($filtro["materiaisEntregues"] === 0) {
                    if($filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0 || !empty($filtro["ug"]) || !empty($filtro["ne"])) {
                        $sql .= " AND ";
                    }
                    $sql .= " (dataEntregaMaterial = '' OR dataEntregaMaterial IS NULL) ";
                }
            }
            $sql .= " ORDER BY dataRequisicao";            
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Requisicao($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function fillArray($row) {
        return array(
            "id" => $row["idRequisicao"],
            "dataRequisicao" => $row["dataRequisicao"],
            "idNotaCredito" => $row["NotaCredito_idNotaCredito"],
            "om" => $row["om"],
            "idSecao" => $row["Secao_idSecao"],
            "descricao" => $row["descricao"],
            "pe" => $row["pe"],
            "ug" => $row["ug"],
            "ompe" => $row["ompe"],
            "empresa" => $row["empresa"],
            "cnpj" => $row["cnpj"],
            "contato" => $row["contato"],
            "ne" => $row["ne"],
            "observacaoAquisicoes" => $row["observacaoAquisicoes"],
            "dataEnvioNE" => $row["dataEnvioNE"],
            "valorNE" => $row["valorNE"],
            "dataAprovacao" => $row["dataAprovacao"],
            "observacaoConformidade" => $row["observacaoConformidade"],
            "parecer" => $row["parecer"],
            "dataEntregaMaterial" => $row["dataEntregaMaterial"],
            "numeroDiex" => $row["numeroDiex"],
            "processoAdministrativo" => $row["processoAdministrativo"],
            "numeroOficio" => $row["numeroOficio"],
            "boletim" => $row["boletim"],
            "dataUltimaLiquidacao" => $row["dataUltimaLiquidacao"],
            "valorLiquidar" => $row["valorLiquidar"],
            "itemList" => "",
            "dataRequisicaoFormatada" => $row["dataRequisicaoFormatada"],
            "dataEnvioNEFormatada" => $row["dataEnvioNEFormatada"],
            "dataNE" => $row["dataNE"],
            "dataNEFormatada" => $row["dataNEFormatada"]
        );
    }

}
