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

class S3Controller {

    private $mensagem;              // Simple string to hold input value to be used by DAO

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters         
            $secaoDAO = new SecaoDAO();
            require_once '../View/view_S3_list.php';
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
                $secaoDAO->updateDataAtualizacao("S3", $this->mensagem);
            }
            header("Location: S3Controller.php?action=getAllList");
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new S3Controller();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_S3) ? redirectToLogin() : $controller->getAllList();
        break;
    case "mensagem_update":
        !isAdminLevel($EDITAR_S3) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    default:
        break;
}
?>