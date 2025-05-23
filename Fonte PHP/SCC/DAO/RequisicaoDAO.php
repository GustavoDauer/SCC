<?php

require_once '../Model/Requisicao.php';
require_once '../include/comum.php';

class RequisicaoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $c->begin_transaction();
            // Insert na tabela Requisicao
            $sql = "INSERT INTO `scc`.`Requisicao` (
            dataRequisicao, om, Secao_idSecao, NotaCredito_idNotaCredito, Categoria_idCategoria, modalidade, numeroModalidade,
            ug, omModalidade, empresa, cnpj, contato, dataNE, tipoNE, tipoNF, ne, valorNE, observacaoSALC, dataEnvioNE,
            valorAnulado, justificativaAnulado, valorReforcado, observacaoReforco, NotaCredito_idNotaCreditoReforco, dataParecer,
            parecer, observacaoConformidade, dataAssinatura, dataEnvioNEEmpresa, dataPrazoEntrega, dataOficio, diex,
            dataDiex, Processo_idProcesso, observacaoAlmox, dataProtocoloSalc1, dataProtocoloConformidade, dataProtocoloSalc2,
            dataProtocoloAlmox, responsavel
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar insert Requisicao: " . $c->error);
            }
            // Preparar valores, tratando valores NULL e defaults
            $dataRequisicao = $object->getDataRequisicao() ?: null;
            $om = $object->getOm();
            $secaoId = $object->getIdSecao() ?: null;
            $notaCreditoId = $object->getIdNotaCredito() ?: null;
            $categoriaId = $object->getIdCategoria() ?: null;
            $modalidade = $object->getModalidade();
            $numeroModalidade = $object->getNumeroModalidade();
            $ug = $object->getUg();
            $omModalidade = $object->getOmModalidade();
            $empresa = $object->getEmpresa();
            $cnpj = $object->getCnpj();
            $contato = $object->getContato();
            $dataNE = $object->getDataNE() ?: null;
            $tipoNE = $object->getTipoNE();
            $tipoNF = $object->getTipoNF();
            $ne = $object->getNe();
            $valorNE = $object->getValorNE() ?: 0.0;
            $observacaoSALC = $object->getObservacaoSALC();
            $dataEnvioNE = $object->getDataEnvioNE() ?: null;
            $valorAnulado = $object->getValorAnulado() ?: 0.0;
            $justificativaAnulado = $object->getJustificativaAnulado();
            $valorReforcado = $object->getValorReforcado() ?: 0.0;
            $observacaoReforco = $object->getObservacaoReforco();
            $notaCreditoIdReforco = $object->getIdNotaCreditoReforco() ?: null;
            $dataParecer = $object->getDataParecer() ?: null;
            $parecer = $object->getParecer() ?: null;
            $observacaoConformidade = $object->getObservacaoConformidade();
            $dataAssinatura = $object->getDataAssinatura() ?: null;
            $dataEnvioNEEmpresa = $object->getDataEnvioNEEmpresa() ?: null;
            $dataPrazoEntrega = $object->getDataPrazoEntrega() ?: null;
            $dataOficio = $object->getDataOficio() ?: null;
            $diex = $object->getDiex();
            $dataDiex = $object->getDataDiex() ?: null;
            $processoId = $object->getIdProcesso() ?: null;
            $observacaoAlmox = $object->getObservacaoAlmox();
            $dataProtocoloSalc1 = $object->getDataProtocoloSalc1() ?: null;
            $dataProtocoloConformidade = $object->getDataProtocoloConformidade() ?: null;
            $dataProtocoloSalc2 = $object->getDataProtocoloSalc2() ?: null;
            $dataProtocoloAlmox = $object->getDataProtocoloAlmox() ?: null;
            $responsavel = $object->getResponsavel();
            $stmt->bind_param(
                    "ssiiisiiisssssssdsssssdsssssisssssssssss",
                    $dataRequisicao, $om, $secaoId, $notaCreditoId, $categoriaId, $modalidade, $numeroModalidade,
                    $ug, $omModalidade, $empresa, $cnpj, $contato, $dataNE, $tipoNE, $tipoNF, $ne, $valorNE, $observacaoSALC,
                    $dataEnvioNE, $valorAnulado, $justificativaAnulado, $valorReforcado, $observacaoReforco, $notaCreditoIdReforco,
                    $dataParecer, $parecer, $observacaoConformidade, $dataAssinatura, $dataEnvioNEEmpresa, $dataPrazoEntrega,
                    $dataOficio, $diex, $dataDiex, $processoId, $observacaoAlmox, $dataProtocoloSalc1, $dataProtocoloConformidade,
                    $dataProtocoloSalc2, $dataProtocoloAlmox, $responsavel
            );
            $stmt->execute();
            $lastId = $stmt->insert_id;
            $stmt->close();
            // Inserir os itens
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                $sqlItem = "INSERT INTO `scc`.`Item` (numeroItem, descricao, quantidade, valor, Requisicao_idRequisicao) VALUES (?, ?, ?, ?, ?)";
                $stmtItem = $c->prepare($sqlItem);
                if (!$stmtItem) {
                    throw new Exception("Erro ao preparar insert Item: " . $c->error);
                }
                foreach ($itemList as $item) {
                    $numeroItem = $item->getNumeroItem();
                    $descricao = $item->getDescricao();
                    $quantidade = $item->getQuantidade() ?: 0;
                    $valor = $item->getValor() ?: 0.0;
                    $requisicaoId = $lastId;
                    $stmtItem->bind_param("ssidi", $numeroItem, $descricao, $quantidade, $valor, $requisicaoId);
                    $stmtItem->execute();
                }
                $stmtItem->close();
            }
            $c->commit();
            $c->close();
            return $lastId;
        } catch (Exception $e) {
            if ($c && $c->errno === 0) {
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
            $sql = "UPDATE `scc`.`Requisicao` SET
            dataRequisicao = ?,
            om = ?,
            Secao_idSecao = ?,
            NotaCredito_idNotaCredito = ?,
            Categoria_idCategoria = ?,
            modalidade = ?,
            numeroModalidade = ?,
            ug = ?,
            omModalidade = ?,
            empresa = ?,
            cnpj = ?,
            contato = ?,
            dataNE = ?,
            tipoNE = ?,
            tipoNF = ?,
            ne = ?,
            valorNE = ?,
            observacaoSALC = ?,
            dataEnvioNE = ?,
            valorAnulado = ?,
            justificativaAnulado = ?,
            valorReforcado = ?,
            observacaoReforco = ?,
            NotaCredito_idNotaCreditoReforco = ?,
            dataParecer = ?,
            parecer = ?,
            observacaoConformidade = ?,
            dataAssinatura = ?,
            dataEnvioNEEmpresa = ?,
            dataPrazoEntrega = ?,
            dataOficio = ?,
            diex = ?,
            dataDiex = ?,
            Processo_idProcesso = ?,
            observacaoAlmox = ?,
            dataProtocoloSalc1 = ?,
            dataProtocoloConformidade = ?,
            dataProtocoloSalc2 = ?,
            dataProtocoloAlmox = ?,
            responsavel = ?
            WHERE idRequisicao = ?
        ";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar update Requisicao: " . $c->error);
            }
            // Preparar valores com tratamento de NULL e defaults
            $dataRequisicao = $object->getDataRequisicao() ?: null;
            $om = $object->getOm();
            $secaoId = $object->getIdSecao() ?: null;
            $notaCreditoId = $object->getIdNotaCredito() ?: null;
            $categoriaId = $object->getIdCategoria() ?: null;
            $modalidade = $object->getModalidade();
            $numeroModalidade = $object->getNumeroModalidade();
            $ug = $object->getUg();
            $omModalidade = $object->getOmModalidade();
            $empresa = $object->getEmpresa();
            $cnpj = $object->getCnpj();
            $contato = $object->getContato();
            $dataNE = $object->getDataNE() ?: null;
            $tipoNE = $object->getTipoNE();
            $tipoNF = $object->getTipoNF();
            $ne = $object->getNe();
            $valorNE = $object->getValorNE() ?: 0.0;
            $observacaoSALC = $object->getObservacaoSALC();
            $dataEnvioNE = $object->getDataEnvioNE() ?: null;
            $valorAnulado = $object->getValorAnulado() ?: 0.0;
            $justificativaAnulado = $object->getJustificativaAnulado();
            $valorReforcado = $object->getValorReforcado() ?: 0.0;
            $observacaoReforco = $object->getObservacaoReforco();
            $notaCreditoIdReforco = $object->getIdNotaCreditoReforco() ?: null;
            $dataParecer = $object->getDataParecer() ?: null;
            $parecer = $object->getParecer() ?: null;
            $observacaoConformidade = $object->getObservacaoConformidade();
            $dataAssinatura = $object->getDataAssinatura() ?: null;
            $dataEnvioNEEmpresa = $object->getDataEnvioNEEmpresa() ?: null;
            $dataPrazoEntrega = $object->getDataPrazoEntrega() ?: null;
            $dataOficio = $object->getDataOficio() ?: null;
            $diex = $object->getDiex();
            $dataDiex = $object->getDataDiex() ?: null;
            $processoId = $object->getIdProcesso() ?: null;
            $observacaoAlmox = $object->getObservacaoAlmox();
            $dataProtocoloSalc1 = $object->getDataProtocoloSalc1() ?: null;
            $dataProtocoloConformidade = $object->getDataProtocoloConformidade() ?: null;
            $dataProtocoloSalc2 = $object->getDataProtocoloSalc2() ?: null;
            $dataProtocoloAlmox = $object->getDataProtocoloAlmox() ?: null;
            $responsavel = $object->getResponsavel();
            $idRequisicao = $object->getId();
            // Bind dos parâmetros (note a ordem deve bater com a query!)
            $stmt->bind_param(
                    "ssiiisiiisssssssdsssssdsssssissssssssssi",
                    $dataRequisicao, $om, $secaoId, $notaCreditoId, $categoriaId, $modalidade, $numeroModalidade,
                    $ug, $omModalidade, $empresa, $cnpj, $contato, $dataNE, $tipoNE, $tipoNF, $ne, $valorNE, $observacaoSALC,
                    $dataEnvioNE, $valorAnulado, $justificativaAnulado, $valorReforcado, $observacaoReforco, $notaCreditoIdReforco,
                    $dataParecer, $parecer, $observacaoConformidade, $dataAssinatura, $dataEnvioNEEmpresa, $dataPrazoEntrega,
                    $dataOficio, $diex, $dataDiex, $processoId, $observacaoAlmox, $dataProtocoloSalc1, $dataProtocoloConformidade,
                    $dataProtocoloSalc2, $dataProtocoloAlmox, $responsavel, $idRequisicao
            );
            $stmt->execute();
            $stmt->close();
            // Inserir itens novos vinculados à requisição (não faz update dos itens existentes)
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                $sqlItem = "INSERT INTO `scc`.`Item` (numeroItem, descricao, quantidade, valor, Requisicao_idRequisicao) VALUES (?, ?, ?, ?, ?)";
                $stmtItem = $c->prepare($sqlItem);
                if (!$stmtItem) {
                    throw new Exception("Erro ao preparar insert Item: " . $c->error);
                }
                foreach ($itemList as $item) {
                    $numeroItem = $item->getNumeroItem();
                    $descricao = $item->getDescricao();
                    $quantidade = $item->getQuantidade() ?: 0;
                    $valor = $item->getValor() ?: 0.0;
                    $stmtItem->bind_param("ssidi", $numeroItem, $descricao, $quantidade, $valor, $idRequisicao);
                    $stmtItem->execute();
                }
                $stmtItem->close();
            }
            $c->commit();
            $c->close();
            return true;
        } catch (Exception $e) {
            if ($c && $c->errno === 0) {
                $c->rollback();
                $c->close();
            }
            throw $e;
        }
    }

    function delete($id) {
        try {
            $c = connect();
            $sql = "DELETE FROM Requisicao WHERE idRequisicao = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar delete: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", REPLACE(valorNE, '.', ',') AS valorNE "
                    . ", REPLACE(valorAnulado, '.', ',') AS valorAnulado "
                    . ", REPLACE(valorReforcado, '.', ',') AS valorReforcado "
                    . " FROM Requisicao "
                    . " WHERE idRequisicao = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
                $instance->setHasNFsParaEntrega($this->checkNFSemEntrega($id));
                $instance->setHasNFsParaLiquidar($this->checkNFSemLiquidar($id));
                $instance->setHasNFsParaRemessa($this->checkNFSemRemessa($id));
            }
            $stmt->close();
            $c->close();
            return $instance;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllList($filtro = []) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " LEFT JOIN NotaCredito ON NotaCredito_idNotaCredito = idNotaCredito "
                    . " LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao ";
            $conditions = [];
            $params = [];
            $types = "";
            // Filtro por ano
            if (!empty($filtro["ano"]) && $filtro["ano"] > 0) {
                $conditions[] = "(dataNE >= ? AND dataNE <= ? OR dataNE IS NULL OR dataNE = '')";
                $params[] = $filtro["ano"] . "-01-01";
                $params[] = $filtro["ano"] . "-12-31";
                $types .= "ss";
            }
            // Filtro idSecao
            if (!empty($filtro["idSecao"]) && $filtro["idSecao"] > 0) {
                $conditions[] = "Secao_idSecao = ?";
                $params[] = $filtro["idSecao"];
                $types .= "i";
            }
            // Filtro idNotaCredito
            if (!empty($filtro["idNotaCredito"]) && $filtro["idNotaCredito"] > 0) {
                $conditions[] = "NotaCredito_idNotaCredito = ?";
                $params[] = $filtro["idNotaCredito"];
                $types .= "i";
            }
            // Filtro ug
            if (!empty($filtro["ug"])) {
                $conditions[] = "NotaCredito.ug = ?";
                $params[] = $filtro["ug"];
                $types .= "s";
            }
            // Filtro ne LIKE
            if (!empty($filtro["ne"])) {
                $conditions[] = "ne LIKE ?";
                $params[] = "%" . $filtro["ne"] . "%";
                $types .= "s";
            }
            // Filtro materiaisEntregues = 1 (true)
            if (isset($filtro["materiaisEntregues"]) && $filtro["materiaisEntregues"] === 1) {
                $conditions[] = "(dataEntrega != '' AND dataEntrega IS NOT NULL)";
            }
            // Filtro materiaisEntregues = 0 (false)
            if (isset($filtro["materiaisEntregues"]) && $filtro["materiaisEntregues"] === 0) {
                $conditions[] = "(dataEntrega = '' OR dataEntrega IS NULL)";
            }
            if (count($conditions) > 0) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            $sql .= " GROUP BY idRequisicao "
                    . " ORDER BY dataNE, dataRequisicao";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            if (!empty($params)) {
                // Bind dinâmico dos parâmetros
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $object = new Requisicao($objectArray);
                $object->setHasNFsParaEntrega($this->checkNFSemEntrega($object->getId()));
                $object->setHasNFsParaLiquidar($this->checkNFSemLiquidar($object->getId()));
                $object->setHasNFsParaRemessa($this->checkNFSemRemessa($object->getId()));
                $lista[] = $object;
            }
            $stmt->close();
            $c->close();
            return !empty($lista) ? $lista : null;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function checkNFSemEntrega($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao "
                    . " WHERE idRequisicao = ? AND (dataEntrega = '' OR dataEntrega IS NULL) "
                    . " GROUP BY idRequisicao";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
            }
            $stmt->close();
            $c->close();
            return isset($instance);
        } catch (Exception $e) {
            throw $e;
        }
    }

    function checkNFSemLiquidar($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao "
                    . " WHERE idRequisicao = ? AND (dataLiquidacao = '' OR dataLiquidacao IS NULL) "
                    . " GROUP BY idRequisicao";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
            }
            $stmt->close();
            $c->close();
            return isset($instance);
        } catch (Exception $e) {
            throw $e;
        }
    }

    function checkNFSemRemessa($id) {
        try {
            $c = connect();
            $sql = "SELECT * 
                FROM Requisicao 
                LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao 
                WHERE idRequisicao = ? AND (dataRemessaTesouraria = '' OR dataRemessaTesouraria IS NULL) 
                GROUP BY idRequisicao";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
            }
            $stmt->close();
            $c->close();
            return isset($instance);
        } catch (Exception $e) {
            throw $e;
        }
    }

    function getTotalItensQuantity($id) {
        try {
            $c = connect();
            $sql = "SELECT SUM(quantidade) as quantidade
                FROM Requisicao
                INNER JOIN Item ON Requisicao_idRequisicao = idRequisicao
                WHERE idRequisicao = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $quantidade = 0;
            if ($row = $result->fetch_assoc()) {
                $quantidade = $row["quantidade"] ?? 0;
            }
            $stmt->close();
            $c->close();
            return $quantidade;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function getTotalItensUsed($id) {
        try {
            $c = connect();
            $sql = "SELECT SUM(NotaFiscal_has_Item.quantidade) as quantidade
                FROM Requisicao
                LEFT JOIN Item ON Requisicao_idRequisicao = idRequisicao
                LEFT JOIN NotaFiscal_has_Item ON Item_idItem = IdItem
                WHERE idRequisicao = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $quantidade = 0;
            if ($row = $result->fetch_assoc()) {
                $quantidade = $row["quantidade"] ?? 0;
            }
            $stmt->close();
            $c->close();
            return $quantidade;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function getTotalItensLiquidado($id) {
        try {
            $c = connect();
            $sql = "SELECT SUM(NotaFiscal_has_Item.quantidade) as quantidade
                FROM NotaFiscal_has_Item
                INNER JOIN NotaFiscal ON NotaFiscal_idNotaFiscal = idNotaFiscal
                INNER JOIN Requisicao ON idRequisicao = ?
                WHERE dataLiquidacao != '' AND dataLiquidacao IS NOT NULL";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar consulta: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $quantidade = 0;
            if ($row = $result->fetch_assoc()) {
                $quantidade = $row["quantidade"] ?? 0;
            }
            $stmt->close();
            $c->close();
            return $quantidade;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function fillArray($row) {
        return array(
            "id" => $row["idRequisicao"],
            "dataRequisicao" => $row["dataRequisicao"],
            "om" => $row["om"],
            "idSecao" => $row["Secao_idSecao"],
            "idNotaCredito" => $row["NotaCredito_idNotaCredito"],
            "idCategoria" => $row["Categoria_idCategoria"],
            "modalidade" => $row["modalidade"],
            "numeroModalidade" => $row["numeroModalidade"],
            "ug" => $row["ug"],
            "omModalidade" => $row["omModalidade"],
            "empresa" => $row["empresa"],
            "cnpj" => $row["cnpj"],
            "contato" => $row["contato"],
            "dataNE" => $row["dataNE"],
            "tipoNE" => $row["tipoNE"],
            "tipoNF" => $row["tipoNF"],
            "ne" => $row["ne"],
            "valorNE" => $row["valorNE"],
            "observacaoSALC" => $row["observacaoSALC"],
            "dataEnvioNE" => $row["dataEnvioNE"],
            "valorAnulado" => $row["valorAnulado"],
            "justificativaAnulado" => $row["justificativaAnulado"],
            "valorReforcado" => $row["valorReforcado"],
            "observacaoReforco" => $row["observacaoReforco"],
            "idNotaCreditoReforco" => $row["NotaCredito_idNotaCreditoReforco"],
            "dataParecer" => $row["dataParecer"],
            "parecer" => $row["parecer"],
            "observacaoConformidade" => $row["observacaoConformidade"],
            "dataAssinatura" => $row["dataAssinatura"],
            "dataEnvioNEEmpresa" => $row["dataEnvioNEEmpresa"],
            "dataPrazoEntrega" => $row["dataPrazoEntrega"],
            "diex" => $row["diex"],
            "dataDiex" => $row["dataDiex"],
            "dataOficio" => $row["dataOficio"],
            "observacaoAlmox" => $row["observacaoAlmox"],
            "idProcesso" => $row["Processo_idProcesso"],
            "dataProtocoloSalc1" => $row["dataProtocoloSalc1"],
            "dataProtocoloConformidade" => $row["dataProtocoloConformidade"],
            "dataProtocoloSalc2" => $row["dataProtocoloSalc2"],
            "dataProtocoloAlmox" => $row["dataProtocoloAlmox"],
            "responsavel" => $row["responsavel"],
            "itemList" => ""
        );
    }
}
