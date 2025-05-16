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
require_once '../Model/NotaFiscal.php';
require_once 'RequisicaoDAO.php';

class NotaFiscalDAO {

    public function insert($object) {
        try {
            $c = connect();
            $c->begin_transaction();
            // Prepara a query de inserção da NotaFiscal
            $stmt = $c->prepare("
            INSERT INTO `scc`.`NotaFiscal` 
                (`tipoNF`, `nf`, `codigoVerificacao`, `chaveAcesso`, `valorNF`, `descricao`, `dataEmissaoNF`, `dataEntrega`, `dataRemessaTesouraria`, `Requisicao_idRequisicao`, `dataLiquidacao`, `dataPedido`, `dataPrazoEntrega`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
            $tipoNF = $object->getTipoNF();
            $nf = $object->getNf();
            $codigoVerificacao = $object->getCodigoVerificacao();
            $chaveAcesso = $object->getChaveAcesso();
            $valorNF = empty($object->getValorNF()) ? 0.0 : $object->getValorNF();
            $descricao = $object->getDescricao();
            $dataEmissaoNF = !empty($object->getDataEmissaoNF()) ? $object->getDataEmissaoNF() : null;
            $dataEntrega = !empty($object->getDataEntrega()) ? $object->getDataEntrega() : null;
            $dataRemessaTesouraria = !empty($object->getDataRemessaTesouraria()) ? $object->getDataRemessaTesouraria() : null;
            $idRequisicao = !empty($object->getIdRequisicao()) ? $object->getIdRequisicao() : null;
            $dataLiquidacao = !empty($object->getDataLiquidacao()) ? $object->getDataLiquidacao() : null;
            $dataPedido = !empty($object->getDataPedido()) ? $object->getDataPedido() : null;
            $dataPrazoEntrega = !empty($object->getDataPrazoEntrega()) ? $object->getDataPrazoEntrega() : null;
            $stmt->bind_param(
                    "ssssdssssisss",
                    $tipoNF,
                    $nf,
                    $codigoVerificacao,
                    $chaveAcesso,
                    $valorNF,
                    $descricao,
                    $dataEmissaoNF,
                    $dataEntrega,
                    $dataRemessaTesouraria,
                    $idRequisicao,
                    $dataLiquidacao,
                    $dataPedido,
                    $dataPrazoEntrega
            );
            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir Nota Fiscal: " . $stmt->error);
            }
            $idNotaFiscal = $c->insert_id;
            // Inserção dos itens vinculados à nota fiscal
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                $stmtItem = $c->prepare("
                INSERT INTO `scc`.`NotaFiscal_has_Item` (`NotaFiscal_idNotaFiscal`, `Item_idItem`, `quantidade`)
                VALUES (?, ?, ?)
            ");
                foreach ($itemList as $item) {
                    $idItem = $item["idItem"];
                    $quantidadeItem = $item["quantidadeItem"];
                    $stmtItem->bind_param("iii", $idNotaFiscal, $idItem, $quantidadeItem);
                    if (!$stmtItem->execute()) {
                        throw new Exception("Erro ao inserir item da nota fiscal: " . $stmtItem->error);
                    }
                }
                $stmtItem->close();
            }
            $stmt->close();
            $c->commit();
            $c->close();
            return true;
        } catch (Exception $e) {
            if (isset($c) && $c->errno === 0) {
                $c->rollback();
                $c->close();
            }
            throw $e;
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $c->begin_transaction();
            $stmt = $c->prepare("
            UPDATE `scc`.`NotaFiscal` SET
                `tipoNF` = ?, 
                `nf` = ?, 
                `codigoVerificacao` = ?, 
                `chaveAcesso` = ?, 
                `valorNF` = ?, 
                `descricao` = ?, 
                `dataEmissaoNF` = ?, 
                `dataEntrega` = ?, 
                `dataRemessaTesouraria` = ?, 
                `Requisicao_idRequisicao` = ?, 
                `dataLiquidacao` = ?, 
                `dataPedido` = ?, 
                `dataPrazoEntrega` = ?
            WHERE `idNotaFiscal` = ?
        ");
            $tipoNF = $object->getTipoNF();
            $nf = $object->getNf();
            $codigoVerificacao = $object->getCodigoVerificacao();
            $chaveAcesso = $object->getChaveAcesso();
            $valorNF = empty($object->getValorNF()) ? 0.0 : $object->getValorNF();
            $descricao = $object->getDescricao();
            $dataEmissaoNF = !empty($object->getDataEmissaoNF()) ? $object->getDataEmissaoNF() : null;
            $dataEntrega = !empty($object->getDataEntrega()) ? $object->getDataEntrega() : null;
            $dataRemessaTesouraria = !empty($object->getDataRemessaTesouraria()) ? $object->getDataRemessaTesouraria() : null;
            $idRequisicao = !empty($object->getIdRequisicao()) ? $object->getIdRequisicao() : null;
            $dataLiquidacao = !empty($object->getDataLiquidacao()) ? $object->getDataLiquidacao() : null;
            $dataPedido = !empty($object->getDataPedido()) ? $object->getDataPedido() : null;
            $dataPrazoEntrega = !empty($object->getDataPrazoEntrega()) ? $object->getDataPrazoEntrega() : null;
            $idNotaFiscal = $object->getId();
            $stmt->bind_param(
                    "ssssdssssisssi",
                    $tipoNF,
                    $nf,
                    $codigoVerificacao,
                    $chaveAcesso,
                    $valorNF,
                    $descricao,
                    $dataEmissaoNF,
                    $dataEntrega,
                    $dataRemessaTesouraria,
                    $idRequisicao,
                    $dataLiquidacao,
                    $dataPedido,
                    $dataPrazoEntrega,
                    $idNotaFiscal
            );
            if (!$stmt->execute()) {
                throw new Exception("Erro ao atualizar Nota Fiscal: " . $stmt->error);
            }
            // Atualiza ou insere os itens relacionados
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                $updateStmt = $c->prepare("
                UPDATE `scc`.`NotaFiscal_has_Item` 
                SET `quantidade` = ? 
                WHERE `NotaFiscal_idNotaFiscal` = ? AND `Item_idItem` = ?
            ");
                $insertStmt = $c->prepare("
                INSERT INTO `scc`.`NotaFiscal_has_Item` (`NotaFiscal_idNotaFiscal`, `Item_idItem`, `quantidade`) 
                VALUES (?, ?, ?)
            ");
                foreach ($itemList as $item) {
                    $idItem = $item["idItem"];
                    $quantidade = $item["quantidadeItem"];
                    $existe = $this->getByNFIdEItemId($idNotaFiscal, $idItem);
                    if (!is_null($existe)) {
                        $updateStmt->bind_param("iii", $quantidade, $idNotaFiscal, $idItem);
                        if (!$updateStmt->execute()) {
                            throw new Exception("Erro ao atualizar item da nota: " . $updateStmt->error);
                        }
                    } else {
                        $insertStmt->bind_param("iii", $idNotaFiscal, $idItem, $quantidade);
                        if (!$insertStmt->execute()) {
                            throw new Exception("Erro ao inserir novo item da nota: " . $insertStmt->error);
                        }
                    }
                }
                $updateStmt->close();
                $insertStmt->close();
            }
            $stmt->close();
            $c->commit();
            $c->close();
            return true;
        } catch (Exception $e) {
            if (isset($c) && $c->errno === 0) {
                $c->rollback();
                $c->close();
            }
            throw $e;
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $stmt = $c->prepare("DELETE FROM NotaFiscal WHERE idNotaFiscal = ?");
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $c->error);
            }
            $id = $object->getId();
            $stmt->bind_param("i", $id);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            if (isset($c) && $c instanceof mysqli) {
                $c->close();
            }
            throw $e;
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            // Consulta fixa, sem WHERE, conforme código original
            $sql = "SELECT *,
                       REPLACE(valorNF, '.', ',') AS valorNF,
                       DATE_FORMAT(dataLiquidacao, '%d/%m/%Y') as dataLiquidacao
                FROM NotaFiscal";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $c->error);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new NotaFiscal($objectArray);
            }
            $stmt->close();
            $c->close();
            return !empty($lista) ? $lista : null;
        } catch (Exception $e) {
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            if (isset($c) && $c instanceof mysqli) {
                $c->close();
            }
            throw $e;
        }
    }

    public function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT *, 
                       REPLACE(valorNF, '.', ',') AS valorNF 
                FROM NotaFiscal 
                WHERE idNotaFiscal = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $c->error);
            }
            $stmt->bind_param("i", $id); // "i" para inteiro
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new NotaFiscal($objectArray);
            }
            $stmt->close();
            $c->close();
            return $instance;
        } catch (Exception $e) {
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            if (isset($c) && $c instanceof mysqli) {
                $c->close();
            }
            throw $e;
        }
    }

    public function getByRequisicaoId($idRequisicao) {
        try {
            $c = connect();
            $sql = "SELECT *, 
                       REPLACE(valorNF, '.', ',') AS valorNF,
                       DATE_FORMAT(dataLiquidacao, '%d/%m/%Y') AS dataLiquidacao
                FROM NotaFiscal
                WHERE Requisicao_idRequisicao = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $c->error);
            }
            $stmt->bind_param("i", $idRequisicao); // "i" indica inteiro
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new NotaFiscal($objectArray);
            }
            $stmt->close();
            $c->close();
            return !empty($lista) ? $lista : null;
        } catch (Exception $e) {
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            if (isset($c) && $c instanceof mysqli) {
                $c->close();
            }
            throw $e;
        }
    }

    public function getByNFIdEItemId($idNotaFiscal, $idItem) {
        try {
            $c = connect();
            $sql = "SELECT * 
                FROM `scc`.`NotaFiscal_has_Item`
                INNER JOIN NotaFiscal ON idNotaFiscal = NotaFiscal_idNotaFiscal
                WHERE `NotaFiscal_idNotaFiscal` = ? AND `Item_idItem` = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $c->error);
            }
            $stmt->bind_param("ii", $idNotaFiscal, $idItem); // ambos são inteiros
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new NotaFiscal($objectArray);
            }
            $stmt->close();
            $c->close();
            return !empty($lista) ? $lista : null;
        } catch (Exception $e) {
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            if (isset($c) && $c instanceof mysqli) {
                $c->close();
            }
            throw $e;
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idNotaFiscal"],
            "tipoNF" => $row["tipoNF"],
            "nf" => $row["nf"],
            "codigoVerificacao" => $row["codigoVerificacao"],
            "chaveAcesso" => $row["chaveAcesso"],
            "valorNF" => $row["valorNF"],
            "descricao" => $row["descricao"],
            "dataEmissaoNF" => $row["dataEmissaoNF"],
            "dataEntrega" => $row["dataEntrega"],
            "dataRemessaTesouraria" => $row["dataRemessaTesouraria"],
            "idRequisicao" => $row["Requisicao_idRequisicao"],
            "dataLiquidacao" => $row["dataLiquidacao"],
            "dataPedido" => $row["dataPedido"],
            "dataPrazoEntrega" => $row["dataPrazoEntrega"]
        );
    }
}
