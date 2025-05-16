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
require_once '../Model/AuditoriaPessoa.php';

class AuditoriaPessoaDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO AuditoriaPessoa (
                        Pessoa_idPessoa, dataEntrada, local, identidade, autorizacao
                    ) VALUES (
                        ?, CURRENT_TIME, ?, ?, ?
                    )";
            $stmt = $c->prepare($sql);
            $idPessoa = $object->getIdPessoa() > 0 ? $object->getIdPessoa() : null;
            $local = $object->getLocal();
            $identidade = $object->getIdentidade();
            $autorizacao = $object->getAutorizacao();
            $stmt->bind_param("isss", $idPessoa, $local, $identidade, $autorizacao);
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sql = "SELECT * FROM AuditoriaPessoa 
                    WHERE dataEntrada >= ? AND dataEntrada <= ?
                    ORDER BY dataEntrada";
            $dataHoje = date('Y-m-d');
            $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
            $inicio = !isset($filtro["inicio"]) ? $dataHoje : $filtro["inicio"];
            $fim = !isset($filtro["fim"]) ? $dataAmanha : $filtro["fim"];
            $inicio .= " 00:00";
            $fim .= " 23:59";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("ss", $inicio, $fim);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new AuditoriaPessoa($objectArray);
            }
            $stmt->close();
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
            "autorizacao" => $row["autorizacao"],
            "identidade" => $row["identidade"]
        );
    }
}
