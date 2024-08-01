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
require_once '../DAO/VeiculoDAO.php';
require_once '../DAO/AuditoriaVeiculoDAO.php';
require_once '../DAO/AuditoriaPessoaDAO.php';
require_once '../DAO/PessoaDAO.php';
require_once '../DAO/SecaoDAO.php';
require_once '../DAO/PostoDAO.php';
require_once '../DAO/VinculoDAO.php';
require_once '../DAO/FotoDAO.php';

class S2Controller {

    private $veiculoInstance, $pessoaInstance, // Model instance to be used by Controller and DAO
            $veiculoDAO, $pessoaDAO, // DAO instance for database operations       
            $foto;                             // Photo              
    private $filtro;
    private $auditoriaVeiculoDAO;
    private $auditoriaPessoaDAO;

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $dataHoje = date('Y-m-d');
        $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
        $inicio = !empty(filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataHoje;
        $fim = !empty(filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataAmanha;
        $dataExpiracao = filter_input(INPUT_GET, "dataExpiracao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        $inicio = filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        $fim = filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        $this->filtro = array(
            "dataExpiracao" => $dataExpiracao,
            "inicio" => $inicio,
            "fim" => $fim,
        );
        $this->getFormDataVeiculo();
        $this->getFormDataPessoa();
    }

    public function getFormDataVeiculo() {
        $this->veiculoInstance = new Veiculo();
        $this->veiculoInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->veiculoInstance->setMarca(filter_input(INPUT_POST, "marca", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setModelo(filter_input(INPUT_POST, "modelo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setAnoFabricacao(filter_input(INPUT_POST, "anoFabricacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setAnoModelo(filter_input(INPUT_POST, "anoModelo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setCor(filter_input(INPUT_POST, "cor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setPlaca(filter_input(INPUT_POST, "placa", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setPlacaEB(filter_input(INPUT_POST, "placaEB", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setTipo(filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setIdPessoa(filter_input(INPUT_POST, "idPessoa", FILTER_VALIDATE_INT));
    }

    public function getFormDataPessoa() {
        $this->pessoaInstance = new Pessoa();
        $this->pessoaInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->pessoaInstance->setNome(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setNomeGuerra(filter_input(INPUT_POST, "nomeGuerra", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setIdPosto(filter_input(INPUT_POST, "idPosto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setCpf(filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setIdentidadeMilitar(filter_input(INPUT_POST, "identidadeMilitar", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setPreccp(filter_input(INPUT_POST, "preccp", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setFoto(filter_input(INPUT_POST, "foto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setIdVinculo(filter_input(INPUT_POST, "idVinculo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->pessoaInstance->setDataExpiracao(filter_input(INPUT_POST, "dataExpiracao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->foto = isset($_FILES["arquivoFoto"]) ? $_FILES["arquivoFoto"] : "";
        $this->pessoaInstance->setFoto("S2-Pessoa-" . $this->pessoaInstance->getId() . ".jpg");
        $this->pessoaInstance->setArquivoFoto($this->foto);
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters            
            $this->veiculoDAO = new VeiculoDAO();
            $this->pessoaDAO = new PessoaDAO();
            $fotoDAO = new FotoDAO();
            $secaoDAO = new SecaoDAO();
            $postoDAO = new PostoDAO();
            $vinculoDAO = new VinculoDAO();
            $pessoaDAO = $this->pessoaDAO;
            $pessoaList = $this->pessoaDAO->getAllList($this->filtro);
            $veiculoList = $this->veiculoDAO->getAllList($this->filtro);
            require_once '../View/view_S2_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function veiculoInsert() {
        try {
            $this->getFormData();
            $this->veiculoDAO = new VeiculoDAO();
            $secaoDAO = new SecaoDAO();
            $pessoaDAO = new PessoaDAO();
            $postoDAO = new PostoDAO();
            if ($this->veiculoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                
                if ($this->veiculoDAO->insert($this->veiculoInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->veiculoInstance;
                $pessoaList = $pessoaDAO->getAllList();
                require_once '../View/view_S2_veiculo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function veiculoUpdate() {
        try {
            $this->getFormData();
            $this->veiculoDAO = new VeiculoDAO();
            $secaoDAO = new SecaoDAO();
            $pessoaDAO = new PessoaDAO();
            $postoDAO = new PostoDAO();
            if ($this->veiculoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->veiculoDAO->update($this->veiculoInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!<br>O tamanho do arquivo deve ser de no máximo 40 KB e a extensão deve ser .jpg ou .png.");
                }
            } else { // Require the view of the form   
                $this->veiculoInstance = $this->veiculoInstance->getId() > 0 ? $this->veiculoDAO->getById($this->veiculoInstance->getId()) : null;
                $object = $this->veiculoInstance;
                $pessoaList = $pessoaDAO->getAllList();
                require_once '../View/view_S2_veiculo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function veiculoDelete() {
        try {
            $this->getFormData();
            $this->veiculoDAO = new VeiculoDAO();
            $secaoDAO = new SecaoDAO();
            if ($this->veiculoInstance->getId() != null) {
                if ($this->veiculoDAO->delete($this->veiculoInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");
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
    public function pessoaInsert() {
        try {
            $this->getFormData();
            $this->pessoaDAO = new PessoaDAO();
            $secaoDAO = new SecaoDAO();
            $postoDAO = new PostoDAO();
            $vinculoDAO = new VinculoDAO();
            $fotoDAO = new FotoDAO();
            $postoList = $postoDAO->getAllList();
            $vinculoList = $vinculoDAO->getAllList();
            if ($this->pessoaInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                
                if ($this->pessoaDAO->insert($this->pessoaInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->pessoaInstance;
                require_once '../View/view_S2_pessoa_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function pessoaUpdate() {
        try {
            $this->getFormData();
            $this->pessoaDAO = new PessoaDAO();
            $secaoDAO = new SecaoDAO();
            $postoDAO = new PostoDAO();
            $vinculoDAO = new VinculoDAO();
            $fotoDAO = new FotoDAO();
            $postoList = $postoDAO->getAllList();
            $vinculoList = $vinculoDAO->getAllList();
            if ($this->pessoaInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->pessoaDAO->update($this->pessoaInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!<br>O tamanho do arquivo deve ser de no máximo 40 KB e a extensão deve ser .jpg ou .png.");
                }
            } else { // Require the view of the form   
                $this->pessoaInstance = $this->pessoaInstance->getId() > 0 ? $this->pessoaDAO->getById($this->pessoaInstance->getId()) : null;
                $object = $this->pessoaInstance;
                require_once '../View/view_S2_pessoa_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function pessoaDelete() {
        try {
            $this->getFormData();
            $this->pessoaDAO = new PessoaDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            if ($this->pessoaInstance->getId() != null) {
                if ($this->pessoaDAO->delete($this->pessoaInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function veiculoCheck() {
        try {
            $this->getFormData();
            $this->veiculoDAO = new VeiculoDAO();
            $this->auditoriaVeiculoDAO = new AuditoriaVeiculoDAO();
            $autorizado = "";
            $object = null;
            $placa = "";
            if (!empty($this->veiculoInstance->getPlaca())) {
                $object = $this->veiculoDAO->checkPlaca($this->veiculoInstance->getPlaca());
                if (!is_null($object)) {
                    $autorizado = "autorizado";
                } else {
                    $autorizado = "nao_autorizado";
                    $placa = $this->veiculoInstance->getPlaca();
                }
                $auditoriaVeiculo = new AuditoriaVeiculo();
                $auditoriaVeiculo->setAutorizacao($autorizado === "autorizado" ? 1 : 0);
                $auditoriaVeiculo->setLocal("batalhao");
                $auditoriaVeiculo->setPlaca($placa);
                $auditoriaVeiculo->setIdVeiculo(!is_null($object) ? $object->getId() : null);
                if (!$this->auditoriaVeiculoDAO->insert($auditoriaVeiculo)) {
                    throw new Exception("Erro no módulo de auditoria da 2ª Seção!");
                }
                require_once '../View/view_S2_servico_veiculo.php';
            } else {
                require_once '../View/view_S2_servico_veiculo.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function veiculoPreccpCheck() {
        try {
            $this->getFormData();
            $this->pessoaDAO = new PessoaDAO();
            $this->auditoriaVeiculoDAO = new AuditoriaVeiculoDAO();
            $autorizado = "";
            $object = null;
            $placa = "";
            $aviso = "";
            $preccp = "";
            if (!empty($this->pessoaInstance->getPreccp())) {
                $pessoa = $this->pessoaDAO->getSCFExByPreccp($this->pessoaInstance->getPreccp());
                $placa = $this->veiculoInstance->getPlaca();
                $preccp = $this->pessoaInstance->getPreccp();
                $nome = $this->pessoaInstance->getNome();
                if (!is_null($pessoa)) {
                    $autorizado = "autorizado";
                } else {
                    $autorizado = "nao_autorizado";
                }
                $auditoriaVeiculo = new AuditoriaVeiculo();
                $auditoriaVeiculo->setAutorizacao($autorizado === "autorizado" ? 1 : 0);
                $auditoriaVeiculo->setPreccp($preccp);
                $auditoriaVeiculo->setPlaca($placa);
                $auditoriaVeiculo->setNome($nome);
                $auditoriaVeiculo->setLocal("batalhao");
                if (!$this->auditoriaVeiculoDAO->insert($auditoriaVeiculo)) {
                    throw new Exception("Erro no módulo de auditoria da 2ª Seção!");
                }
                require_once '../View/view_S2_servico_veiculo.php';
            } else {
                require_once '../View/view_S2_servico_veiculo.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function auditoriaList() {
        try {
            $this->getFormData(); // Used to get filters      
            $this->veiculoDAO = new VeiculoDAO();
            $this->pessoaDAO = new PessoaDAO();
            $this->auditoriaVeiculoDAO = new AuditoriaVeiculoDAO();
            $this->auditoriaPessoaDAO = new AuditoriaPessoaDAO();
            $secaoDAO = new SecaoDAO();
            $pessoaDAO = $this->pessoaDAO;
            $veiculoDAO = $this->veiculoDAO;
            $auditoriaVeiculoList = $this->auditoriaVeiculoDAO->getAllList($this->filtro);
            $auditoriaPessoaList = $this->auditoriaPessoaDAO->getAllList($this->filtro);
            require_once '../View/view_S2_auditoria_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }
}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new S2Controller();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_S2) ? redirectToLogin() : $controller->getAllList();
        break;
    case "veiculo_insert":
        !isAdminLevel($ADICIONAR_S2) ? redirectToLogin() : $controller->veiculoInsert();
        break;
    case "veiculo_update":
        !isAdminLevel($EDITAR_S2) ? redirectToLogin() : $controller->veiculoUpdate();
        break;
    case "veiculo_delete":
        !isAdminLevel($EXCLUIR_S2) ? redirectToLogin() : $controller->veiculoDelete();
        break;
    case "pessoa_insert":
        !isAdminLevel($ADICIONAR_S2) ? redirectToLogin() : $controller->pessoaInsert();
        break;
    case "pessoa_update":
        !isAdminLevel($EDITAR_S2) ? redirectToLogin() : $controller->pessoaUpdate();
        break;
    case "pessoa_delete":
        !isAdminLevel($EXCLUIR_S2) ? redirectToLogin() : $controller->pessoaDelete();
        break;
    case "servico_veiculo":
        $controller->veiculoCheck();
        break;
    case "servico_veiculo_preccp":
        $controller->veiculoPreccpCheck();
        break;
    case "servico_pessoa":
        //$controller->pessoaCheck();
        break;
    case "auditoriaList":
        !isAdminLevel($LISTAR_S2) ? redirectToLogin() : $controller->auditoriaList();
        break;
    default:
        break;
}
?>