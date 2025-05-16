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
require_once '../Model/Baixado.php';

class BaixadoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Baixado (
                        Posto_idPosto, nome, cia, turma, diagnostico, situacao, bi, bar, dispensa, amparo, acao, dataAtualizacao
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE
                    )";
            $stmt = $c->prepare($sql);
            $stmt->bind_param(
                    "ississsssss",
                    $object->getIdPosto(),
                    $object->getNome(),
                    $object->getCia(),
                    $object->getTurma(),
                    $object->getDiagnostico(),
                    $object->getSituacao(),
                    $object->getBi(),
                    $object->getBar(),
                    $object->getDispensa(),
                    $object->getAmparo(),
                    $object->getAcao()
            );
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Baixado SET 
                        Posto_idPosto = ?, nome = ?, cia = ?, turma = ?, diagnostico = ?, 
                        situacao = ?, bi = ?, bar = ?, dispensa = ?, amparo = ?, acao = ?, 
                        dataAtualizacao = CURRENT_DATE
                    WHERE idBaixado = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param(
                    "ississsssssi",
                    $object->getIdPosto(),
                    $object->getNome(),
                    $object->getCia(),
                    $object->getTurma(),
                    $object->getDiagnostico(),
                    $object->getSituacao(),
                    $object->getBi(),
                    $object->getBar(),
                    $object->getDispensa(),
                    $object->getAmparo(),
                    $object->getAcao(),
                    $object->getId()
            );
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
            $sql = "DELETE FROM Baixado WHERE idBaixado = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("i", $object->getId());
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
            $params = [];
            $types = "";
            $sql = "SELECT *, 
                        DATE_FORMAT(dataAtualizacao, '%d/%m/%Y') as dataAtualizacao, 
                        DATE_FORMAT(dataAtualizacao, '%Y/%m/%d') as dataAtualizacaoOriginal 
                    FROM Baixado";
            if (isset($filtro) && $filtro["situacao"] != "todos") {
                if (!empty($filtro["situacao"])) {
                    $sql .= " WHERE situacao LIKE ?";
                    $types .= "s";
                    $params[] = "%" . $filtro["situacao"] . "%";
                }
            }
            $sql .= " ORDER BY dataAtualizacao";
            $stmt = $c->prepare($sql);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Baixado($objectArray);
            }
            $stmt->close();
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT *, 
                        DATE_FORMAT(dataAtualizacao, '%d/%m/%Y') as dataAtualizacaoFormatada, 
                        DATE_FORMAT(dataAtualizacao, '%Y/%m/%d') as dataAtualizacaoOriginal 
                    FROM Baixado 
                    WHERE idBaixado = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Baixado($objectArray);
            }
            $stmt->close();
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idBaixado"],
            "idPosto" => $row["Posto_idPosto"],
            "nome" => $row["nome"],
            "situacao" => $row["situacao"],
            "turma" => $row["turma"],
            "cia" => $row["cia"],
            "amparo" => $row["amparo"],
            "dataAtualizacao" => $row["dataAtualizacao"],
            "dataAtualizacaoOriginal" => $row["dataAtualizacaoOriginal"],
            "diagnostico" => $row["diagnostico"],
            "bi" => $row["bi"],
            "bar" => $row["bar"],
            "dispensa" => $row["dispensa"],
            "acao" => $row["acao"]
        );
    }
}
