<?php

/* * *****************************************************************************
 * 
 * Copyright © 2025 Gustavo Henrique Mello Dauer - 1º Ten 
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
require_once '../Model/Combustivel.php';

class CombustivelDAO {

    public function update($object) {
        try {
            $c = connect();
            $sql = "
                UPDATE `scc`.`Combustivel` SET
                    `ctc01-celula1` = ?,
                    `ctc01-celula2` = ?,
                    `ctc01-celula3` = ?,
                    `ctc01-celula1-valor` = ?,
                    `ctc01-celula2-valor` = ?,
                    `ctc01-celula3-valor` = ?,
                    `ctc04-celula1` = ?,
                    `ctc04-celula2` = ?,
                    `ctc04-celula3` = ?,
                    `ctc04-celula1-valor` = ?,
                    `ctc04-celula2-valor` = ?,
                    `ctc04-celula3-valor` = ?,
                    `diesel` = ?,
                    `gasolina` = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param(
                    "ssssssssssssss",
                    $object->getCtc01celula1(),
                    $object->getCtc01celula2(),
                    $object->getCtc01celula3(),
                    $object->getCtc01celula1valor(),
                    $object->getCtc01celula2valor(),
                    $object->getCtc01celula3valor(),
                    $object->getCtc04celula1(),
                    $object->getCtc04celula2(),
                    $object->getCtc04celula3(),
                    $object->getCtc04celula1valor(),
                    $object->getCtc04celula2valor(),
                    $object->getCtc04celula3valor(),
                    $object->getDiesel(),
                    $object->getGasolina()
            );
            $sqlOk = $stmt ? $stmt->execute() : false;
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
            $sql = "SELECT *, 
                        REPLACE(`ctc01-celula1-valor`, '.', ',') as `ctc01-celula1-valor`,
                        REPLACE(`ctc01-celula2-valor`, '.', ',') as `ctc01-celula2-valor`,
                        REPLACE(`ctc01-celula3-valor`, '.', ',') as `ctc01-celula3-valor`,
                        REPLACE(`ctc04-celula1-valor`, '.', ',') as `ctc04-celula1-valor`,
                        REPLACE(`ctc04-celula2-valor`, '.', ',') as `ctc04-celula2-valor`,
                        REPLACE(`ctc04-celula3-valor`, '.', ',') as `ctc04-celula3-valor`,
                        REPLACE(`diesel`, '.', ',') as `diesel`,
                        REPLACE(`gasolina`, '.', ',') as `gasolina`
                    FROM Combustivel";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Combustivel($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "ctc01celula1" => $row["ctc01-celula1"],
            "ctc01celula2" => $row["ctc01-celula2"],
            "ctc01celula3" => $row["ctc01-celula3"],
            "ctc01celula1valor" => $row["ctc01-celula1-valor"],
            "ctc01celula2valor" => $row["ctc01-celula2-valor"],
            "ctc01celula3valor" => $row["ctc01-celula3-valor"],
            "ctc04celula1" => $row["ctc04-celula1"],
            "ctc04celula2" => $row["ctc04-celula2"],
            "ctc04celula3" => $row["ctc04-celula3"],
            "ctc04celula1valor" => $row["ctc04-celula1-valor"],
            "ctc04celula2valor" => $row["ctc04-celula2-valor"],
            "ctc04celula3valor" => $row["ctc04-celula3-valor"],
            "diesel" => $row["diesel"],
            "gasolina" => $row["gasolina"]
        );
    }
}
