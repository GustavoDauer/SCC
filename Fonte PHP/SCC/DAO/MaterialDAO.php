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
require_once '../Model/Material.php';

class MaterialDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Material (
            Classe_idClasse, item, marca, modelo, ano, motivo, local, motivoDetalhado, secaoResponsavel, Situacao_idSituacao
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $c->error);
            }
            $stmt->bind_param(
                    "issssssssi",
                    $object->getIdClasse(),
                    $object->getItem(),
                    $object->getMarca(),
                    $object->getModelo(),
                    $object->getAno(),
                    $object->getMotivo(),
                    $object->getLocal(),
                    $object->getMotivoDetalhado(),
                    $object->getSecaoResponsavel(),
                    $object->getIdSituacao()
            );
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
            $sql = "UPDATE Material SET 
            Classe_idClasse = ?, 
            item = ?, 
            marca = ?, 
            modelo = ?, 
            ano = ?, 
            motivo = ?, 
            local = ?, 
            motivoDetalhado = ?, 
            secaoResponsavel = ?, 
            Situacao_idSituacao = ? 
            WHERE idMaterial = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $stmt->bind_param(
                    "issssssssii",
                    $object->getIdClasse(),
                    $object->getItem(),
                    $object->getMarca(),
                    $object->getModelo(),
                    $object->getAno(),
                    $object->getMotivo(),
                    $object->getLocal(),
                    $object->getMotivoDetalhado(),
                    $object->getSecaoResponsavel(),
                    $object->getIdSituacao(),
                    $object->getId()
            );
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Material WHERE idMaterial = ?";
            $stmt = $c->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar query: " . $c->error);
            }
            $stmt->bind_param("i", $object->getId());
            $sqlOk = $stmt->execute();
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sqlFiltro = "";
            $sql = "SELECT * "
                    . " FROM Material "
                    . " ORDER BY Classe_idClasse, item ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Material($objectArray);
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
                    . " FROM Material "
                    . " WHERE idMaterial = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Material($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idMaterial"],
            "idClasse" => $row["Classe_idClasse"],
            "item" => $row["item"],
            "marca" => $row["marca"],
            "modelo" => $row["modelo"],
            "ano" => $row["ano"],
            "motivo" => $row["motivo"],
            "local" => $row["local"],
            "motivoDetalhado" => $row["motivoDetalhado"],
            "secaoResponsavel" => $row["secaoResponsavel"],
            "idSituacao" => $row["Situacao_idSituacao"]
        );
    }
}
