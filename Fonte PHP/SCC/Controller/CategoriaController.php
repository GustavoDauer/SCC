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
require_once '../DAO/CategoriaDAO.php';

class CategoriaController {

    private $categoriaInstance, // Model instance to be used by Controller and DAO
            $categoriaDAO;        // DAO instance for database operations                

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {                
        $this->categoriaInstance = new Categoria();
        $this->categoriaInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));        
        $this->categoriaInstance->setCategoria(filter_input(INPUT_POST, "categoria", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));        
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters            
            $this->categoriaDAO = new CategoriaDAO();            
            $objectList = $this->categoriaDAO->getAllList();
            require_once '../View/view_requisicao_categoria_list.php';
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
            $this->categoriaDAO = new CategoriaDAO();                        
            if ($this->categoriaInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->categoriaDAO->insert($this->categoriaInstance)) {                    
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->categoriaInstance;
                require_once '../View/view_requisicao_categoria_edit.php';
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
            $this->categoriaDAO = new CategoriaDAO();            
            if ($this->categoriaInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->categoriaDAO->update($this->categoriaInstance)) {                    
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!");
                }
            } else { // Require the view of the form   
                $this->categoriaInstance = $this->categoriaInstance->getId() > 0 ? $this->categoriaDAO->getById($this->categoriaInstance->getId()) : null;
                $object = $this->categoriaInstance;                             
                require_once '../View/view_requisicao_categoria_edit.php';
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
            $this->categoriaDAO = new CategoriaDAO();            
            if ($this->categoriaInstance->getId() != null) {
                if ($this->categoriaDAO->delete($this->categoriaInstance)) {                    
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
$controller = new CategoriaController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_CATEGORIA) ? redirectToLogin() : $controller->getAllList();
        break;
    case "insert":
        !isAdminLevel($ADICIONAR_CATEGORIA) ? redirectToLogin() : $controller->insert();
        break;
    case "update":
        !isAdminLevel($EDITAR_CATEGORIA) ? redirectToLogin() : $controller->update();
        break;
    case "delete":
        !isAdminLevel($EXCLUIR_CATEGORIA) ? redirectToLogin() : $controller->delete();
        break;    
    default:
        break;
}
?>