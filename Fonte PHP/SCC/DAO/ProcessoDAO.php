<?php

/* * *****************************************************************************
 * 
 * Copyright © 2021 Gustavo Henrique Mello Dauer - 2º Ten 
 * Chefe da Seção de Informática do 2º BE Cmb
 * Email: gustavodauer@gmail.com
 * 
 * Este arquivo é parte do programa SCC
 * 
 * SCC é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Free Software Foundation (FSF); na versão 3 da
 * Licença, ou qualquer versão posterior.

 * Este programa é distribuído na esperança de que possa ser útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.

 * Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
 * com este programa, Se não, veja <http://www.gnu.org/licenses/>.
 * 
 * ***************************************************************************** */

/**
 *
 * @author gustavodauer
 */
require_once '../include/comum.php';
require_once '../Model/Processo.php';

class ProcessoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Processo("
                    . "portaria, responsavel, solucao, dataInicio, dataFim, tipo, assunto, dataPrazo"
                    . ") "
                    . "VALUES("
                    . "'" . $object->getPortaria() . "', "
                    . "'" . $object->getResponsavel() . "', "
                    . "'" . $object->getSolucao() . "', "
                    . (empty($object->getDataInicio()) ? "NULL, " : "'" . $object->getDataInicio() . "', ")
                    . (empty($object->getDataFim()) ? "NULL, " : "'" . $object->getDataFim() . "', ")
                    . "'" . $object->getTipo() . "', "
                    . "'" . $object->getAssunto() . "', "
                    . (empty($object->getDataPrazo()) ? "NULL " : "'" . $object->getDataPrazo() . "' ")
                    . ");";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Processo SET "
                    . "portaria = '" . $object->getPortaria() . "', "
                    . "responsavel = '" . $object->getResponsavel() . "', "
                    . "solucao = '" . $object->getSolucao() . "', "
                    . "dataInicio = " . (empty($object->getDataInicio()) ? "NULL, " : "'" . $object->getDataInicio() . "', ")
                    . "dataFim = " . (empty($object->getDataFim()) ? "NULL, " : "'" . $object->getDataFim() . "', ")
                    . "tipo = '" . $object->getTipo() . "', "
                    . "assunto = '" . $object->getAssunto() . "', "
                    . "prorrogacaoPrazo = " . (empty($object->getProrrogacaoPrazo()) ? "NULL, " : "'" . $object->getProrrogacaoPrazo() . "', ")
                    . "prorrogacao = '" . $object->getProrrogacao() . "', "
                    . "dataPrazo = " . (empty($object->getDataPrazo()) ? "NULL " : "'" . $object->getDataPrazo() . "' ")
                    . " WHERE idProcesso = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Processo "
                    . " WHERE idProcesso = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sqlFiltro = "";
            if (isset($filtro) && ($filtro["solucao"] != "todos" || !empty($filtro["tipo"]))) {
                $sqlFiltro .= " WHERE ";
                if ($filtro["solucao"] != "todos" && !empty($filtro["solucao"])) {
                    if ($filtro["solucao"] == "concluido") {
                        $sqlFiltro .= " solucao != '' ";
                    } else if ($filtro["solucao"] == "emandamento") {
                        $sqlFiltro .= " solucao = '' ";
                    } else if ($filtro["solucao"] == "protocolado") {
                        $sqlFiltro .= " solucao = '' AND dataFim IS NOT NULL AND dataFim != '' ";
                    } else {
                        $sqlFiltro .= " solucao = '' ";
                    }
                }
                if (!empty($filtro["tipo"])) {
                    $sqlFiltro .= $filtro["solucao"] != "todos" ? " AND " : "";
                    $sqlFiltro .= " tipo = '" . $filtro["tipo"] . "'";
                }
            }
            $sql = "SELECT * "
                    . ", DATE_FORMAT(dataInicio, '%d/%m/%Y') as dataInicio, DATE_FORMAT(dataInicio, '%Y/%m/%d') as dataInicioOriginal "
                    . ", DATE_FORMAT(dataFim, '%d/%m/%Y') as dataFim, DATE_FORMAT(dataFim, '%Y/%m/%d') as dataFimOriginal "
                    . ", DATE_FORMAT(prorrogacaoPrazo, '%d/%m/%Y') as prorrogacaoPrazo, DATE_FORMAT(prorrogacaoPrazo, '%Y/%m/%d') as prorrogacaoPrazoOriginal "
                    . ", DATE_FORMAT(dataPrazo, '%d/%m/%Y') as dataPrazo, DATE_FORMAT(dataPrazo, '%Y/%m/%d') as dataPrazoOriginal "
                    . " FROM Processo "
                    . $sqlFiltro
                    . " ORDER BY dataInicio DESC ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Processo($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", DATE_FORMAT(dataInicio, '%d/%m/%Y') as dataInicioFormatada, DATE_FORMAT(dataInicio, '%Y/%m/%d') as dataInicioOriginal "
                    . ", DATE_FORMAT(dataFim, '%d/%m/%Y') as dataFimFormatada, DATE_FORMAT(dataFim, '%Y/%m/%d') as dataFimOriginal "
                    . ", DATE_FORMAT(prorrogacaoPrazo, '%d/%m/%Y') as prorrogacaoPrazoFormatada, DATE_FORMAT(prorrogacaoPrazo, '%Y/%m/%d') as prorrogacaoPrazoOriginal "
                    . ", DATE_FORMAT(dataPrazo, '%d/%m/%Y') as dataPrazoFormatada, DATE_FORMAT(dataPrazo, '%Y/%m/%d') as dataPrazoOriginal "
                    . " FROM Processo "
                    . " WHERE idProcesso = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Processo($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idProcesso"],
            "portaria" => $row["portaria"],
            "responsavel" => $row["responsavel"],
            "solucao" => $row["solucao"],
            "dataInicio" => $row["dataInicio"],
            "dataFim" => $row["dataFim"],
            "dataInicioOriginal" => $row["dataInicioOriginal"],
            "dataFimOriginal" => $row["dataFimOriginal"],
            "tipo" => $row["tipo"],
            "assunto" => $row["assunto"],
            "prorrogacao" => $row["prorrogacao"],
            "prorrogacaoPrazo" => $row["prorrogacaoPrazo"],
            "prorrogacaoPrazoOriginal" => $row["prorrogacaoPrazoOriginal"],
            "dataPrazo" => $row["dataPrazo"],
            "dataPrazoOriginal" => $row["dataPrazoOriginal"]
        );
    }
}
