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
            $sql = "INSERT INTO Processo (
                    portaria, responsavel, solucao, dataInicio, dataFim, tipo, assunto, dataPrazo
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            // Preparar valores, tratando NULLs
            $portaria = $object->getPortaria();
            $responsavel = $object->getResponsavel();
            $solucao = $object->getSolucao();
            $dataInicio = $object->getDataInicio();
            $dataInicio = empty($dataInicio) ? null : $dataInicio;
            $dataFim = $object->getDataFim();
            $dataFim = empty($dataFim) ? null : $dataFim;
            $tipo = $object->getTipo();
            $assunto = $object->getAssunto();
            $dataPrazo = $object->getDataPrazo();
            $dataPrazo = empty($dataPrazo) ? null : $dataPrazo;
            // "ssssssss" porque são 8 parâmetros do tipo string ou null
            $stmt->bind_param(
                    "ssssssss",
                    $portaria,
                    $responsavel,
                    $solucao,
                    $dataInicio,
                    $dataFim,
                    $tipo,
                    $assunto,
                    $dataPrazo
            );
            $sqlOk = $stmt->execute();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Processo SET
                    portaria = ?,
                    responsavel = ?,
                    solucao = ?,
                    dataInicio = ?,
                    dataFim = ?,
                    tipo = ?,
                    assunto = ?,
                    prorrogacaoPrazo = ?,
                    prorrogacao = ?,
                    dataPrazo = ?
                WHERE idProcesso = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $portaria = $object->getPortaria();
            $responsavel = $object->getResponsavel();
            $solucao = $object->getSolucao();
            $dataInicio = $object->getDataInicio();
            $dataInicio = empty($dataInicio) ? null : $dataInicio;
            $dataFim = $object->getDataFim();
            $dataFim = empty($dataFim) ? null : $dataFim;
            $tipo = $object->getTipo();
            $assunto = $object->getAssunto();
            $prorrogacaoPrazo = $object->getProrrogacaoPrazo();
            $prorrogacaoPrazo = empty($prorrogacaoPrazo) ? null : $prorrogacaoPrazo;
            $prorrogacao = $object->getProrrogacao();
            $dataPrazo = $object->getDataPrazo();
            $dataPrazo = empty($dataPrazo) ? null : $dataPrazo;
            $idProcesso = $object->getId();
            // Bind dos parâmetros - 10 strings + 1 inteiro
            $stmt->bind_param(
                    "ssssssssssi",
                    $portaria,
                    $responsavel,
                    $solucao,
                    $dataInicio,
                    $dataFim,
                    $tipo,
                    $assunto,
                    $prorrogacaoPrazo,
                    $prorrogacao,
                    $dataPrazo,
                    $idProcesso
            );
            $sqlOk = $stmt->execute();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Processo WHERE idProcesso = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $idProcesso = $object->getId();
            $stmt->bind_param("i", $idProcesso);
            $sqlOk = $stmt->execute();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = []) {
        try {
            $c = connect();
            $whereClauses = [];
            $params = [];
            $paramTypes = "";
            // Monta os filtros condicionais
            if (isset($filtro) && ($filtro["solucao"] != "todos" || !empty($filtro["tipo"]))) {
                if ($filtro["solucao"] != "todos" && !empty($filtro["solucao"])) {
                    if ($filtro["solucao"] == "concluido") {
                        $whereClauses[] = "solucao != ''";
                    } else if ($filtro["solucao"] == "emandamento") {
                        $whereClauses[] = "solucao = ''";
                    } else if ($filtro["solucao"] == "protocolado") {
                        $whereClauses[] = "solucao = '' AND dataFim IS NOT NULL AND dataFim != ''";
                    } else {
                        $whereClauses[] = "solucao = ''";
                    }
                }
                if (!empty($filtro["tipo"])) {
                    $whereClauses[] = "tipo = ?";
                    $params[] = $filtro["tipo"];
                    $paramTypes .= "s";
                }
            }
            $sql = "SELECT * "
                    . ", DATE_FORMAT(dataInicio, '%d/%m/%Y') as dataInicio, DATE_FORMAT(dataInicio, '%Y/%m/%d') as dataInicioOriginal "
                    . ", DATE_FORMAT(dataFim, '%d/%m/%Y') as dataFim, DATE_FORMAT(dataFim, '%Y/%m/%d') as dataFimOriginal "
                    . ", DATE_FORMAT(prorrogacaoPrazo, '%d/%m/%Y') as prorrogacaoPrazo, DATE_FORMAT(prorrogacaoPrazo, '%Y/%m/%d') as prorrogacaoPrazoOriginal "
                    . ", DATE_FORMAT(dataPrazo, '%d/%m/%Y') as dataPrazo, DATE_FORMAT(dataPrazo, '%Y/%m/%d') as dataPrazoOriginal "
                    . " FROM Processo ";
            if (count($whereClauses) > 0) {
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }
            $sql .= " ORDER BY dataInicio DESC";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            if (!empty($params)) {
                // Passa os parâmetros para o bind_param usando operador splat e referência
                $bindParams = [];
                $bindParams[] = &$paramTypes;
                foreach ($params as $key => $value) {
                    $bindParams[] = &$params[$key];
                }
                call_user_func_array([$stmt, 'bind_param'], $bindParams);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Processo($objectArray);
            }
            $stmt->close();
            $c->close();
            return !empty($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getById($id) {
        if (!is_numeric($id) || $id <= 0) {
            return null;
        }
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", DATE_FORMAT(dataInicio, '%d/%m/%Y') as dataInicioFormatada, DATE_FORMAT(dataInicio, '%Y/%m/%d') as dataInicioOriginal "
                    . ", DATE_FORMAT(dataFim, '%d/%m/%Y') as dataFimFormatada, DATE_FORMAT(dataFim, '%Y/%m/%d') as dataFimOriginal "
                    . ", DATE_FORMAT(prorrogacaoPrazo, '%d/%m/%Y') as prorrogacaoPrazoFormatada, DATE_FORMAT(prorrogacaoPrazo, '%Y/%m/%d') as prorrogacaoPrazoOriginal "
                    . ", DATE_FORMAT(dataPrazo, '%d/%m/%Y') as dataPrazoFormatada, DATE_FORMAT(dataPrazo, '%Y/%m/%d') as dataPrazoOriginal "
                    . " FROM Processo "
                    . " WHERE idProcesso = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Processo($objectArray);
            }
            $stmt->close();
            $c->close();
            return $instance;
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
