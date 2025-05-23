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
            $sql = "INSERT INTO Pessoa (
                    nome, nomeGuerra, Posto_idPosto, cpf, identidadeMilitar,
                    preccp, Vinculo_idVinculo, dataCadastro, dataExpiracao, telefone
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE, ?, ?
                )";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $nome = $object->getNome();
            $nomeGuerra = $object->getNomeGuerra();
            $idPosto = $object->getIdPosto();
            $cpf = $object->getCpf();
            $identidadeMilitar = $object->getIdentidadeMilitar();
            $preccp = $object->getPreccp();
            $idVinculo = $object->getIdVinculo();
            $dataExpiracao = !empty($object->getDataExpiracao()) ? $object->getDataExpiracao() : null;
            $telefone = $object->getTelefone();
            $stmt->bind_param(
                    "ssisssiss",
                    $nome,
                    $nomeGuerra,
                    $idPosto,
                    $cpf,
                    $identidadeMilitar,
                    $preccp,
                    $idVinculo,
                    $dataExpiracao,
                    $telefone
            );
            $sqlOk = $stmt->execute();
            $object->setId($c->insert_id);
            if ($sqlOk) {
                $fotoDAO = new FotoDAO();
                if ($object->getId() > 0) {
                    $sqlOk = $fotoDAO->uploadFoto($object->getArquivoFoto(), $object->getId(), "S2-Pessoa-");
                    $sql = "UPDATE Pessoa SET foto = ? WHERE idPessoa = ?";
                    $stmt_foto = $c->prepare($sql);
                    if (!$stmt_foto) {
                        throw new Exception("Erro ao preparar update da foto: " . $c->error);
                    }
                    $fotoNome = "S2-Pessoa-" . $object->getId() . ".jpg";
                    $idPessoa = $object->getId();
                    $stmt_foto->bind_param("si", $fotoNome, $idPessoa);
                    $sqlOk = $stmt_foto->execute();
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
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Pessoa SET
                    nome = ?,
                    nomeGuerra = ?,
                    Posto_idPosto = ?,
                    cpf = ?,
                    identidadeMilitar = ?,
                    preccp = ?,
                    foto = ?,
                    Vinculo_idVinculo = ?,
                    dataExpiracao = ?,
                    telefone = ?,
                    dataNascimento = ?
                WHERE idPessoa = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $nome = $object->getNome();
            $nomeGuerra = $object->getNomeGuerra();
            $idPosto = $object->getIdPosto();
            $cpf = $object->getCpf();
            $identidadeMilitar = $object->getIdentidadeMilitar();
            $preccp = $object->getPreccp();
            $foto = "S2-Pessoa-" . $object->getId() . "." . $object->getArquivoExtensao();
            $idVinculo = $object->getIdVinculo();
            $dataExpiracao = !empty($object->getDataExpiracao()) ? $object->getDataExpiracao() : null;
            $telefone = $object->getTelefone();
            $dataNascimento = !empty($object->getDataNascimento()) ? $object->getDataNascimento() : null;
            $idPessoa = $object->getId();
            $stmt->bind_param(
                    "ssissssisssi",
                    $nome,
                    $nomeGuerra,
                    $idPosto,
                    $cpf,
                    $identidadeMilitar,
                    $preccp,
                    $foto,
                    $idVinculo,
                    $dataExpiracao,
                    $telefone,
                    $dataNascimento,
                    $idPessoa
            );
            $sqlOk = $stmt->execute();
            if ($sqlOk && !empty($object->getArquivoFoto()["name"])) {
                $fotoDAO = new FotoDAO();
                $fotoDAO->deleteFoto($object->getId());
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
            $sql = "UPDATE Pessoa SET dataExpiracao = ? WHERE idPessoa = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            // Define data de expiração como 1º de março do ano anterior
            $dataExpiracao = (date('Y') - 1) . "-03-01";
            $idPessoa = $object->getId();
            $stmt->bind_param("si", $dataExpiracao, $idPessoa);
            $sqlOk = $stmt->execute();
            // Se desejar reativar a exclusão física da foto:
            /*
              if ($sqlOk) {
              $fotoDAO = new FotoDAO();
              $sqlOk = $fotoDAO->deleteFoto("S2-Pessoa-" . $object->getId());
              }
             */
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sql = "SELECT * 
                FROM Pessoa 
                INNER JOIN Posto ON idPosto = Posto_idPosto 
                INNER JOIN Vinculo ON idVinculo = Vinculo_idVinculo";
            $params = [];
            $types = "";
            $conditions = [];
            if (
                    empty($filtro["dataExpiracao"]) ||
                    (isset($filtro["dataExpiracao"]) && $filtro["dataExpiracao"] === "ativos")
            ) {
                $conditions[] = "dataExpiracao >= CURRENT_DATE";
            } elseif (isset($filtro["dataExpiracao"]) && $filtro["dataExpiracao"] === "expirados") {
                $conditions[] = "dataExpiracao < CURRENT_DATE";
            }
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            $sql .= " ORDER BY Posto_idPosto DESC, nomeGuerra";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            // Não há parâmetros dinâmicos a serem vinculados neste caso específico
            $stmt->execute();
            $result = $stmt->get_result();
            $lista = [];
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Pessoa($objectArray);
            }
            $c->close();
            return !empty($lista) ? $lista : null;
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
            $sql = "SELECT * FROM Pessoa WHERE idPessoa = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
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

    public function getByIdentidadeMilitar($id) {
        if (empty($id)) {
            return null;
        }
        try {
            $c = connect();
            $sql = "SELECT * FROM Pessoa WHERE identidadeMilitar = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
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
            // Monta dinamicamente os placeholders e os valores para bind_param
            $placeholders = [];
            $params = [];
            for ($i = 0; $i < 10; $i++) {
                $placeholders[] = "preccp = ?";
                $placeholders[] = "preccp = ?";
                $params[] = $preccp . "-0$i";
                $params[] = $preccp . "0$i";
            }
            $sql = "SELECT * FROM Beneficiario WHERE (" . implode(" OR ", $placeholders) . ") AND status = 1";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            // Constrói os tipos (todos são strings)
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
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
            $sql = "SELECT * FROM Pessoa WHERE identidadeMilitar = ? AND dataExpiracao >= CURRENT_DATE";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
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

    public function expireAll() {
        $dataExpiracao = date('Y') . "-01-01"; // Define a data de expiração como 1º de janeiro do ano atual

        try {
            $c = connect();
            $sql = "UPDATE Pessoa SET dataExpiracao = ?";
            $stmt = $c->prepare($sql);

            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $stmt->bind_param("s", $dataExpiracao);
            $sqlOk = $stmt->execute();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function hasVeiculo($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Veiculo "
                    . " WHERE Pessoa_idPessoa = $id";
            $result = $c->query($sql);
            $c->close();
            return $result->num_rows;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getByMesList($mes) {
        try {
            $c = connect();
            $sql = "SELECT *, DATE_FORMAT(dataNascimento, '%m-%d') AS Day
                FROM Pessoa
                WHERE dataNascimento LIKE ? AND Posto_idPosto > 1
                ORDER BY Day";

            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $likeMes = '%-' . $mes . '-%';
            $stmt->bind_param("s", $likeMes);
            $stmt->execute();
            $result = $stmt->get_result();
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
            "dataExpiracao" => $row["dataExpiracao"],
            "telefone" => $row["telefone"],
            "dataNascimento" => $row["dataNascimento"]
        );
    }
}
