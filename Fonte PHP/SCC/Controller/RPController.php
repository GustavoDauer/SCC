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
require_once '../DAO/VisitanteDAO.php';
require_once '../DAO/SecaoDAO.php';
require_once '../DAO/FotoDAO.php';

class RPController {

    private $visitanteInstance,     // Model instance to be used by Controller and DAO
            $visitanteDAO,          // DAO instance for database operations            
            $foto;                  
    private $filtro;                // Array of filters to be used by DAO object

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $dataHoje = date('Y-m-d');
        $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
        $inicio = !empty(filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataHoje;
        $fim = !empty(filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataAmanha;
        $this->filtro = array(
            "inicio" => $inicio,
            "fim" => $fim
        );
        $this->visitanteInstance = new Visitante();
        $this->visitanteInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->visitanteInstance->setNome(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setCpf(filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setDestino(filter_input(INPUT_POST, "destino", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setTelefone(filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setDataEntrada(filter_input(INPUT_POST, "dataEntrada", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setDataSaida(filter_input(INPUT_POST, "dataSaida", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setHoraEntrada(filter_input(INPUT_POST, "horaEntrada", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setHoraSaida(filter_input(INPUT_POST, "horaSaida", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setCracha(filter_input(INPUT_POST, "cracha", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setTemporario(filter_input(INPUT_POST, "temporario", FILTER_VALIDATE_INT));
        $this->foto = isset($_FILES["arquivoFoto"]) ? $_FILES["arquivoFoto"] : "";        
        $this->visitanteInstance->setFoto($this->visitanteInstance->getId() . ".jpg");
        $this->visitanteInstance->setArquivoFoto($this->foto);
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);        
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters            
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            $objectList = $this->visitanteDAO->getAllList($this->filtro);
            require_once '../View/view_RP_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function visitanteInsert() {
        try {
            $this->getFormData();
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            if ($this->visitanteInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->visitanteDAO->insert($this->visitanteInstance)) {
                    $secaoDAO->updateDataAtualizacao("RP");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->visitanteInstance;
                require_once '../View/view_RP_visitante_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function visitanteUpdate() {
        try {
            $this->getFormData();            
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            if ($this->visitanteInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->visitanteDAO->update($this->visitanteInstance)) {
                    $secaoDAO->updateDataAtualizacao("RP");                    
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form   
                $this->visitanteInstance = $this->visitanteInstance->getId() > 0 ? $this->visitanteDAO->getById($this->visitanteInstance->getId()) : null;
                $object = $this->visitanteInstance;
                require_once '../View/view_RP_visitante_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function visitanteDelete() {
        try {
            $this->getFormData();
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            if ($this->visitanteInstance->getId() != null) {
                if ($this->visitanteDAO->delete($this->visitanteInstance)) {
                    $secaoDAO->updateDataAtualizacao("RP");
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
                $secaoDAO->updateDataAtualizacao("RP", $this->mensagem);
            }
            header("Location: RPController.php?action=getAllList");
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new RPController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_RP) ? redirectToLogin() : $controller->getAllList();
        break;
    case "visitante_insert":
        !isAdminLevel($ADICIONAR_RP) ? redirectToLogin() : $controller->visitanteInsert();
        break;
    case "visitante_update":
        !isAdminLevel($EDITAR_RP) ? redirectToLogin() : $controller->visitanteUpdate();
        break;
    case "visitante_delete":
        !isAdminLevel($EXCLUIR_RP) ? redirectToLogin() : $controller->visitanteDelete();
        break;
    case "mensagem_update":
        !isAdminLevel($EDITAR_RP) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    default:
        break;
}
?>