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
require_once '../Model/Sped.php';
require_once '../DAO/ArquivoDAO.php';

class SpedDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Sped("
                    . "titulo, Pessoa_idPessoa, resolvido, prazo, data, tipo, assunto "
                    . ") "
                    . "VALUES("
                    . "'" . $object->getTitulo() . "' "
                    . ", " . $object->getIdResponsavel()
                    . ", " . (empty($object->getResolvido()) ? "0 " : $object->getResolvido())
                    . ", " . (empty($object->getPrazo()) ? "NULL" : "'" . $object->getPrazo() . "'")
                    . ", " . (empty($object->getData()) ? "NULL" : "'" . $object->getData() . "'")
                    . ", " . (empty($object->getTipo()) ? "NULL" : "'" . $object->getTipo() . "'")
                    . ", '" . $object->getAssunto() . "'"
                    . ");";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            if ($sqlOk && is_array($object->getArquivoPDF())) {
                $arquivoDAO = new ArquivoDAO();
                $sqlOk = $arquivoDAO->uploadArquivo($object->getArquivoPDF(), $c->insert_id);
            }
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Sped SET "
                    . "titulo = '" . $object->getTitulo() . "'"
                    . ", Pessoa_idPessoa = " . (empty($object->getIdResponsavel()) ? "NULL" : $object->getIdResponsavel())
                    . ", resolvido = " . (empty($object->getResolvido()) ? "0" : $object->getResolvido())
                    . ", prazo = " . (empty($object->getPrazo()) ? "NULL" : "'" . $object->getPrazo() . "'")
                    . ", data = " . (empty($object->getData()) ? "NULL" : "'" . $object->getData() . "'")
                    . ", tipo = '" . $object->getTipo() . "'"
                    . ", assunto = '" . $object->getAssunto() . "'"
                    . " WHERE idSped = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            if ($sqlOk && is_array($object->getArquivoPDF())) {
                $arquivoDAO = new ArquivoDAO();
                $sqlOk = $arquivoDAO->uploadArquivo($object->getArquivoPDF(), $object->getId());
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
            $sql = "DELETE FROM Sped "
                    . " WHERE idSped = " . $object->getId() . ";";
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
            $sql = "SELECT * "
                    . " FROM Sped ";
            if (!empty($filtro["resolvido"]) || !empty($filtro["tipo"])) {
                $sql .= " WHERE ";
                if ($filtro["resolvido"] === 0 || $filtro["resolvido"] === 1) {
                    $sql .= " resolvido = " . $filtro["resolvido"];
                }
                if ($filtro["tipo"] == "Documento" || $filtro["tipo"] == "Missao") {
                    if ($filtro["resolvido"] === 0 || $filtro["resolvido"] === 1) {
                        $sql .= " AND ";
                    }
                    $sql .= " tipo = '" . $filtro["tipo"] . "'";
                }
            } else {
                $sql .= " WHERE resolvido = 0";
            }
            $sql .= " ORDER BY prazo ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Sped($objectArray);
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
                    . " FROM Sped "
                    . " WHERE idSped = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Sped($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idSped"],
            "resolvido" => $row["resolvido"],
            "idResponsavel" => $row["Pessoa_idPessoa"],
            "titulo" => $row["titulo"],
            "assunto" => $row["assunto"],
            "prazo" => $row["prazo"],
            "data" => $row["data"],
            "tipo" => $row["tipo"],
            "arquivoNome" => $row["arquivo"],
            "arquivoPDF" => ""
        );
    }
}
