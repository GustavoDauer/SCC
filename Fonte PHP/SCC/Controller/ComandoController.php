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
require_once '../DAO/PostoDAO.php';
require_once '../DAO/SecaoDAO.php';
require_once '../DAO/PessoaDAO.php';
require_once '../DAO/SpedDAO.php';
require_once '../Model/Sped.php';

class ComandoController {

    private $spedInstance, // Model instance to be used by Controller and DAO
            $spedDAO,      // DAO instance for database operations    
            $arquivo;           
    private $mensagem;              // Simple string to hold input value to be used by DAO
    private $filtro;                // Array of filters to be used by DAO object

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $this->filtro = array(
            "resolvido" => filter_input(INPUT_GET, "resolvido", FILTER_VALIDATE_INT),
            "tipo" => filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)
        );
        $this->spedInstance = new Sped();
        $this->spedInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->spedInstance->setResolvido(filter_input(INPUT_POST, "resolvido", FILTER_VALIDATE_INT));
        $this->spedInstance->setIdResponsavel(filter_input(INPUT_POST, "idResponsavel", FILTER_VALIDATE_INT));
        $this->spedInstance->setTitulo(filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->spedInstance->setAssunto(filter_input(INPUT_POST, "assunto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->spedInstance->setPrazo(filter_input(INPUT_POST, "prazo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->spedInstance->setData(filter_input(INPUT_POST, "data", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));        
        $this->spedInstance->setTipo(filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : "";
        $this->spedInstance->setArquivoNome($this->spedInstance->getId() . ".pdf");
        $this->spedInstance->setArquivoPDF($this->arquivo);
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters
            //empty($this->filtro["resolvido"]) ? header("Location: ComandoController.php?action=getAllList&resolvido=0") : "";
            $this->spedDAO = new SpedDAO();
            $secaoDAO = new SecaoDAO();
            $objectList = $this->spedDAO->getAllList($this->filtro);
            $pessoaDAO = new PessoaDAO();   
            $postoDAO = new PostoDAO();
            $arquivoDAO = new ArquivoDAO();
            require_once '../View/view_Comando_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function spedInsert() {
        try {
            $this->getFormData();
            $this->spedDAO = new SpedDAO();
            $postoDAO = new PostoDAO();
            $secaoDAO = new SecaoDAO();
            $pessoaDAO = new PessoaDAO();
            $arquivoDAO = new ArquivoDAO();
            $postoList = $postoDAO->getAllList();
            if ($this->spedInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->spedDAO->insert($this->spedInstance)) {
                    $secaoDAO->updateDataAtualizacao("Comando");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->spedInstance;
                require_once '../View/view_Comando_sped_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function spedUpdate() {
        try {
            $this->getFormData();
            $this->spedDAO = new SpedDAO();
            $secaoDAO = new SecaoDAO();
            $pessoaDAO = new PessoaDAO();
            $postoDAO = new PostoDAO();
            $arquivoDAO = new ArquivoDAO();
            if ($this->spedInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form               
                if ($this->spedDAO->update($this->spedInstance)) {
                    $secaoDAO->updateDataAtualizacao("Comando");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form            
                $this->spedInstance = $this->spedInstance->getId() > 0 ? $this->spedDAO->getById($this->spedInstance->getId()) : null;
                $object = $this->spedInstance;
                if ($object == null) {
                    throw new Exception("Problema na obtenção de dados no controlador!");
                }
                require_once '../View/view_Comando_sped_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function spedView() {
        try {
            $this->getFormData();
            $this->spedDAO = new SpedDAO();
            $secaoDAO = new SecaoDAO();
            $pessoaDAO = new PessoaDAO(); 
            $postoDAO = new PostoDAO();
            // Require the view of the form            
            $this->spedInstance = $this->spedInstance->getId() > 0 ? $this->spedDAO->getById($this->spedInstance->getId()) : null;
            $object = $this->spedInstance;
            if ($object == null) {
                throw new Exception("Problema na obtenção de dados no controlador!");
            }
            require_once '../View/view_Comando_sped_edit.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function spedDelete() {
        try {
            $this->getFormData();
            $this->spedDAO = new SpedDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->spedInstance->getId() != null) {
                if ($this->spedDAO->delete($this->spedInstance)) {
                    $secaoDAO->updateDataAtualizacao("S1");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new ComandoController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_COMANDO) ? redirectToLogin() : $controller->getAllList();
        break;
    case "sped_insert":
        !isAdminLevel($ADICIONAR_COMANDO) ? redirectToLogin() : $controller->spedInsert();
        break;
    case "sped_update":
        !isAdminLevel($EDITAR_COMANDO) ? redirectToLogin() : $controller->spedUpdate();
        break;
    case "sped_view":
        !isAdminLevel($LISTAR_COMANDO) ? redirectToLogin() : $controller->spedView();
        break;
    case "sped_delete":
        !isAdminLevel($EXCLUIR_COMANDO) ? redirectToLogin() : $controller->spedDelete();
        break;
    default:
        break;
}
?>