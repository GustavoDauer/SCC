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
require_once '../DAO/SecaoDAO.php';
require_once '../Model/Identidade.php';

class IdentidadeController {
    
    private $identidadeInstance;

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $this->identidadeInstance = new Identidade();
        $this->identidadeInstance->setLinha(filter_input(INPUT_POST, "linha", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters            
            //$objectList = $this->visitanteDAO->getAllList($this->filtro);
            require_once '../View/view_Identidade_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }
    
    public function generate() {
        $this->getFormData();
        echo $this->identidadeInstance->getLinha() . "<br>";
        $strings = explode(";", $this->identidadeInstance->getLinha());
        echo var_dump($strings);
        
    }
}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new IdentidadeController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_IDENTIDADE) ? redirectToLogin() : $controller->getAllList();
        break;
    case "gerar":
        !isAdminLevel($LISTAR_IDENTIDADE) ? redirectToLogin() : $controller->generate();
        break;
    default:
        break;
}
?>