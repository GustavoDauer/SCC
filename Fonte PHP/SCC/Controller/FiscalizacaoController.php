<?php

require_once '../include/global.php';
require_once '../include/comum.php';
require_once '../Model/Requisicao.php';
require_once '../DAO/RequisicaoDAO.php';
require_once '../DAO/NotaCreditoDAO.php';
require_once '../DAO/SecaoDAO.php';
require_once '../DAO/CategoriaDAO.php';
require_once '../DAO/ItemDAO.php';

class FiscalizacaoController {

    private $requisicaoInstance, $itemInstance, $notaCreditoInstance;

    function getFormData() {
        // FILTROS
        $this->filtro = array(
            "idSecao" => filter_input(INPUT_GET, "idSecao", FILTER_VALIDATE_INT),
            "idNotaCredito" => filter_input(INPUT_GET, "idNotaCredito", FILTER_VALIDATE_INT),
            "ug" => filter_input(INPUT_GET, "ug", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES),
            "ne" => filter_input(INPUT_GET, "ne", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES),
            "materiaisEntregues" => filter_input(INPUT_GET, "materiaisEntregues", FILTER_VALIDATE_INT),            
        );
        // REQUISIÇÃO
        $this->requisicaoInstance = new Requisicao();
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $this->requisicaoInstance->setId(!empty($id) ? $id : (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT)));
        $this->requisicaoInstance->setDataRequisicao(filter_input(INPUT_POST, "dataRequisicao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setIdNotaCredito(filter_input(INPUT_POST, "idNotaCredito", FILTER_VALIDATE_INT));
        $this->requisicaoInstance->setOm(filter_input(INPUT_POST, "om", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setIdSecao(filter_input(INPUT_POST, "idSecao", FILTER_VALIDATE_INT));
        $this->requisicaoInstance->setDescricao(filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setPe(filter_input(INPUT_POST, "pe", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $ug = filter_input(INPUT_POST, "ug", FILTER_VALIDATE_INT);
        $this->requisicaoInstance->setUg(is_int($ug) ? $ug : 0);
        $this->requisicaoInstance->setOmpe(filter_input(INPUT_POST, "ompe", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setEmpresa(filter_input(INPUT_POST, "empresa", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setCnpj(filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setContato(filter_input(INPUT_POST, 'contato', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setNe(filter_input(INPUT_POST, "ne", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setObservacaoAquisicoes(filter_input(INPUT_POST, 'observacaoAquisicoes', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataEnvioNE(filter_input(INPUT_POST, "dataEnvioNE", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setValorNE(filter_input(INPUT_POST, "valorNE", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataAprovacao(filter_input(INPUT_POST, "dataAprovacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setObservacaoConformidade(filter_input(INPUT_POST, 'observacaoConformidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setParecer(filter_input(INPUT_POST, "parecer", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataEntregaMaterial(filter_input(INPUT_POST, "dataEntregaMaterial", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setNumeroDiex(filter_input(INPUT_POST, "numeroDiex", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setProcessoAdministrativo(filter_input(INPUT_POST, 'processoAdministrativo', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setNumeroOficio(filter_input(INPUT_POST, "numeroOficio", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setBoletim(filter_input(INPUT_POST, "boletim", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataUltimaLiquidacao(filter_input(INPUT_POST, "dataUltimaLiquidacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setValorLiquidar(filter_input(INPUT_POST, "valorLiquidar", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setDataNE(filter_input(INPUT_POST, "dataNE", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->requisicaoInstance->setObservacaoAlmox(filter_input(INPUT_POST, "observacaoAlmox", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        // ITEM          
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
        // SEÇÃO
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        // NC
        $this->notaCreditoInstance = new NotaCredito();
        $this->notaCreditoInstance->setId(!empty($id) ? $id : (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT)));
        $this->notaCreditoInstance->setDataNc(filter_input(INPUT_POST, "dataNc", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setNc(filter_input(INPUT_POST, "nc", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setPi(filter_input(INPUT_POST, "pi", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->notaCreditoInstance->setValor(filter_input(INPUT_POST, "valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
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
            if (!empty($this->requisicaoInstance->getDataRequisicao())) { // validation                
                if ($requisicaoDAO->insert($this->requisicaoInstance)) {
                    header("Location: FiscalizacaoController.php?action=getAllList");
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // view redirection
                $object = $this->requisicaoInstance;
                $secaoList = $secaoDAO->getAllList();
                $categoriaList = $categoriaDAO->getAllList();
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
            if (!empty($this->requisicaoInstance->getId())) {
                if ($requisicaoDAO->delete($this->requisicaoInstance->getId())) {
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
            if (!empty($this->requisicaoInstance->getDataRequisicao())) {
                if ($requisicaoDAO->update($this->requisicaoInstance)) {
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
            if (!empty($this->notaCreditoInstance->getId())) {
                if ($notaCreditoDAO->delete($this->notaCreditoInstance)) {
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
            if (!empty($this->notaCreditoInstance->getNc())) {
                if ($notaCreditoDAO->update($this->notaCreditoInstance)) {
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
    case "mensagem_update":
        !isAdminLevel($EDITAR_FISCALIZACAO) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    default:
        break;
}