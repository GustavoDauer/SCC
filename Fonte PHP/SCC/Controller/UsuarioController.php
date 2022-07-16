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
require_once '../DAO/UsuarioDAO.php';
require_once '../DAO/PostoDAO.php';
require_once '../DAO/SecaoDAO.php';

class UsuarioController {

    private $instance, // Model instance to be used by Controller and DAO
            $instanceDAO;   // DAO instance for database operations

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $this->instance = new Usuario();
        $this->instance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->instance->setLogin(filter_input(INPUT_POST, "login", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->instance->setNome(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        //$this->instance->setSenha(!empty(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)) ? md5(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)) : null);
        $this->instance->setSenha(!empty(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)) ? filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES) : null);
        $this->instance->setStatus(!empty(filter_input(INPUT_POST, "status", FILTER_VALIDATE_INT)) ? filter_input(INPUT_POST, "status", FILTER_VALIDATE_INT) : 0);
        $this->instance->setIdPosto(filter_input(INPUT_POST, "idPosto", FILTER_VALIDATE_INT));
        $this->instance->setIdSecoes(filter_input(INPUT_POST, "idSecoes", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY));
        $this->status = filter_input(INPUT_GET, "status", FILTER_VALIDATE_INT); // FILTROS - REFATORAR PARA USO DE ARRAY        
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters
            $this->instanceDAO = new UsuarioDAO();
            $secaoDAO = new SecaoDAO();
            $postoDAO = new PostoDAO();
            $status = $this->status;
            $objectList = $this->instanceDAO->getAllList($status);
            require_once '../View/view_usuario_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function insert() {
        try {
            $this->getFormData();
            $this->instanceDAO = new UsuarioDAO();
            $postoDAO = new PostoDAO();
            $postoList = $postoDAO->getAllList();
            if ($this->instance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->instanceDAO->insert($this->instance)) {
                    //header("Location: UsuarioController.php?action=getAllList"); 
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->instance;
                require_once '../View/view_usuario_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function update() {
        try {
            $this->getFormData();
            $this->instanceDAO = new UsuarioDAO();
            $secaoDAO = new SecaoDAO();
            $postoDAO = new PostoDAO();
            $postoList = $postoDAO->getAllList();
            if ($this->instance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                
                if ($this->instanceDAO->update($this->instance)) {
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form            
                $this->instance = $this->instance->getId() > 0 ? $this->instanceDAO->getById($this->instance->getId()) : null;
                $object = $this->instance;
                if ($object == null) {
                    throw new Exception("Problema na obtenção de dados no controlador!");
                } else {
                    $object->setSenha(null); // Não envia a senha do usuário para a view
                }
                require_once '../View/view_usuario_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function delete() {
        try {
            $this->getFormData();
            $this->instanceDAO = new UsuarioDAO();
            if ($this->instance->getId() != null) {
                if ($this->instanceDAO->delete($this->instance)) {
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
     * User login, user ban by cookie and section based redirection
     */
    public function login() {
        try {
            $this->getFormData();
            $erros = isset($_COOKIE["errologin"]) ? $_COOKIE["errologin"] : 1;
            if ($erros > 25) { // Bloqueio de tentativas de logins                
                header("Location: ../View/view_usuario_login.php");
                exit();
            }
            $this->instanceDAO = new UsuarioDAO();
            $postoDAO = new PostoDAO();            
            $object = $this->instanceDAO->login($this->instance);            
            if (isset($object) && !is_null($object)) {
                session_name(md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
                $posto = $postoDAO->getById($object->getIdPosto());
                $_SESSION["sccid"] = $object->getId();
                $_SESSION["scclogin"] = $object->getLogin();
                $_SESSION["sccnome"] = $object->getNome();
                $_SESSION["sccstatus"] = $object->getStatus();
                $_SESSION["sccposto"] = $posto->getPosto();
                $secaoDAO = new SecaoDAO(); // Obter seções e direcionar pra página correspondente
                $objectList = $secaoDAO->getSecoes($_SESSION["sccid"]);
                if ($objectList != null && !empty($objectList)) {
                    $_SESSION["sccsecoes"] = $objectList;
                    if ($objectList != null) {
                        foreach ($objectList as $secao) {
                            if (file_exists($secao->getSecao() . "Controller.php")) {
                                header("Location: " . $secao->getSecao() . "Controller.php?action=getAllList"); // Redireciona para a primeira seção válida
                                exit();
                            }
                        }
                    }
                }
                header("Location: DefaultController.php?action=getAllList"); // Redireciona para o DefaultController
            } else {
                throw("Falha ao logar no sistema!");
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * User logout
     */
    public function logout() {
        session_destroy();
        header("Location: ../View/view_usuario_login.php");
    }

    /**
     * Change the user password
     */
    public function changePassword() {
        try {
            $this->getFormData();
            $senha = $this->instance->getSenha(); // Salva a nova senha
            $this->instanceDAO = new UsuarioDAO();
            if (!empty($senha)) {
                $this->instance = $this->instance->getId() > 0 ? $this->instanceDAO->getById($this->instance->getId()) : null;
                $this->instance->setSenha($senha); // Atualiza com a senha salva
                if ($this->instanceDAO->update($this->instance)) {
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form   
                $this->instance = $this->instance->getId() > 0 ? $this->instanceDAO->getById($this->instance->getId()) : null;
                $object = $this->instance;
                if ($object == null) {
                    throw new Exception("Problema na obtenção de dados no controlador!");
                } else {
                    $object->setSenha(null); // Não envia a senha do usuário para a view
                }
                require_once '../View/view_usuario_changePassword.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new UsuarioController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_USUARIO) ? redirectToLogin() : $controller->getAllList();
        break;
    case "insert":
        !isAdminLevel($ADICIONAR_USUARIO) ? redirectToLogin() : $controller->insert();
        break;
    case "update":
        !isAdminLevel($EDITAR_USUARIO) ? redirectToLogin() : $controller->update();
        break;
    case "delete":
        !isAdminLevel($EXCLUIR_USUARIO) ? redirectToLogin() : $controller->delete();
        break;
    case "login": $controller->login();
        break;
    case "logout": $controller->logout();
        break;
    case "changePassword": $controller->changePassword();
        break;
    default:
        break;
}
?>