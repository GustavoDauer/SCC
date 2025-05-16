<?php

/* * *****************************************************************************
 * 
 * Copyright © 2025 Gustavo Henrique Mello Dauer - 1º Ten 
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
require_once '../Model/AuditoriaVeiculo.php';

class AuditoriaVeiculoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO AuditoriaVeiculo (
                        Veiculo_idVeiculo, dataEntrada, local, autorizacao, preccp, placa, nome
                    ) VALUES (
                        ?, CURRENT_TIME, ?, ?, ?, ?, ?
                    )";
            $stmt = $c->prepare($sql);
            $idVeiculo = $object->getIdVeiculo() > 0 ? $object->getIdVeiculo() : null;
            $local = $object->getLocal();
            $autorizacao = $object->getAutorizacao();
            $preccp = $object->getPreccp();
            $placa = $object->getPlaca();
            $nome = $object->getNome();
            $stmt->bind_param("isssss", $idVeiculo, $local, $autorizacao, $preccp, $placa, $nome);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM AuditoriaVeiculo WHERE idAuditoriaVeiculo = ?";
            $stmt = $c->prepare($sql);
            $id = $object->getId();
            $stmt->bind_param("i", $id);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sqlBase = "SELECT * FROM AuditoriaVeiculo WHERE (dataEntrada >= ? AND dataEntrada <= ?)";
            $params = [];
            $types = "ss";
            $dataHoje = date('Y-m-d');
            $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
            $inicio = !isset($filtro["inicio"]) ? $dataHoje : $filtro["inicio"];
            $fim = !isset($filtro["fim"]) ? $dataAmanha : $filtro["fim"];
            $inicio .= " 00:00";
            $fim .= " 23:59";
            $params[] = $inicio;
            $params[] = $fim;
            if (isset($filtro["autorizacao"]) && $filtro["autorizacao"] == 1) {
                $sqlBase .= " AND autorizacao = ?";
                $types .= "i";
                $params[] = 1;
            }
            $sqlBase .= " ORDER BY dataEntrada";
            $stmt = $c->prepare($sqlBase);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new AuditoriaVeiculo($objectArray);
            }
            $stmt->close();
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idAuditoriaVeiculo"],
            "idVeiculo" => $row["Veiculo_idVeiculo"],
            "dataEntrada" => $row["dataEntrada"],
            "dataSaida" => $row["dataSaida"],
            "local" => $row["local"],
            "autorizacao" => $row["autorizacao"],
            "preccp" => $row["preccp"],
            "placa" => $row["placa"],
            "nome" => $row["nome"]
        );
    }
}
