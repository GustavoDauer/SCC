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
class Material {

    private $id,
            $idClasse,
            $item,
            $marca,
            $modelo,
            $ano,
            $motivo,
            $local,
            $motivoDetalhado,
            $idSituacao,
            $secaoResponsavel;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->idClasse = $idOrRow["idClasse"];
            $this->item = $idOrRow["item"];
            $this->marca = $idOrRow["marca"];
            $this->modelo = $idOrRow["modelo"];
            $this->ano = $idOrRow["ano"];
            $this->motivo = $idOrRow["motivo"];
            $this->local = $idOrRow["local"];
            $this->motivoDetalhado = $idOrRow["motivoDetalhado"];
            $this->idSituacao = $idOrRow["idSituacao"];
            $this->secaoResponsavel = $idOrRow["secaoResponsavel"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getIdClasse() {
        return $this->idClasse;
    }

    function getItem() {
        return $this->item;
    }

    function getMarca() {
        return $this->marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getAno() {
        return $this->ano;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getLocal() {
        return $this->local;
    }

    function getMotivoDetalhado() {
        return $this->motivoDetalhado;
    }

    function getIdSituacao() {
        return $this->idSituacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdClasse($idClasse) {
        $this->idClasse = $idClasse;
    }

    function setItem($item) {
        $this->item = $item;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    function setLocal($local) {
        $this->local = $local;
    }

    function setMotivoDetalhado($motivoDetalhado) {
        $this->motivoDetalhado = $motivoDetalhado;
    }

    function setIdSituacao($idSituacao) {
        $this->idSituacao = $idSituacao;
    }

    function getSecaoResponsavel() {
        return $this->secaoResponsavel;
    }

    function setSecaoResponsavel($secaoResponsavel) {
        $this->secaoResponsavel = $secaoResponsavel;
    }

    function validate() {
        return $this->item != null;
    }

}
