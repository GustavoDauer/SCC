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
require_once '../Model/AuditoriaPessoa.php';

class AuditoriaPessoaDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO AuditoriaPessoa("
                    . "Pessoa_idPessoa, dataEntrada, local, identidade, autorizacao"
                    . ") "
                    . "VALUES("
                    . ($object->getIdPessoa() > 0 ? $object->getIdPessoa() : "NULL")
                    . ", " . ($object->getAutorizacao() === 1 ? "CURRENT_TIME" : "NULL")                    
                    . ", '" . $object->getLocal() . "'"
                    . ", '" . $object->getIdentidade() . "'"
                    . ", " . $object->getAutorizacao() . ""
                    . ");";
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
            $sql = "DELETE FROM AuditoriaPessoa "
                    . " WHERE Pessoa_idPessoa = " . $object->getIdPessoa() . " AND dataEntrada = " . $object->getDataEntrada() . ";";
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
                    . " FROM AuditoriaPessoa ";                   
            $dataHoje = date('Y-m-d');
            $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
            $inicio = !isset($filtro["inicio"]) ? $dataHoje : $filtro["inicio"];
            $fim = !isset($filtro["fim"]) ? $dataAmanha : $filtro["fim"];
            $sql .= " WHERE dataEntrada >= '" . $inicio . " 00:00'"
                    . " AND dataEntrada <= '" . $fim . " 23:59'"
                    . " ORDER BY dataEntrada"; 
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new AuditoriaPessoa($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }           

    public function fillArray($row) {
        return array(
            "idPessoa" => $row["Pessoa_idPessoa"],
            "dataEntrada" => $row["dataEntrada"],
            "dataSaida" => $row["dataSaida"],
            "local" => $row["local"],                        
            "autorizacao" => $row["autorizacao"] ,
            "identidade" => $row["identidade"]
        );
    }
}
