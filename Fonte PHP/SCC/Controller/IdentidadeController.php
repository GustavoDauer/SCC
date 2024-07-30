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
            $this->getFormData();
            require_once '../View/view_Identidade_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function generate() {
        $this->getFormData();        
        $strings = explode(";", $this->identidadeInstance->getLinha());
        $linha = $this->identidadeInstance->getLinha();
        $id1 = $id2 = $id3 = $id4 = "";
        if (isset($linha)) {                        
            $resultado = explode("SEPARADOR", $linha);
            $id1 = $resultado[0];
            $id1 = explode("\t", $id1);            
            //echo var_dump($id1) . "<hr>";
            $this->identidadeInstance->setId1($id1);
            $id2 = $resultado[1];
            $id2 = explode("\t", $id2);            
            //echo var_dump($id2) . "<hr>";
            $this->identidadeInstance->setId2($id2);
            $id3 = $resultado[2];
            $id3 = explode("\t", $id3);            
            //echo var_dump($id3) . "<hr>";
            $this->identidadeInstance->setId3($id3);
            $id4 = $resultado[3];
            $id4 = explode("\t", $id4);
            //echo var_dump($id4) . "<hr>";   
            $this->identidadeInstance->setId4($id4);
//            if (count($resultado) != 80) {
//                echo "Deu ruim: " . count($resultado) . " colunas";
//            } else {
//                
//            }
        }
        require_once '../View/view_Identidade_impressao.php';                     
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