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
require_once '../Model/Veiculo.php';

class VeiculoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Veiculo("
                    . "marca, modelo, anoFabricacao, anoModelo, cor, placa, placaEB, tipo, Pessoa_idPessoa"
                    . ") "
                    . "VALUES("
                    . "'" . $object->getMarca() . "'"
                    . ", '" . $object->getModelo() . "'"
                    . ", " . ($object->getAnoFabricacao() > 0 ? $object->getAnoFabricacao() : 'NULL') . ""
                    . ", " . ($object->getAnoModelo() > 0 ? $object->getAnoModelo() : 'NULL') . ""
                    . ", '" . $object->getCor() . "'"
                    . ", '" . $object->getPlaca() . "'"
                    . ", '" . $object->getPlacaEB() . "'"
                    . ", '" . $object->getTipo() . "'"
                    . ", " . ($object->getIdPessoa() > 0 ? $object->getIdPessoa() : 'NULL') . ""
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
            $sql = "UPDATE Veiculo SET "
                    . "  marca = '" . $object->getMarca() . "'"
                    . ", modelo = '" . $object->getModelo() . "'"
                    . ", anoFabricacao = " . ($object->getAnoFabricacao() > 0 ? $object->getAnoFabricacao() : 'NULL') . ""
                    . ", anoModelo = " . ($object->getAnoModelo() > 0 ? $object->getAnoModelo() : 'NULL') . ""
                    . ", cor = '" . $object->getCor() . "'"
                    . ", placa = '" . $object->getPlaca() . "'"
                    . ", placaEB = '" . $object->getPlacaEB() . "'"
                    . ", tipo = '" . $object->getTipo() . "'"
                    . ", Pessoa_idPessoa = " . ($object->getIdPessoa() > 0 ? $object->getIdPessoa() : 'NULL') . ""
                    . " WHERE idVeiculo = " . $object->getId() . ";";
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
            $sql = "DELETE FROM Veiculo "
                    . " WHERE idVeiculo = " . $object->getId() . ";";
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
                    . " FROM Veiculo "
                    . " LEFT JOIN Pessoa ON Pessoa.idPessoa = Veiculo.Pessoa_idPessoa ";
            if (empty($filtro["dataExpiracao"]) || (isset($filtro["dataExpiracao"]) && $filtro["dataExpiracao"] == "ativos")) {
                $sql .= " WHERE dataExpiracao >= CURRENT_DATE ";
            } else if (isset($filtro["dataExpiracao"]) && $filtro["dataExpiracao"] == "expirados") {
                $sql .= " WHERE dataExpiracao <= CURRENT_DATE OR dataExpiracao is NULL ";
            }
            $sql .= " ORDER BY Posto_idPosto DESC, Pessoa_idPessoa ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Veiculo($objectArray);
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
                    . " FROM Veiculo "
                    . " WHERE idVeiculo = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Veiculo($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function checkPlaca($placa) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Veiculo "                    
                    . " LEFT JOIN Pessoa ON Pessoa_idPessoa = idPessoa "
                    . " WHERE placa = '$placa' AND dataExpiracao >= CURRENT_DATE";            
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Veiculo($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idVeiculo"],
            "marca" => $row["marca"],
            "modelo" => $row["modelo"],
            "anoFabricacao" => $row["anoFabricacao"],
            "anoModelo" => $row["anoModelo"],
            "cor" => $row["cor"],
            "placa" => $row["placa"],
            "placaEB" => $row["placaEB"],
            "tipo" => $row["tipo"],            
            "idPessoa" => $row["Pessoa_idPessoa"]
        );
    }
}
