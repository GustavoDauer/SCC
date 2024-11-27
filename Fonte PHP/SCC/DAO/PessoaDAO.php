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
require_once '../Model/Pessoa.php';
require_once '../DAO/FotoDAO.php';

class PessoaDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Pessoa("
                    . "nome, nomeGuerra, Posto_idPosto, cpf, identidadeMilitar, preccp, Vinculo_idVinculo, dataCadastro, dataExpiracao "
                    . ") "
                    . "VALUES("
                    . "'" . $object->getNome() . "'"
                    . ", '" . $object->getNomeGuerra() . "'"
                    . ", " . $object->getIdPosto() . ""
                    . ", '" . $object->getCpf() . "'"
                    . ", '" . $object->getIdentidadeMilitar() . "'"
                    . ", '" . $object->getPreccp() . "'"
                    . ", " . $object->getIdVinculo() . ""
                    . ", CURRENT_DATE "
                    . ", " . (!empty($object->getDataExpiracao()) ? "'" . $object->getDataExpiracao() . "'" : "NULL")
                    . ");";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $object->setId($c->insert_id);
            if ($sqlOk) {
                $fotoDAO = new FotoDAO();
                if ($object->getId() > 0) {
                    $sqlOk = $fotoDAO->uploadFoto($object->getArquivoFoto(), $object->getId(), "S2-Pessoa-");
                    $sql = "UPDATE Pessoa SET "
                            . " foto = 'S2-Pessoa-" . $object->getId() . ".jpg'"
                            . " WHERE idPessoa = " . $object->getId() . ";";
                    $stmt_foto = $c->prepare($sql);
                    $sqlOk = $stmt_foto ? $stmt_foto->execute() : false;
                }
            }
            if (!$sqlOk) {
                throw new Exception("Houve um problema na geração do ID relativo ao nome do arquivo de foto.");
            }
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
        return true;
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Pessoa SET "
                    . "  nome = '" . $object->getNome() . "'"
                    . ", nomeGuerra = '" . $object->getNomeGuerra() . "'"
                    . ", Posto_idPosto = " . $object->getIdPosto() . ""
                    . ", cpf = '" . $object->getCpf() . "'"
                    . ", identidadeMilitar = '" . $object->getIdentidadeMilitar() . "'"
                    . ", preccp = '" . $object->getPreccp() . "'"
                    . ", foto = 'S2-Pessoa-" . $object->getId() . ".jpg' "
                    . ", Vinculo_idVinculo = " . $object->getIdVinculo() . ""
                    . ", dataExpiracao = " . (!empty($object->getDataExpiracao()) ? "'" . $object->getDataExpiracao() . "'" : "NULL") . ""
                    . " WHERE idPessoa = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            if ($sqlOk && !empty($object->getArquivoFoto()["name"])) {
                $fotoDAO = new FotoDAO();
                $sqlOk = $fotoDAO->uploadFoto($object->getArquivoFoto(), $object->getId(), "S2-Pessoa-");
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
            $sql = "DELETE FROM Pessoa "
                    . " WHERE idPessoa = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            if ($sqlOk) {
                $fotoDAO = new FotoDAO();
                $sqlOk = $fotoDAO->deleteFoto("S2-Pessoa-" . $object->getId());
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
            $sql = "SELECT * "
                    . " FROM Pessoa "
                    . " INNER JOIN Posto ON idPosto = Posto_idPosto "
                    . " INNER JOIN Vinculo ON idVinculo = Vinculo_idVinculo ";
            if (isset($filtro["dataExpiracao"]) && $filtro["dataExpiracao"] == "ativos") {
                $sql .= " WHERE dataExpiracao >= CURRENT_DATE ";
            } else if (isset($filtro["dataExpiracao"]) && $filtro["dataExpiracao"] == "expirados") {
                $sql .= " WHERE dataExpiracao < CURRENT_DATE ";
            }
            $sql .= " ORDER BY dataExpiracao ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Pessoa($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getById($id) {
        if (!($id > 0)) {
            return null;
        }
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Pessoa "
                    . " WHERE idPessoa = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Pessoa($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getSCFExByPreccp($preccp) {
        try {
            $c = connectSCFEx();
            $sql = "SELECT * "
                    . " FROM Beneficiario "
                    . " WHERE (";
            for ($i = 0; $i < 10; $i++) {
                $sql .= " preccp = '$preccp-0$i' OR preccp = '" . $preccp . "0$i' ";
                $sql .= $i != 9 ? " OR " : "";
            }
            $sql .= " ) AND status=1";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $instance = new Pessoa();
                $instance->setNome($row["nome"]);
                $instance->setPreccp($row["preccp"]);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function checkIdentidadeMilitar($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Pessoa "
                    . " WHERE identidadeMilitar = '$id' AND dataExpiracao >= CURRENT_DATE";            
            $result = $c->query($sql);                 
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Pessoa($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }
    
    public function fillArray($row) {
        return array(
            "id" => $row["idPessoa"],
            "nome" => $row["nome"],
            "nomeGuerra" => $row["nomeGuerra"],
            "idPosto" => $row["Posto_idPosto"],
            "cpf" => $row["cpf"],
            "identidadeMilitar" => $row["identidadeMilitar"],
            "preccp" => $row["preccp"],
            "foto" => $row["foto"],
            "idVinculo" => $row["Vinculo_idVinculo"],
            "dataCadastro" => $row["dataCadastro"],
            "dataExpiracao" => $row["dataExpiracao"]
        );
    }
}
