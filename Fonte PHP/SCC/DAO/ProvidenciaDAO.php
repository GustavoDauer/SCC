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
            $sql = "INSERT INTO Providencia("
                    . "providencia, data, Material_idMaterial "
                    . ") "
                    . "VALUES("
                    . "'" . $object->getProvidencia() . "', "
                    . " CURRENT_DATE, "
                    . "" . $object->getIdMaterial()
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
            $sql = "UPDATE Providencia SET "
                    . "providencia = '" . $object->getProvidencia() . "' "
                    //. "data = '" . $object->getData() . "' "
                    //. "Material_idMaterial = " . $object->getIdMaterial() . " "
                    . "WHERE idProvidencia = " . $object->getId();
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
            $sql = "DELETE FROM Providencia "
                    . " WHERE idProvidencia = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);            
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList() {
        try {
            $c = connect();
            $sql = "SELECT *, "
                    . "DATE_FORMAT(data, '%d/%m/%Y') as data "
                    . " FROM Providencia ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Providencia($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getByMaterialId($id) {
        try {           
            $c = connect();
            $sql = "SELECT *, "
                    . "DATE_FORMAT(data, '%d/%m/%Y') as data "
                    . " FROM Providencia "
                    . " WHERE Material_idMaterial = $id";
            $result = $c->query($sql);            
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Providencia($objectArray);
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
                    . "DATE_FORMAT(data, '%d/%m/%Y') as data "
                    . " FROM Providencia "
                    . " WHERE idProvidencia = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Providencia($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
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
