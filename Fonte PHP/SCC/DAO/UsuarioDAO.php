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
require_once '../Model/Usuario.php';

class UsuarioDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Usuario("
                    . "login, nome, senha, status, Posto_idPosto"
                    . ") "
                    . "VALUES("
                    . "'" . $object->getLogin() . "', "
                    . "'" . $object->getNome() . "', "
                    . "'" . password_hash($object->getSenha(), PASSWORD_DEFAULT) . "', "
                    . $object->getStatus() . ", "
                    . $object->getIdPosto()
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
            $sql = "UPDATE Usuario SET "
                    . "login = '" . $object->getLogin() . "', "
                    . "nome = '" . $object->getNome() . "' ";
            $sql .= !empty($object->getSenha()) ? ", senha = '" . password_hash($object->getSenha(), PASSWORD_DEFAULT) . "' " : "";
            $sql .= ", status = " . (empty($object->getStatus()) ? 0 : 1)
                    . ", Posto_idPosto = " . $object->getIdPosto()
                    . " WHERE idUsuario = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $idSecoes = $object->getIdSecoes();
            if (isset($idSecoes) && !empty($idSecoes) && $idSecoes != null) {
                $sql = "DELETE FROM Usuario_has_Secao "
                        . " WHERE Usuario_idUsuario = " . $object->getId() . ";";
                $stmt = $c->prepare($sql);
                $sqlOk = $stmt ? $stmt->execute() : false;
                if (!$sqlOk) {
                    return false;
                }
                foreach ($idSecoes as $idSecao) {
                    $sql = "INSERT INTO Usuario_has_Secao(Usuario_idUsuario, Secao_idSecao) VALUES ("
                            . $object->getId() . ", "
                            . $idSecao
                            . ");";
                    $stmt = $c->prepare($sql);
                    $sqlOk = $stmt ? $stmt->execute() : false;
                    if (!$sqlOk) {
                        return false;
                    }
                }
                return $sqlOk;
            }
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Usuario_has_Secao "
                    . " WHERE Usuario_idUsuario = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            if (!$sqlOk) {
                return false;
            }
            $sql = "DELETE FROM Usuario "
                    . " WHERE idUsuario = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($status = "") {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Usuario ";
            $sql .= $status == "" ? "" : " WHERE status = $status";
            $sql .= " ORDER BY status DESC, nome, idUsuario ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Usuario($objectArray);
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
            $sql = "SELECT * "
                    . " FROM Usuario "
                    . " WHERE idUsuario = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Usuario($objectArray);
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
            $sql = "SELECT * "
                    . " FROM Usuario "
                    . " INNER JOIN Usuario_has_Secao ON idUsuario = Usuario_idUsuario "
                    . " INNER JOIN Secao ON idSecao = Secao_idSecao "
                    . " WHERE idUsuario = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Usuario($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function login($usuario) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Usuario "
                    . " WHERE login = '" . $usuario->getLogin() . "' AND status = 1";
            $result = $c->query($sql);
            $instance = null;
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Usuario($objectArray);
            }
            $c->close();
            if (!is_null($instance) && password_verify($usuario->getSenha(), $instance->getSenha())) { // Verificação da senha e do hash
                return $instance;
            } else {
                $erros = isset($_COOKIE["errologin"]) ? $_COOKIE["errologin"] : 1;
                setcookie("errologin", $erros + 1, time() + (86400 * 7));
                throw new Exception("Usuário e/ou senha não correspondem!<br><i>Tentativas de login sem sucesso: $erros</i><br>IP: " . get_client_ip() . "<br>Data: " . date("d/m/Y H:i"));
                return null;
            }
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idUsuario"],
            "login" => $row["login"],
            "nome" => $row["nome"],
            "senha" => $row["senha"],
            "status" => $row["status"],
            "idPosto" => $row["Posto_idPosto"]
        );
    }

}
