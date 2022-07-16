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
require_once '../include/global.php';
require_once '../include/comum.php';
require_once '../Model/Combustivel.php';
require_once '../Model/Material.php';
require_once '../DAO/PostoDAO.php';
require_once '../DAO/SecaoDAO.php';
require_once '../DAO/CombustivelDAO.php';
require_once '../DAO/MaterialDAO.php';
require_once '../DAO/ClasseDAO.php';
require_once '../DAO/SituacaoDAO.php';
require_once '../DAO/ProvidenciaDAO.php';

class S4Controller {

    private $combustivelInstance, // Model instance to be used by Controller and DAO
            $combustivelDAO;        // DAO instance for database operations
    private $materialInstance, // Model instance to be used by Controller and DAO
            $materialDAO;           // DAO instance for database operations
    private $providenciaInstance, // Model instance to be used by Controller and DAO
            $providenciaDAO;        // DAO instance for database operations
    private $mensagem;              // Simple string to hold input value to be used by DAO

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $this->materialInstance = new Material();
        $this->materialInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->materialInstance->setIdClasse(filter_input(INPUT_POST, "idClasse", FILTER_VALIDATE_INT));
        $this->materialInstance->setItem(filter_input(INPUT_POST, "item", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->materialInstance->setIdSituacao(filter_input(INPUT_POST, "idSituacao", FILTER_VALIDATE_INT));
        $this->materialInstance->setMarca(filter_input(INPUT_POST, "marca", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->materialInstance->setModelo(filter_input(INPUT_POST, "modelo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->materialInstance->setAno(filter_input(INPUT_POST, "ano", FILTER_VALIDATE_INT));
        $this->materialInstance->setLocal(filter_input(INPUT_POST, "local", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->materialInstance->setMotivo(filter_input(INPUT_POST, "motivo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->materialInstance->setMotivoDetalhado(filter_input(INPUT_POST, "motivoDetalhado", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->materialInstance->setSecaoResponsavel(filter_input(INPUT_POST, "secaoResponsavel", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->combustivelInstance = new Combustivel();
        $this->combustivelInstance->setCtc01celula1(filter_input(INPUT_POST, "ctc01celula1", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->combustivelInstance->setCtc01celula2(filter_input(INPUT_POST, "ctc01celula2", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->combustivelInstance->setCtc01celula3(filter_input(INPUT_POST, "ctc01celula3", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->combustivelInstance->setCtc04celula1(filter_input(INPUT_POST, "ctc04celula1", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->combustivelInstance->setCtc04celula2(filter_input(INPUT_POST, "ctc04celula2", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->combustivelInstance->setCtc04celula3(filter_input(INPUT_POST, "ctc04celula3", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->combustivelInstance->setCtc01celula1valor(str_replace(",", ".", filter_input(INPUT_POST, "ctc01celula1valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->combustivelInstance->setCtc01celula2valor(str_replace(",", ".", filter_input(INPUT_POST, "ctc01celula2valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->combustivelInstance->setCtc01celula3valor(str_replace(",", ".", filter_input(INPUT_POST, "ctc01celula3valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->combustivelInstance->setCtc04celula1valor(str_replace(",", ".", filter_input(INPUT_POST, "ctc04celula1valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->combustivelInstance->setCtc04celula2valor(str_replace(",", ".", filter_input(INPUT_POST, "ctc04celula2valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->combustivelInstance->setCtc04celula3valor(str_replace(",", ".", filter_input(INPUT_POST, "ctc04celula3valor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->combustivelInstance->setDiesel(str_replace(",", ".", filter_input(INPUT_POST, "diesel", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->combustivelInstance->setGasolina(str_replace(",", ".", filter_input(INPUT_POST, "gasolina", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)));
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        $this->providenciaInstance = new Providencia();
         $this->providenciaInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->providenciaInstance->setProvidencia(filter_input(INPUT_POST, "providencia", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->providenciaInstance->setIdMaterial(filter_input(INPUT_POST, "idMaterial", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters            
            $this->combustivelDAO = new CombustivelDAO();
            $this->materialDAO = new MaterialDAO();
            $secaoDAO = new SecaoDAO();
            $classeDAO = new ClasseDAO();
            $situacaoDAO = new SituacaoDAO();
            $combustivelList = $this->combustivelDAO->getAllList();
            $materialList = $this->materialDAO->getAllList();
            require_once '../View/view_S4_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function combustivelUpdate() {
        try {
            $this->getFormData();
            $this->combustivelDAO = new CombustivelDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->combustivelInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                     
                if ($this->combustivelDAO->update($this->combustivelInstance)) {
                    $secaoDAO->updateDataAtualizacao("S4");
                    header("Location: S4Controller.php?action=getAllList");
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form            
                $objectList = $this->combustivelDAO->getAllList();
                require_once '../View/view_S4_combustivel_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function mensagemUpdate() {
        try {
            $this->getFormData();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->mensagem)) {
                $secaoDAO->updateDataAtualizacao("S4", $this->mensagem);
            }
            header("Location: S4Controller.php?action=getAllList");
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function materialInsert() {
        try {
            $this->getFormData();
            $this->materialDAO = new MaterialDAO();
            $classeDAO = new ClasseDAO();
            $situacaoDAO = new SituacaoDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->materialInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                     
                if ($this->materialDAO->insert($this->materialInstance)) {
                    $secaoDAO->updateDataAtualizacao("S4");
                    header("Location: S4Controller.php?action=getAllList");
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form    
                $object = $this->materialInstance;
                require_once '../View/view_S4_material_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function materialUpdate() {
        try {
            $this->getFormData();
            $this->materialDAO = new MaterialDAO();
            $classeDAO = new ClasseDAO();
            $situacaoDAO = new SituacaoDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->materialInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                
                if ($this->materialDAO->update($this->materialInstance)) {
                    $secaoDAO->updateDataAtualizacao("S4");
                    header("Location: S4Controller.php?action=getAllList");
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form        
                $this->providenciaDAO = new ProvidenciaDAO();
                $providenciaList = $this->providenciaDAO->getByMaterialId($this->materialInstance->getId());
                $this->materialInstance = $this->materialInstance->getId() > 0 ? $this->materialDAO->getById($this->materialInstance->getId()) : null;
                $object = $this->materialInstance;
                if ($object == null) {
                    throw new Exception("Problema na obtenção de dados no controlador!");
                }
                require_once '../View/view_S4_material_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function materialDelete() {
        try {
            $this->getFormData();
            $this->materialDAO = new MaterialDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->materialInstance->getId() != null) {
                if ($this->materialDAO->delete($this->materialInstance)) {
                    $secaoDAO->updateDataAtualizacao("S4");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function providenciaInsert() {
        try {
            $this->getFormData();
            $this->materialDAO = new MaterialDAO();
            $secaoDAO = new SecaoDAO();
            $this->providenciaDAO = new ProvidenciaDAO();
            if ($this->providenciaInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                     
                if ($this->providenciaDAO->insert($this->providenciaInstance)) {
                    $secaoDAO->updateDataAtualizacao("S4");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form                            
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function providenciaDelete() {
        try {
            $this->getFormData();
            $this->providenciaDAO = new ProvidenciaDAO();
            $secaoDAO = new SecaoDAO();            
            if ($this->providenciaInstance->getId() > 0) {                
                if ($this->providenciaDAO->delete($this->providenciaInstance)) {
                    $secaoDAO->updateDataAtualizacao("S4");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }  else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            } else {
                throw new Exception("Problema na obtenção de dados no controlador!");
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new S4Controller();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_S4) ? redirectToLogin() : $controller->getAllList();
        break;
    case "combustivel_update":
        !isAdminLevel($EDITAR_S4) ? redirectToLogin() : $controller->combustivelUpdate();
        break;
    case "mensagem_update":
        !isAdminLevel($EDITAR_S4) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    case "material_insert":
        !isAdminLevel($ADICIONAR_S4) ? redirectToLogin() : $controller->materialInsert();
        break;
    case "material_update":
        !isAdminLevel($EDITAR_S4) ? redirectToLogin() : $controller->materialupdate();
        break;
    case "material_delete":
        !isAdminLevel($EXCLUIR_S4) ? redirectToLogin() : $controller->materialDelete();
        break;
    case "providencia_insert":
        !isAdminLevel($ADICIONAR_S4) ? redirectToLogin() : $controller->providenciaInsert();
        break;
    case "providencia_update":
        !isAdminLevel($EDITAR_S4) ? redirectToLogin() : $controller->providenciaUpdate();
        break;
    case "providencia_delete":
        !isAdminLevel($EXCLUIR_S4) ? redirectToLogin() : $controller->providenciaDelete();
        break;
    default:
        break;
}
?>