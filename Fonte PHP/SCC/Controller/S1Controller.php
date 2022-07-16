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
require_once '../DAO/ProcessoDAO.php';
require_once '../DAO/MapaDaForcaDAO.php';
require_once '../DAO/PostoDAO.php';
require_once '../DAO/SecaoDAO.php';

class S1Controller {

    private $processoInstance, // Model instance to be used by Controller and DAO
            $processoDAO;           // DAO instance for database operations
    private $mapaDaForcaInstance, // Model instance to be used by Controller and DAO
            $mapaDaForcaDAO;        // DAO instance for database operations
    private $mensagem;              // Simple string to hold input value to be used by DAO
    private $filtro;                // Array of filters to be used by DAO object

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $this->filtro = array(
            "solucao" => filter_input(INPUT_GET, "solucao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)
        );
        $this->processoInstance = new Processo();
        $this->mapaDaForcaInstance = new MapaDaForca();
        $this->processoInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->processoInstance->setPortaria(filter_input(INPUT_POST, "portaria", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setResponsavel(filter_input(INPUT_POST, "responsavel", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setDataInicio(filter_input(INPUT_POST, "dataInicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setDataFim(filter_input(INPUT_POST, "dataFim", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setSolucao(filter_input(INPUT_POST, "solucao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setTipo(filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setAssunto(filter_input(INPUT_POST, "assunto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setProrrogacao(filter_input(INPUT_POST, "prorrogacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setProrrogacaoPrazo(filter_input(INPUT_POST, "prorrogacaoPrazo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->processoInstance->setDataPrazo(filter_input(INPUT_POST, "dataPrazo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        $this->mapaDaForcaInstance->setCel_previsto(filter_input(INPUT_POST, "cel_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTc_previsto(filter_input(INPUT_POST, "tc_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setMaj_previsto(filter_input(INPUT_POST, "maj_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCap_previsto(filter_input(INPUT_POST, "cap_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen1_previsto(filter_input(INPUT_POST, "ten1_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen2_previsto(filter_input(INPUT_POST, "ten2_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setAspof_previsto(filter_input(INPUT_POST, "aspof_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSten_previsto(filter_input(INPUT_POST, "sten_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt1_previsto(filter_input(INPUT_POST, "sgt1_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt2_previsto(filter_input(INPUT_POST, "sgt2_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt3_previsto(filter_input(INPUT_POST, "sgt3_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCb_previsto(filter_input(INPUT_POST, "cb_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCbev_previsto(filter_input(INPUT_POST, "cbev_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSdep_previsto(filter_input(INPUT_POST, "sdep_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSdev_previsto(filter_input(INPUT_POST, "sdev_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCel_existente(filter_input(INPUT_POST, "cel_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTc_existente(filter_input(INPUT_POST, "tc_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setMaj_existente(filter_input(INPUT_POST, "maj_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCap_existente(filter_input(INPUT_POST, "cap_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen1_existente(filter_input(INPUT_POST, "ten1_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen2_existente(filter_input(INPUT_POST, "ten2_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setAspof_existente(filter_input(INPUT_POST, "aspof_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSten_existente(filter_input(INPUT_POST, "sten_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt1_existente(filter_input(INPUT_POST, "sgt1_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt2_existente(filter_input(INPUT_POST, "sgt2_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt3_existente(filter_input(INPUT_POST, "sgt3_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCb_existente(filter_input(INPUT_POST, "cb_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCbev_existente(filter_input(INPUT_POST, "cbev_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSdep_existente(filter_input(INPUT_POST, "sdep_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSdev_existente(filter_input(INPUT_POST, "sdev_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCel_adido(filter_input(INPUT_POST, "cel_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTc_adido(filter_input(INPUT_POST, "tc_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setMaj_adido(filter_input(INPUT_POST, "maj_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCap_adido(filter_input(INPUT_POST, "cap_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen1_adido(filter_input(INPUT_POST, "ten1_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen2_adido(filter_input(INPUT_POST, "ten2_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setAspof_adido(filter_input(INPUT_POST, "aspof_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSten_adido(filter_input(INPUT_POST, "sten_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt1_adido(filter_input(INPUT_POST, "sgt1_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt2_adido(filter_input(INPUT_POST, "sgt2_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt3_adido(filter_input(INPUT_POST, "sgt3_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCb_adido(filter_input(INPUT_POST, "cb_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCbev_adido(filter_input(INPUT_POST, "cbev_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSdep_adido(filter_input(INPUT_POST, "sdep_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSdev_adido(filter_input(INPUT_POST, "sdev_adido", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCel_adidoTexto(filter_input(INPUT_POST, "cel_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setTc_adidoTexto(filter_input(INPUT_POST, "tc_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setMaj_adidoTexto(filter_input(INPUT_POST, "maj_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setCap_adidoTexto(filter_input(INPUT_POST, "cap_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setTen1_adidoTexto(filter_input(INPUT_POST, "ten1_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setTen2_adidoTexto(filter_input(INPUT_POST, "ten2_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setAspof_adidoTexto(filter_input(INPUT_POST, "aspof_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setSten_adidoTexto(filter_input(INPUT_POST, "sten_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setSgt1_adidoTexto(filter_input(INPUT_POST, "sgt1_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setSgt2_adidoTexto(filter_input(INPUT_POST, "sgt2_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setSgt3_adidoTexto(filter_input(INPUT_POST, "sgt3_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setCb_adidoTexto(filter_input(INPUT_POST, "cb_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setCbev_adidoTexto(filter_input(INPUT_POST, "cbev_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setSdep_adidoTexto(filter_input(INPUT_POST, "sdep_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setSdev_adidoTexto(filter_input(INPUT_POST, "sdev_adidoTexto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setCap_pttc_previsto(filter_input(INPUT_POST, "cap_pttc_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen1_pttc_previsto(filter_input(INPUT_POST, "ten1_pttc_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen2_pttc_previsto(filter_input(INPUT_POST, "ten2_pttc_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSten_pttc_previsto(filter_input(INPUT_POST, "sten_pttc_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt1_pttc_previsto(filter_input(INPUT_POST, "sgt1_pttc_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt2_pttc_previsto(filter_input(INPUT_POST, "sgt2_pttc_previsto", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setCap_pttc_existente(filter_input(INPUT_POST, "cap_pttc_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen1_pttc_existente(filter_input(INPUT_POST, "ten1_pttc_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setTen2_pttc_existente(filter_input(INPUT_POST, "ten2_pttc_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSten_pttc_existente(filter_input(INPUT_POST, "sten_pttc_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt1_pttc_existente(filter_input(INPUT_POST, "sgt1_pttc_existente", FILTER_VALIDATE_INT));
        $this->mapaDaForcaInstance->setSgt2_pttc_existente(filter_input(INPUT_POST, "sgt2_pttc_existente", FILTER_VALIDATE_INT));        
        $this->mapaDaForcaInstance->setEncostados(filter_input(INPUT_POST, "encostados", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->mapaDaForcaInstance->setAgregados(filter_input(INPUT_POST, "agregados", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters
            empty($this->filtro["solucao"]) ? header("Location: S1Controller.php?action=getAllList&solucao=emandamento") : "";
            $this->processoDAO = new ProcessoDAO();
            $this->mapaDaForcaDAO = new MapaDaForcaDAO();
            $secaoDAO = new SecaoDAO();
            $mapaDaForcaList = $this->mapaDaForcaDAO->getAllList();
            $objectList = $this->processoDAO->getAllList($this->filtro);
            require_once '../View/view_S1_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function processoInsert() {
        try {
            $this->getFormData();
            $this->processoDAO = new ProcessoDAO();
            $postoDAO = new PostoDAO();
            $secaoDAO = new SecaoDAO();
            $postoList = $postoDAO->getAllList();
            if ($this->processoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->processoDAO->insert($this->processoInstance)) {
                    $secaoDAO->updateDataAtualizacao("S1");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->processoInstance;
                require_once '../View/view_S1_processo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function processoUpdate() {
        try {
            $this->getFormData();
            $this->processoDAO = new ProcessoDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->processoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                
                if ($this->processoDAO->update($this->processoInstance)) {
                    $secaoDAO->updateDataAtualizacao("S1");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form            
                $this->processoInstance = $this->processoInstance->getId() > 0 ? $this->processoDAO->getById($this->processoInstance->getId()) : null;
                $object = $this->processoInstance;
                if ($object == null) {
                    throw new Exception("Problema na obtenção de dados no controlador!");
                }
                require_once '../View/view_S1_processo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function processoDelete() {
        try {
            $this->getFormData();
            $this->processoDAO = new ProcessoDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->processoInstance->getId() != null) {
                if ($this->processoDAO->delete($this->processoInstance)) {
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

    /**
     * Update object on the database
     */
    public function mapaDaForcaUpdate() {
        try {
            $this->getFormData();
            $this->mapaDaForcaDAO = new MapaDaForcaDAO();
            $secaoDAO = new SecaoDAO();
            if (isset($_POST["submit"])) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                
                if ($this->mapaDaForcaDAO->update($this->mapaDaForcaInstance)) {
                    $secaoDAO->updateDataAtualizacao("S1");
                    header("Location: S1Controller.php?action=getAllList");
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form            
                $mapaDaForcaList = $this->mapaDaForcaDAO->getAllList();
                foreach ($mapaDaForcaList as $mapaDaForca) {
                    $this->mapaDaForcaInstance = $mapaDaForca;
                }
                $object = $this->mapaDaForcaInstance;
                if ($object == null) {
                    throw new Exception("Problema na obtenção de dados no controlador!");
                }
                require_once '../View/view_S1_mapaDaForca_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new S1Controller();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_S1) && !isAdminLevel($LISTAR_JURIDICO) ? redirectToLogin() : $controller->getAllList();
        break;
    case "processo_insert":
        !isAdminLevel($ADICIONAR_JURIDICO) ? redirectToLogin() : $controller->processoInsert();
        break;
    case "processo_update":
        !isAdminLevel($EDITAR_JURIDICO) ? redirectToLogin() : $controller->processoUpdate();
        break;
    case "processo_delete":
        !isAdminLevel($EXCLUIR_JURIDICO) ? redirectToLogin() : $controller->processoDelete();
        break;
    case "mapaDaForca_update":
        !isAdminLevel($EDITAR_S1) ? redirectToLogin() : $controller->mapaDaForcaUpdate();
        break;
    default:
        break;
}
?>