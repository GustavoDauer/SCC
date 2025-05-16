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
require_once '../Model/Item.php';

class ItemDAO {

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Item WHERE idItem = ?";
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

    public function getByRequisicaoId($id) {
        try {
            $c = connect();
            $sql = "SELECT *, REPLACE(valor, '.', ',') AS valor
                    FROM Item
                    WHERE Requisicao_idRequisicao = ?
                    ORDER BY numeroItem";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Item($objectArray);
            }
            $stmt->close();
            $c->close();
            return $lista ?? null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getByNotaFiscalId($id) {
        try {
            $c = connect();
            $sql = "SELECT Item.*, REPLACE(valor, '.', ',') AS valor
                    FROM NotaFiscal_has_Item
                    INNER JOIN Item ON Item_idItem = idItem
                    WHERE NotaFiscal_idNotaFiscal = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Item($objectArray);
            }
            $stmt->close();
            $c->close();
            return $lista ?? null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getTotalQuantidade($idItem) {
        try {
            $c = connect();
            $sql = "SELECT SUM(quantidade) as total
                    FROM NotaFiscal_has_Item
                    WHERE Item_idItem = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("i", $idItem);
            $stmt->execute();
            $result = $stmt->get_result();
            $total = null;
            if ($row = $result->fetch_assoc()) {
                $total = $row["total"];
            }
            $stmt->close();
            $c->close();
            return $total;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getQuantidadeByItemIdENFId($idItem, $idNF) {
        try {
            $c = connect();
            $sql = "SELECT idItem, numeroItem, descricao, valor, Requisicao_idRequisicao,
                           NotaFiscal_has_Item.quantidade as quantidade
                    FROM NotaFiscal_has_Item
                    INNER JOIN Item ON Item_idItem = idItem
                    WHERE Item_idItem = ? AND NotaFiscal_idNotaFiscal = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("ii", $idItem, $idNF);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Item($objectArray);
            }
            $stmt->close();
            $c->close();
            return $instance;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getQuantidadeByItem($idItem) {
        try {
            $c = connect();
            $sql = "SELECT idItem, numeroItem, descricao, valor, Requisicao_idRequisicao,
                           NotaFiscal_has_Item.quantidade as quantidade
                    FROM NotaFiscal_has_Item
                    INNER JOIN Item ON Item_idItem = idItem
                    WHERE Item_idItem = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("i", $idItem);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Item($objectArray);
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
            "id" => $row["idItem"],
            "numeroItem" => $row["numeroItem"],
            "descricao" => $row["descricao"],
            "quantidade" => $row["quantidade"],
            "valor" => $row["valor"],
            "idRequisicao" => $row["Requisicao_idRequisicao"]
        );
    }
}
