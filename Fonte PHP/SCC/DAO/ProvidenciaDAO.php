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
require_once '../Model/Providencia.php';

class ProvidenciaDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Providencia (providencia, data, Material_idMaterial) VALUES (?, CURRENT_DATE, ?)";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $providencia = $object->getProvidencia();
            $idMaterial = $object->getIdMaterial();
            // Supondo que providencia é string e Material_idMaterial é inteiro
            $stmt->bind_param("si", $providencia, $idMaterial);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Providencia SET providencia = ? WHERE idProvidencia = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $providencia = $object->getProvidencia();
            $id = $object->getId();
            // 's' para string (providencia), 'i' para inteiro (id)
            $stmt->bind_param("si", $providencia, $id);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Providencia WHERE idProvidencia = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $id = $object->getId();
            $stmt->bind_param("i", $id);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList() {
        try {
            $c = connect();
            $sql = "SELECT *, DATE_FORMAT(data, '%d/%m/%Y') as dataFormatada FROM Providencia";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Providencia($objectArray);
            }
            $stmt->close();
            $c->close();
            return !empty($lista) ? $lista : null;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByMaterialId($id) {
        try {
            $c = connect();
            $sql = "SELECT *, DATE_FORMAT(data, '%d/%m/%Y') as dataFormatada FROM Providencia WHERE Material_idMaterial = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Providencia($objectArray);
            }
            $stmt->close();
            $c->close();
            return !empty($lista) ? $lista : null;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT *, DATE_FORMAT(data, '%d/%m/%Y') as dataFormatada FROM Providencia WHERE idProvidencia = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $instance = null;
            if ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Providencia($objectArray);
            }
            $stmt->close();
            $c->close();
            return $instance;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idProvidencia"],
            "providencia" => $row["providencia"],
            "data" => $row["data"],
            "idMaterial" => $row["idMaterial"]
        );
    }
}
