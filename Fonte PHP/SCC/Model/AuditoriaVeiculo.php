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
class AuditoriaVeiculo {

    private $id,
            $idVeiculo,
            $dataEntrada,
            $dataSaida,
            $local,
            $autorizacao,
            $preccp,
            $placa,
            $nome;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->idVeiculo = $idOrRow["idVeiculo"];
            $this->dataEntrada = $idOrRow["dataEntrada"];
            $this->dataSaida = $idOrRow["dataSaida"];
            $this->local = $idOrRow["local"];
            $this->autorizacao = $idOrRow["autorizacao"];
            $this->preccp = $idOrRow["preccp"];
            $this->placa = $idOrRow["placa"];
            $this->nome = $idOrRow["nome"];
        }
    }

    public function getIdVeiculo() {
        return $this->idVeiculo;
    }

    public function getDataEntrada() {
        return $this->dataEntrada;
    }

    public function getDataSaida() {
        return $this->dataSaida;
    }

    public function getLocal() {
        return $this->local;
    }

    public function setIdVeiculo($idVeiculo) {
        $this->idVeiculo = $idVeiculo;
    }

    public function setDataEntrada($dataEntrada) {
        $this->dataEntrada = $dataEntrada;
    }

    public function setDataSaida($dataSaida) {
        $this->dataSaida = $dataSaida;
    }

    public function setLocal($local) {
        $this->local = $local;
    }

    public function getId() {
        return $this->id;
    }

    public function getAutorizacao() {
        return $this->autorizacao;
    }

    public function getPreccp() {
        return $this->preccp;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAutorizacao($autorizacao) {
        $this->autorizacao = $autorizacao;
    }

    public function setPreccp($preccp) {
        $this->preccp = $preccp;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function validate() {
        return $this->idVeiculo != null && !empty($this->idVeiculo) && $this->dataEntrada != null && !empty($this->dataEntrada);
    }
}
