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
require_once '../include/comum.php';
require_once '../Model/Secao.php';
require_once '../Model/Usuario.php';

class SecaoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Secao("
                    . "secao, mensagem "
                    . ") "
                    . "VALUES("
                    . "'" . $object->getSecao() . "', "
                    . "'" . $object->getMensagem() . "' "
                    . ");";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Secao SET "
                    . "secao = '" . $object->getSecao() . "', "
                    . "mensagem = '" . $object->getMensagem() . "' "
                    . " WHERE idSecao = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function updateDataAtualizacao($secao, $mensagem = "") {
        try {
            $c = connect();
            $sql = "UPDATE Secao SET "
                    . "dataAtualizacao = CURRENT_TIMESTAMP "
                    . (!empty($mensagem) ? ", mensagem = '$mensagem' " : "")
                    . " WHERE secao = '" . $secao . "';";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Secao "
                    . " WHERE idSecao = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sql = "SELECT *, "
                    . "DATE_FORMAT(dataAtualizacao, '%d/%m/%Y %H:%i') as dataAtualizacao, DATE_FORMAT(dataAtualizacao, '%Y/%m/%d') as dataAtualizacaoOriginal "
                    . " FROM Secao "
                    . " ORDER BY secao";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Secao($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT *, "
                    . "DATE_FORMAT(dataAtualizacao, '%d/%m/%Y %H:%i') as dataAtualizacao, DATE_FORMAT(dataAtualizacao, '%Y/%m/%d') as dataAtualizacaoOriginal "
                    . " FROM Secao "
                    . " WHERE idSecao = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Secao($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getBySecao($secao) {
        try {
            $c = connect();
            $sql = "SELECT *, "
                    . "DATE_FORMAT(dataAtualizacao, '%d/%m/%Y %H:%i') as dataAtualizacao, DATE_FORMAT(dataAtualizacao, '%Y/%m/%d') as dataAtualizacaoOriginal "
                    . " FROM Secao "
                    . " WHERE secao = '$secao'";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Secao($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getSecoes($id) {
        try {
            $c = connect();
            $sql = "SELECT *, "
                    . "DATE_FORMAT(dataAtualizacao, '%d/%m/%Y %H:%i') as dataAtualizacao, DATE_FORMAT(dataAtualizacao, '%Y/%m/%d') as dataAtualizacaoOriginal "
                    . " FROM Usuario "
                    . " INNER JOIN Usuario_has_Secao ON idUsuario = Usuario_idUsuario "
                    . " INNER JOIN Secao ON idSecao = Secao_idSecao "
                    . " WHERE idUsuario = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Secao($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idSecao"],
            "secao" => $row["secao"],
            "dataAtualizacao" => $row["dataAtualizacao"],
            "dataAtualizacaoOriginal" => $row["dataAtualizacaoOriginal"],
            "mensagem" => $row["mensagem"]
        );
    }

}
