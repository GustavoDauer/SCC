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
require_once '../Model/Visitante.php';
require_once '../DAO/FotoDAO.php';

class VisitanteDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "/*START TRANSACTION;*/ "
                    . "INSERT INTO Visitante("
                    . "nome, cpf, telefone, destino, dataEntrada, dataSaida, cracha, temporario "
                    . ") "
                    . "VALUES("
                    . "'" . $object->getNome() . "', "
                    . "'" . $object->getCpf() . "', "
                    . "'" . $object->getTelefone() . "', "
                    . "'" . $object->getDestino() . "' "
                    . ", " . (!empty($object->getDataEntrada()) ? "'" . $object->getDataEntrada() . " " . $object->getHoraEntrada() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataSaida()) ? "'" . $object->getDataSaida() . " " . $object->getHoraSaida() . "' " : "NULL ")
                    . ", '" . $object->getCracha() . "' "
                    . ", " . (empty($object->getTemporario()) ? 0 : 1)
                    . ");";                                                    
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $object->setId($c->insert_id);            
            if ($sqlOk) {                                
                $fotoDAO = new FotoDAO();
                if ($object->getId() > 0) {
                    $sqlOk = $fotoDAO->uploadFoto($object->getArquivoFoto(), $object->getId()); 
                } else {
                    throw new Exception("Não foi preenchido o ID para geração do nome do arquivo de foto.");
                }
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
            $sql = "UPDATE Visitante SET "
                    . "nome = '" . $object->getNome() . "', "
                    . "cpf = '" . $object->getCpf() . "', "
                    . "telefone = '" . $object->getTelefone() . "', "
                    . "destino = '" . $object->getDestino() . "' "
                    . ", dataEntrada = " . (!empty($object->getDataEntrada()) ? "'" . $object->getDataEntrada() . " " . $object->getHoraEntrada() . "' " : "NULL ")
                    . ", dataSaida = " . (!empty($object->getDataSaida()) ? "'" . $object->getDataSaida() . " " . $object->getHoraSaida() . "' " : "NULL ")
                    . ", cracha = '" . $object->getCracha() . "' "
                    . ", foto = '" . $object->getId() . ".jpg' "
                    . ", temporario = " . (empty($object->getTemporario()) ? 0 : 1)
                    . " WHERE idVisitante = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            if ($sqlOk && !empty($object->getArquivoFoto()["name"])) {
                $fotoDAO = new FotoDAO();
                $sqlOk = $fotoDAO->uploadFoto($object->getArquivoFoto(), $object->getId());
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
            $sql = "DELETE FROM Visitante "
                    . " WHERE idVisitante = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            if ($sqlOk) {
                $fotoDAO = new FotoDAO();
                $sqlOk = $fotoDAO->deleteFoto($object->getId());
            }
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
                    . "DATE_FORMAT(dataEntrada, '%H:%i em %d/%m/%Y') as dataEntrada, "
                    . "DATE_FORMAT(dataSaida, '%H:%i em %d/%m/%Y') as dataSaida "
                    . " FROM Visitante "
                    . (!empty($filtro["inicio"]) || !empty($filtro["fim"]) ? " WHERE " : "")
                    . (!empty($filtro["inicio"]) ? " dataEntrada >= '" . $filtro["inicio"] . "' AND " : "")
                    . (!empty($filtro["fim"]) && !empty($filtro["inicio"]) ? " dataEntrada <= '" . $filtro["fim"] . "' " : "")
                    . " ORDER BY dataEntrada DESC ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Visitante($objectArray);
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
                    . " FROM Visitante "
                    . " WHERE idVisitante = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Visitante($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idVisitante"],
            "nome" => $row["nome"],
            "cpf" => $row["cpf"],
            "telefone" => $row["telefone"],
            "destino" => $row["destino"],
            "dataEntrada" => $row["dataEntrada"],
            "dataSaida" => $row["dataSaida"],
            "dataEntradaFormatada" => $row["dataEntradaFormatada"],
            "cracha" => $row["cracha"],
            "foto" => $row["foto"],
            "temporario" => $row["temporario"]
        );
    }

}
