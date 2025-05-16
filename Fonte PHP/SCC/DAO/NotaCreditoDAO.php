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
require_once '../Model/NotaCredito.php';

class NotaCreditoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO `scc`.`NotaCredito` 
                (`dataNc`, `nc`, `pi`, `valor`, `gestorNc`, `ptres`, `fonte`, `ug`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar insert: " . $c->error);
            }
            $stmt->bind_param(
                    "ssssssss",
                    $object->getDataNc(),
                    $object->getNc(),
                    $object->getPi(),
                    $object->getValor(),
                    $object->getGestorNc(),
                    $object->getPtres(),
                    $object->getFonte(),
                    $object->getUg()
            );
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE `scc`.`NotaCredito` SET
                `dataNc` = ?, 
                `nc` = ?, 
                `pi` = ?, 
                `valor` = ?, 
                `gestorNc` = ?, 
                `ptres` = ?, 
                `fonte` = ?, 
                `ug` = ?
                WHERE `idNotaCredito` = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar update: " . $c->error);
            }
            $stmt->bind_param(
                    "ssssssssi",
                    $object->getDataNc(),
                    $object->getNc(),
                    $object->getPi(),
                    $object->getValor(),
                    $object->getGestorNc(),
                    $object->getPtres(),
                    $object->getFonte(),
                    $object->getUg(),
                    $object->getId()
            );
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM NotaCredito WHERE idNotaCredito = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar delete: " . $c->error);
            }
            $stmt->bind_param("i", $object->getId());
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sql = "SELECT *, SUM(valorNE) AS totalEmpenhado "
                    . ", REPLACE(valor, '.', ',') AS valor "
                    . ", REPLACE(valorRecolhido, '.', ',') AS valorRecolhido "
                    //. ", DATE_FORMAT(dataNc, '%d/%m/%Y') as dataNc "
                    . " FROM NotaCredito "
                    . " LEFT JOIN Requisicao ON idNotaCredito = NotaCredito_idNotaCredito ";
            // BUG - VERIFICAR
//            if (
//                    $filtro["idNotaCredito"] > 0 ||
//                    $filtro["ano"] > 0
//            ) {
//                $sql .= " WHERE ";
//                if ($filtro["ano"] > 0) {
//                    $sql .= " dataNc >= '" . $filtro["ano"] . "-01-01' AND dataNc <= '" . $filtro["ano"] . "-12-31' ";
//                }
//                if ($filtro["idNotaCredito"] > 0) {
//                    if ($filtro["ano"] > 0) {
//                        $sql .= " AND ";
//                    }
//                    $sql .= " idNotaCredito = " . $filtro["idNotaCredito"];
//                }
//            }
//            $sql .= " GROUP BY idNotaCredito ";
//            $sql .= ($filtro["notaCreditoAtivas"] === 0 || $filtro["notaCreditoAtivas"] === 1) ? 
//                    " HAVING SUM(valorNE) " . ($filtro["notaCreditoAtivas"] === 0 ? ">=" : "<") . " NotaCredito.valor " . (($filtro["notaCreditoAtivas"] === 1) ? " || SUM(valorNE) IS NULL " : "") : "";
//            $sql .= " ORDER BY dataNc";               
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $object = new NotaCredito($objectArray);
                $object->setTotalEmpenhado($row["totalEmpenhado"]);
                $lista[] = $object;
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
            $sql = "SELECT *, REPLACE(valor, '.', ',') AS valor 
                    FROM NotaCredito WHERE idNotaCredito = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar getById: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new NotaCredito($objectArray);
            }
            $stmt->close();
            $c->close();
            return $instance;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idNotaCredito"],
            "dataNc" => $row["dataNc"],
            "nc" => $row["nc"],
            "pi" => $row["pi"],
            "valor" => $row["valor"],
            "gestorNc" => $row["gestorNc"],
            "ptres" => $row["ptres"],
            "fonte" => $row["fonte"],
            "ug" => $row["ug"],
            "valorRecolhido" => $row["valorRecolhido"]
        );
    }
}
