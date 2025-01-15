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
require_once '../DAO/ExameDePagamentoDAO.php';
require_once '../Model/ExameDePagamento.php';

class SPPController {

    private $exameDePagamento;

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $this->exameDePagamento = new ExameDePagamento();
        $this->exameDePagamento->setEfetivo(filter_input(INPUT_POST, "efetivo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->exameDePagamento->setCPEX(filter_input(INPUT_POST, "cpex", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData();
            $exameDAO = new ExameDePagamentoDAO();
            require_once '../View/view_SPP_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function generate() {
        $this->getFormData();
        $exameDAO = new ExameDePagamentoDAO();
        $exameDAO->reset();
        $this->insert($this->exameDePagamento->getEfetivo(), "Efetivo");
        $this->insert($this->exameDePagamento->getCpex(), "CPEX");
        $exameCPEXList = $exameDAO->getAllList("CPEX");
        $exameEfetivoList = $exameDAO->getAllList("Efetivo");
        $exameEfetivoNotInCPEXList = $exameDAO->getAllListNotIn("Efetivo", "CPEX");
        $exameCPEXNotInEfetivoList = $exameDAO->getAllListNotIn("CPEX", "Efetivo");
        require_once '../View/view_SPP_list.php';
    }

    public function insert($input, $table) {
        try {
            $exameDAO = new ExameDePagamentoDAO();
            $textarea = explode("\n", $input);
            $nomesInseridos = "";
            foreach ($textarea as $line) {
                $line = $this->tirarAcentos(trim($line));
                $line = trim(preg_replace('/\s+/', ' ', $line));
                if ($line != "" && !empty($line)) {
                    $exameDAO->insert($line, $table);
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    function tirarAcentos($string) {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new SPPController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_SPP) ? redirectToLogin() : $controller->getAllList();
        break;
    case "gerar":
        !isAdminLevel($LISTAR_SPP) ? redirectToLogin() : $controller->generate();
        break;
    default:
        break;
}
?>