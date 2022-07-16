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
require_once '../DAO/BaixadoDAO.php';
require_once '../DAO/PostoDAO.php';
require_once '../DAO/SecaoDAO.php';

class FSController {

    private $baixadoInstance, // Model instance to be used by Controller and DAO
            $baixadoDAO;        // DAO instance for database operations            
    private $filtro;            // Array of filters to be used by DAO object

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {        
        $this->filtro = array(
            "situacao" => filter_input(INPUT_GET, "situacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)
        );
        $this->baixadoInstance = new Baixado();
        $this->baixadoInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->baixadoInstance->setIdPosto(filter_input(INPUT_POST, "idPosto", FILTER_VALIDATE_INT));
        $this->baixadoInstance->setNome(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->baixadoInstance->setCia(filter_input(INPUT_POST, "cia", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $turma = filter_input(INPUT_POST, "turma", FILTER_VALIDATE_INT);
        $this->baixadoInstance->setTurma(is_int($turma) ? $turma : 0);
        $this->baixadoInstance->setDiagnostico(filter_input(INPUT_POST, "diagnostico", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->baixadoInstance->setSituacao(filter_input(INPUT_POST, "situacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->baixadoInstance->setBi(filter_input(INPUT_POST, "bi", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->baixadoInstance->setBar(filter_input(INPUT_POST, "bar", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->baixadoInstance->setDispensa(filter_input(INPUT_POST, "dispensa", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->baixadoInstance->setAmparo(filter_input(INPUT_POST, "amparo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->baixadoInstance->setAcao(filter_input(INPUT_POST, "acao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters
            empty($this->filtro["situacao"]) ? header("Location: FSController.php?action=getAllList&situacao=todos") : "";
            $this->baixadoDAO = new BaixadoDAO();
            $secaoDAO = new SecaoDAO();
            $postoDAO = new PostoDAO();
            $objectList = $this->baixadoDAO->getAllList($this->filtro);
            require_once '../View/view_FS_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function baixadoInsert() {
        try {
            $this->getFormData();
            $this->baixadoDAO = new BaixadoDAO();
            $postoDAO = new PostoDAO();
            $secaoDAO = new SecaoDAO();
            $postoList = $postoDAO->getAllList();
            if ($this->baixadoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->baixadoDAO->insert($this->baixadoInstance)) {
                    $secaoDAO->updateDataAtualizacao("FS");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->baixadoInstance;
                require_once '../View/view_FS_baixado_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function baixadoUpdate() {
        try {
            $this->getFormData();
            $this->baixadoDAO = new BaixadoDAO();
            $postoDAO = new PostoDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->baixadoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->baixadoDAO->update($this->baixadoInstance)) {
                    $secaoDAO->updateDataAtualizacao("FS");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form   
                $this->baixadoInstance = $this->baixadoInstance->getId() > 0 ? $this->baixadoDAO->getById($this->baixadoInstance->getId()) : null;
                $object = $this->baixadoInstance;
                $postoList = $postoDAO->getAllList();                
                require_once '../View/view_FS_baixado_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function baixadoDelete() {
        try {
            $this->getFormData();
            $this->baixadoDAO = new BaixadoDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->baixadoInstance->getId() != null) {
                if ($this->baixadoDAO->delete($this->baixadoInstance)) {
                    $secaoDAO->updateDataAtualizacao("FS");
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
     * Update object on the database
     */
    public function mensagemUpdate() {
        try {
            $this->getFormData();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->mensagem)) {
                $secaoDAO->updateDataAtualizacao("FS", $this->mensagem);
            }
            header("Location: FSController.php?action=getAllList");
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new FSController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_FS) ? redirectToLogin() : $controller->getAllList();
        break;
    case "baixado_insert":
        !isAdminLevel($ADICIONAR_FS) ? redirectToLogin() : $controller->baixadoInsert();
        break;
    case "baixado_update":
        !isAdminLevel($EDITAR_FS) ? redirectToLogin() : $controller->baixadoUpdate();
        break;
    case "baixado_delete":
        !isAdminLevel($EXCLUIR_FS) ? redirectToLogin() : $controller->baixadoDelete();
        break;
    case "mensagem_update":
        !isAdminLevel($EDITAR_FS) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    default:
        break;
}
?>