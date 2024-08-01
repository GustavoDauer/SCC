<?php

require_once '../include/global.php';
require_once '../include/comum.php';
require_once '../Model/Requisicao.php';
require_once '../DAO/RequisicaoDAO.php';
require_once '../DAO/NotaCreditoDAO.php';
require_once '../DAO/SecaoDAO.php';
require_once '../DAO/CategoriaDAO.php';
require_once '../DAO/ItemDAO.php';
require_once '../DAO/NotaFiscalDAO.php';
require_once '../DAO/ProcessoDAO.php';
require_once '../Model/Timeline.php';

class FiscalizacaoController {

    private $requisicaoInstance, $itemInstance, $notaCreditoInstance, $notaFiscalInstance;

    function getFormData() {
        // Liberar campos obrigatórios para uso da Tesouraria
        $today = date('Y-m-d');
        // FILTROS
        $this->filtro = array(
            "idSecao" => filter_input(INPUT_GET, "idSecao", FILTER_VALIDATE_INT),
            "idNotaCredito" => filter_input(INPUT_GET, "idNotaCredito", FILTER_VALIDATE_INT),
            "ug" => filter_input(INPUT_GET, "ug", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES),
            "ne" => filter_input(INPUT_GET, "ne", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES),
            "materiaisEntregues" => filter_input(INPUT_GET, "materiaisEntregues", FILTER_VALIDATE_INT),
            "ano" => filter_input(INPUT_GET, "ano", FILTER_VALIDATE_INT),
            "notaCreditoAtivas" => filter_input(INPUT_GET, "notaCreditoAtivas", FILTER_VALIDATE_INT)
        );
        // REQUISIÇÃO
        $this->requisicaoInstance = new Requisicao();
        $id = empty(filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT)) ? filter_input(INPUT_POST, "idRequisicao", FILTER_VALIDATE_INT) : filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $id = !empty($id) ? $id : filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        $this->requisicaoInstance->setId(!empty($id) ? $id : (filter_input(INPUT_GET, "idRequisicao", FILTER_VALIDATE_INT)));
        $this->requisicaoInstance->setDataRequisicao(filter_input(INPUT_POST, "dataRequisicao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setOm(filter_input(INPUT_POST, "om", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setIdSecao(filter_input(INPUT_POST, "idSecao", FILTER_VALIDATE_INT));
        $this->requisicaoInstance->setIdNotaCredito(filter_input(INPUT_POST, "idNotaCredito", FILTER_VALIDATE_INT));
        $this->requisicaoInstance->setIdCategoria(filter_input(INPUT_POST, "idCategoria", FILTER_VALIDATE_INT));
        $this->requisicaoInstance->setModalidade(filter_input(INPUT_POST, "modalidade", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $numeroModalidade = filter_input(INPUT_POST, "numeroModalidade", FILTER_VALIDATE_INT);
        $this->requisicaoInstance->setNumeroModalidade(is_int($numeroModalidade) ? $numeroModalidade : 0);
        $ug = filter_input(INPUT_POST, "ug", FILTER_VALIDATE_INT);
        $this->requisicaoInstance->setUg(is_int($ug) ? $ug : 0);
        $this->requisicaoInstance->setOmModalidade(filter_input(INPUT_POST, "omModalidade", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setEmpresa(filter_input(INPUT_POST, "empresa", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setCnpj(filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setContato(filter_input(INPUT_POST, 'contato', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataProtocoloSalc1(filter_input(INPUT_POST, "dataProtocoloSalc1", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        // SALC
        $this->requisicaoInstance->setDataNE(filter_input(INPUT_POST, "dataNE", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setTipoNE(filter_input(INPUT_POST, "tipoNE", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setTipoNF(filter_input(INPUT_POST, "tipoNF", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setNe(filter_input(INPUT_POST, "ne", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setValorNE(str_replace(",", ".", filter_input(INPUT_POST, "valorNE", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->requisicaoInstance->setObservacaoSALC(filter_input(INPUT_POST, 'observacaoSALC', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataEnvioNE(filter_input(INPUT_POST, "dataEnvioNE", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setValorAnulado(str_replace(",", ".", filter_input(INPUT_POST, "valorAnulado", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->requisicaoInstance->setJustificativaAnulado(filter_input(INPUT_POST, 'justificativaAnulado', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setValorReforcado(str_replace(",", ".", filter_input(INPUT_POST, "valorReforcado", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->requisicaoInstance->setObservacaoReforco(filter_input(INPUT_POST, 'observacaoReforco', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setIdNotaCreditoReforco(filter_input(INPUT_POST, "idNotaCreditoReforco", FILTER_VALIDATE_INT));
        $this->requisicaoInstance->setDataProtocoloConformidade(filter_input(INPUT_POST, "dataProtocoloConformidade", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataProtocoloAlmox(filter_input(INPUT_POST, "dataProtocoloAlmox", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setResponsavel(filter_input(INPUT_POST, "responsavel", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        // CONFORMIDADE
        $this->requisicaoInstance->setDataParecer(filter_input(INPUT_POST, "dataParecer", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setParecer(filter_input(INPUT_POST, "parecer", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setObservacaoConformidade(filter_input(INPUT_POST, 'observacaoConformidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataAssinatura(filter_input(INPUT_POST, "dataAssinatura", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataProtocoloSalc2(filter_input(INPUT_POST, "dataProtocoloSalc2", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        // ALMOXARIFADO        
        $this->requisicaoInstance->setDataEnvioNEEmpresa(filter_input(INPUT_POST, "dataEnvioNEEmpresa", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataPrazoEntrega(filter_input(INPUT_POST, "dataPrazoEntrega", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataOficio(filter_input(INPUT_POST, "dataOficio", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDiex(filter_input(INPUT_POST, "diex", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataDiex(filter_input(INPUT_POST, "dataDiex", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setIdProcesso(filter_input(INPUT_POST, "idProcesso", FILTER_VALIDATE_INT));
        $this->requisicaoInstance->setObservacaoAlmox(filter_input(INPUT_POST, "observacaoAlmox", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        // ITEM   
        $itemList = null;
        $item = new Item();
        $idItem = filter_input(INPUT_GET, "idItem", FILTER_VALIDATE_INT);
        $item->setId(empty($idItem) ? filter_input(INPUT_POST, "idItem", FILTER_VALIDATE_INT) : $idItem);
        $item->setNumeroItem(filter_input(INPUT_POST, "numeroItem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $item->setDescricao(filter_input(INPUT_POST, "descricaoItem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $item->setQuantidade(filter_input(INPUT_POST, "quantidade", FILTER_VALIDATE_INT));
        $item->setValor(str_replace(",", ".", filter_input(INPUT_POST, "valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $item->setIdRequisicao(filter_input(INPUT_POST, "idRequisicao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        if (!empty($item->getNumeroItem())) {
            $itemList[] = $item;
        }
        $this->itemInstance = $item;
        $i = 1;
        while (true) {
            if (empty(filter_input(INPUT_POST, "numeroItem$i", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES))) {
                break;
            }
            $item = new Item();
            $item->setId(filter_input(INPUT_POST, "idItem$i", FILTER_VALIDATE_INT));
            $item->setNumeroItem(filter_input(INPUT_POST, "numeroItem$i", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
            $item->setDescricao(filter_input(INPUT_POST, "descricaoItem$i", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
            $item->setQuantidade(filter_input(INPUT_POST, "quantidade$i", FILTER_VALIDATE_INT));
            $item->setValor(str_replace(",", ".", filter_input(INPUT_POST, "valor$i", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
            $item->setIdRequisicao(filter_input(INPUT_POST, "idRequisicao$i", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
            $itemList[] = $item;
            $i++;
        }
        $this->requisicaoInstance->setItemList($itemList);
        // NOTA FISCAL
        $this->notaFiscalInstance = new NotaFiscal();
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $this->notaFiscalInstance->setId(!empty($id) ? $id : (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT)));
        $this->notaFiscalInstance->setTipoNF(filter_input(INPUT_POST, "tipoNF", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setNf(filter_input(INPUT_POST, "nf", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setCodigoVerificacao(filter_input(INPUT_POST, "codigoVerificacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setChaveAcesso(filter_input(INPUT_POST, "chaveAcesso", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setValorNF(str_replace(",", ".", filter_input(INPUT_POST, "valorNF", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->notaFiscalInstance->setDescricao(filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setDataEmissaoNF(filter_input(INPUT_POST, "dataEmissaoNF", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setDataEntrega(filter_input(INPUT_POST, "dataEntrega", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setDataRemessaTesouraria(filter_input(INPUT_POST, "dataRemessaTesouraria", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $idRequisicao = filter_input(INPUT_POST, "idRequisicao", FILTER_VALIDATE_INT);
        $this->notaFiscalInstance->setIdRequisicao(!empty($idRequisicao) ? $idRequisicao : filter_input(INPUT_GET, "idRequisicao", FILTER_VALIDATE_INT));
        $this->notaFiscalInstance->setDataLiquidacao(filter_input(INPUT_POST, "dataLiquidacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setDataPedido(filter_input(INPUT_POST, "dataPedido", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaFiscalInstance->setDataPrazoEntrega(filter_input(INPUT_POST, "dataPrazoEntrega", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        // Quantidade a ser inserida em NotaFiscal_has_Item
        $i = 1;
        $idItem = filter_input(INPUT_POST, "idItem$i", FILTER_VALIDATE_INT);
        $reqItemList = null;
        while (!is_null($idItem)) {
            $idNotaFiscal = filter_input(INPUT_POST, "idNotaFiscal$i", FILTER_VALIDATE_INT);
            $quantidadeItem = filter_input(INPUT_POST, "quantidadeItem$i", FILTER_VALIDATE_INT);
            $quantidadeItem = is_int($quantidadeItem) ? $quantidadeItem : 0;
            $idItem = filter_input(INPUT_POST, "idItem$i", FILTER_VALIDATE_INT);
            $reqItemList[] = array(
                "idNotaFiscal" => $idNotaFiscal,
                "quantidadeItem" => $quantidadeItem,
                "idItem" => $idItem
            );
            $i++;
            $idItem = filter_input(INPUT_POST, "idItem$i", FILTER_VALIDATE_INT);
        }
        $this->notaFiscalInstance->setItemList($reqItemList);
        // SEÇÃO
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        // NC
        $this->notaCreditoInstance = new NotaCredito();
        $this->notaCreditoInstance->setId(!empty($id) ? $id : (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT)));
        $this->notaCreditoInstance->setDataNc(filter_input(INPUT_POST, "dataNc", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setNc(filter_input(INPUT_POST, "nc", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setPi(filter_input(INPUT_POST, "pi", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setValor(str_replace(",", ".", filter_input(INPUT_POST, "valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->notaCreditoInstance->setGestorNc(filter_input(INPUT_POST, "gestorNc", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setPtres(filter_input(INPUT_POST, "ptres", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setFonte(filter_input(INPUT_POST, "fonte", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setUg(filter_input(INPUT_POST, "ug", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
    }

    function insert() {
        try {
            $this->getFormData();
            $requisicaoDAO = new RequisicaoDAO();
            $secaoDAO = new SecaoDAO();
            $categoriaDAO = new CategoriaDAO();
            $notaCreditoDAO = new NotaCreditoDAO();
            $processoDAO = new ProcessoDAO();
            if (!empty($this->requisicaoInstance->getDataRequisicao())) { // validation                
                if ($requisicaoDAO->insert($this->requisicaoInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=getAllList");
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // view redirection
                $object = $this->requisicaoInstance;
                $secaoList = $secaoDAO->getAllList();
                $categoriaList = $categoriaDAO->getAllList();
                $processoList = $processoDAO->getAllList(array("solucao" => "emandamento", "tipo" => "Processo Administrativo"));
                require_once '../View/view_requisicao_novo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function delete() {
        try {
            $this->getFormData();
            $requisicaoDAO = new RequisicaoDAO();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->requisicaoInstance->getId())) {
                if ($requisicaoDAO->delete($this->requisicaoInstance->getId())) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=getAllList");
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function update() {
        try {
            $this->getFormData();
            $requisicaoDAO = new RequisicaoDAO();
            $secaoDAO = new SecaoDAO();
            $notaCreditoDAO = new NotaCreditoDAO();
            $categoriaDAO = new CategoriaDAO();
            $notaFiscalDAO = new NotaFiscalDAO();
            $processoDAO = new ProcessoDAO();
            if (!empty($this->requisicaoInstance->getDataRequisicao())) {
                if ($requisicaoDAO->update($this->requisicaoInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=getAllList");
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else {
                $itemDAO = new ItemDAO();
                $itemList = $itemDAO->getByRequisicaoId($this->requisicaoInstance->getId());
                $object = $requisicaoDAO->getById($this->requisicaoInstance->getId());
                $secaoList = $secaoDAO->getAllList();
                $categoriaList = $categoriaDAO->getAllList();
                $processoList = $processoDAO->getAllList(array("solucao" => "emandamento", "tipo" => "Processo Administrativo"));
                $notaFiscalList = $notaFiscalDAO->getByRequisicaoId($this->requisicaoInstance->getId());
                require_once '../View/view_requisicao_novo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function itemDelete() {
        try {
            $this->getFormData();
            $itemDAO = new ItemDAO();
            if (!empty($this->itemInstance->getId())) {
                if ($itemDAO->delete($this->itemInstance)) {
                    header("Location: FiscalizacaoController.php?action=update&id=" . $this->requisicaoInstance->getId());
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function getAllList() {
        try {
            $this->getFormData();
            $requisicaoDAO = new RequisicaoDAO();
            $secaoDAO = new SecaoDAO();
            $notaCreditoDAO = new NotaCreditoDAO();
            $itemDAO = new ItemDAO();
            $notaCreditoList = $notaCreditoDAO->getAllList($this->filtro);
            $objectList = $requisicaoDAO->getAllList($this->filtro);
            $secaoList = $secaoDAO->getAllList($this->filtro);
            require_once '../View/view_requisicao_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function notaCreditoInsert() {
        try {
            $this->getFormData();
            $notaCreditoDAO = new NotaCreditoDAO();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->notaCreditoInstance->getNc())) { // validation
                if ($notaCreditoDAO->insert($this->notaCreditoInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=getAllList");
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // view redirection
                $object = $this->notaCreditoInstance;
                $secaoList = $secaoDAO->getAllList();
                require_once '../View/view_notaCredito_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function notaCreditoDelete() {
        try {
            $this->getFormData();
            $notaCreditoDAO = new NotaCreditoDAO();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->notaCreditoInstance->getId())) {
                if ($notaCreditoDAO->delete($this->notaCreditoInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=getAllList");
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function notaCreditoUpdate() {
        try {
            $this->getFormData();
            $notaCreditoDAO = new NotaCreditoDAO();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->notaCreditoInstance->getNc())) {
                if ($notaCreditoDAO->update($this->notaCreditoInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=getAllList");
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else {
                $object = $notaCreditoDAO->getById($this->notaCreditoInstance->getId());
                require_once '../View/view_notaCredito_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function notaFiscalInsert() {
        try {
            $this->getFormData();            
            /* 
               Checar se o ID da requisicao = 0 e fazer a inserção automática de
               uma requisição redirecionando para o cadastro de notas fiscais 
               para a respectiva requisição
               Caso não o id da requisicao > 0, executar o fluxo normalmente 
             */
            if ($this->requisicaoInstance->getId() == 0) {
                $requisicaoDAO = new RequisicaoDAO();
                $this->requisicaoInstance->setDataRequisicao(date('Y-m-d'));
                $this->requisicaoInstance->setTipoNE("ordinario");
                $this->requisicaoInstance->setTipoNF("material");
                $lastId = $requisicaoDAO->insert($this->requisicaoInstance);
                if ($lastId > 0) {
                    header("Location: FiscalizacaoController.php?action=insert_nf&idRequisicao=" . $lastId);
                }
                else {
                    throw new Exception("Problema na execução de inserção automática de dados!");
                }                
            }
            $notaFiscalDAO = new NotaFiscalDAO();
            $secaoDAO = new SecaoDAO();
            $itemDAO = new ItemDAO();
            if (!empty($this->notaFiscalInstance->getTipoNf())) { // validation
                if ($notaFiscalDAO->insert($this->notaFiscalInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=update&id=" . $this->notaFiscalInstance->getIdRequisicao() . "#notasFiscais");
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // view redirection
                $object = $this->notaFiscalInstance;
                $secaoList = $secaoDAO->getAllList();
                $notaFiscalItemList = $itemDAO->getByRequisicaoId($this->notaFiscalInstance->getIdRequisicao());
                require_once '../View/view_requisicao_nf_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function notaFiscalUpdate() {
        try {
            $this->getFormData();
            $notaFiscalDAO = new NotaFiscalDAO();
            $secaoDAO = new SecaoDAO();
            $itemDAO = new ItemDAO();
            if (!empty($this->notaFiscalInstance->getTipoNf())) {
                if ($notaFiscalDAO->update($this->notaFiscalInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=update&id=" . $this->notaFiscalInstance->getIdRequisicao() . "#notasFiscais");
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else {
                $object = $notaFiscalDAO->getById($this->notaFiscalInstance->getId());
                $notaFiscalItemList = $itemDAO->getByRequisicaoId($object->getIdRequisicao());
                require_once '../View/view_requisicao_nf_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function notaFiscalDelete() {
        try {
            $this->getFormData();
            $notaFiscalDAO = new NotaFiscalDAO();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->notaFiscalInstance->getId())) {
                $this->notaFiscalInstance = $notaFiscalDAO->getById($this->notaFiscalInstance->getId());
                if ($notaFiscalDAO->delete($this->notaFiscalInstance)) {
                    $secaoDAO->updateDataAtualizacao("Fiscalizacao");
                    header("Location: FiscalizacaoController.php?action=update&id=" . $this->notaFiscalInstance->getIdRequisicao() . "#notasFiscais");
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database
     */
    public function mensagemUpdate() {
        try {
            $this->getFormData();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->mensagem)) {
                $secaoDAO->updateDataAtualizacao("Fiscalizacao", $this->mensagem);
            }
            header("Location: FiscalizacaoController.php?action=getAllList");
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }
}

$action = $_REQUEST["action"];
$controller = new FiscalizacaoController();
switch ($action) {
    case "insert":!isAdminLevel($ADICIONAR_FISCALIZACAO) ? redirectToLogin() : $controller->insert();
        break;
    case "update":!isAdminLevel($EDITAR_FISCALIZACAO) ? redirectToLogin() : $controller->update();
        break;
    case "delete":!isAdminLevel($EXCLUIR_FISCALIZACAO) ? redirectToLogin() : $controller->delete();
        break;
    case "getAllList":!isAdminLevel($LISTAR_FISCALIZACAO) ? redirectToLogin() : $controller->getAllList();
        break;
    case "insert_nc":!isAdminLevel($ADICIONAR_FISCALIZACAO_NC) ? redirectToLogin() : $controller->notaCreditoInsert();
        break;
    case "update_nc":!isAdminLevel($EDITAR_FISCALIZACAO_NC) ? redirectToLogin() : $controller->notaCreditoUpdate();
        break;
    case "delete_nc":!isAdminLevel($EXCLUIR_FISCALIZACAO_NC) ? redirectToLogin() : $controller->notaCreditoDelete();
        break;
    case "delete_item":!isAdminLevel($EDITAR_FISCALIZACAO_NC) ? redirectToLogin() : $controller->itemDelete();
        break;
    case "insert_nf":!isAdminLevel($EDITAR_FISCALIZACAO) ? redirectToLogin() : $controller->notaFiscalInsert();
        break;
    case "update_nf":!isAdminLevel($EDITAR_FISCALIZACAO) ? redirectToLogin() : $controller->notaFiscalUpdate();
        break;
    case "delete_nf":!isAdminLevel($EDITAR_FISCALIZACAO) ? redirectToLogin() : $controller->notaFiscalDelete();
        break;
    case "mensagem_update":
        !isAdminLevel($EDITAR_FISCALIZACAO) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    default:
        break;
}