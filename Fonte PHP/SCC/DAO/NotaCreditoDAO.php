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
require_once '../Model/NotaCredito.php';

class NotaCreditoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO `scc`.`NotaCredito` (`dataNc`, `nc`, `pi`, `valor`, `gestorNc`, `ptres`, `fonte`, `ug`) "
                    . "VALUES ("
                    . "'" . $object->getDataNc() . "' "
                    . ", '" . $object->getNc() . "' "
                    . ", '" . $object->getPi() . "' "
                    . ", '" . $object->getValor() . "' "
                    . ", '" . $object->getGestorNc() . "' "
                    . ", '" . $object->getPtres() . "' "
                    . ", '" . $object->getFonte() . "' "
                    . ", '" . $object->getUg() . "' "
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
            $sql = "UPDATE `scc`.`NotaCredito`
                    SET                        
                        `dataNc` = '" . $object->getDataNc() . "'
                        , `nc` = '" . $object->getNc() . "'
                        , `pi` = '" . $object->getPi() . "'
                        , `valor` = '" . $object->getValor() . "'
                        , `gestorNc` = '" . $object->getGestorNc() . "'
                        , `ptres` = '" . $object->getPtres() . "'
                        , `fonte` = '" . $object->getFonte() . "'
                        , `ug` = '" . $object->getUg() . "'
                        WHERE `idNotaCredito` = " . $object->getId() . ";";
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
            $sql = "DELETE FROM NotaCredito "
                    . " WHERE idNotaCredito = " . $object->getId() . ";";
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
                    . "DATE_FORMAT(dataNc, '%d/%m/%Y') as dataNc "
                    . " FROM NotaCredito "
                    . " ORDER BY dataNc";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new NotaCredito($objectArray);
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
                    . " FROM NotaCredito "
                    . " WHERE idNotaCredito = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new NotaCredito($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }    

    public function fillArray($row) {
        return array(
            "id" => $row["idNotaCredito"],
            "dataNc" => $row["dataNc"],
            "nc" => $row["nc"],
            "pi" => $row["pi"],
            "valor" => $row["valor"],
            "gestorNc" => $row["gestorNc"],
            "ptres" => $row["ptres"],
            "fonte" => $row["fonte"],
            "ug" => $row["ug"],
        );
    }

}
