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
class Visitante {

    private $id,
            $nome,
            $cpf,
            $telefone,
            $destino,
            $dataEntrada,
            $dataSaida,
            $horaEntrada,
            $horaSaida,
            $cracha,
            $foto,
            $idFoto,
            $arquivoFoto,
            $temporario;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->nome = $idOrRow["nome"];
            $this->cpf = $idOrRow["cpf"];
            $this->telefone = $idOrRow["telefone"];
            $this->destino = $idOrRow["destino"];
            $this->dataEntrada = $idOrRow["dataEntrada"];
            $this->dataSaida = $idOrRow["dataSaida"];
            $this->cracha = $idOrRow["cracha"];
            $this->foto = $idOrRow["foto"];
            $this->idFoto = $idOrRow["idFoto"];
            $this->arquivoFoto = $idOrRow["arquivoFoto"];
            $this->temporario = $idOrRow["temporario"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getDestino() {
        return $this->destino;
    }

    function getDataEntrada() {
        return $this->dataEntrada;
    }

    function getDataSaida() {
        return $this->dataSaida;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setDestino($destino) {
        $this->destino = $destino;
    }

    function setDataEntrada($dataEntrada) {
        $this->dataEntrada = $dataEntrada;
    }

    function setDataSaida($dataSaida) {
        $this->dataSaida = $dataSaida;
    }

    function getHoraEntrada() {
        return $this->horaEntrada;
    }

    function getHoraSaida() {
        return $this->horaSaida;
    }

    function setHoraEntrada($horaEntrada) {
        $this->horaEntrada = $horaEntrada;
    }

    function setHoraSaida($horaSaida) {
        $this->horaSaida = $horaSaida;
    }

    function getCracha() {
        return $this->cracha;
    }

    function setCracha($cracha) {
        $this->cracha = $cracha;
    }

    function getFoto() {
        return $this->foto;
    }

    function getIdFoto() {
        return $this->idFoto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setIdFoto($idFoto) {
        $this->idFoto = $idFoto;
    }

    function getArquivoFoto() {
        return $this->arquivoFoto;
    }

    function setArquivoFoto($arquivoFoto) {
        $this->arquivoFoto = $arquivoFoto;
    }

    public function getTemporario() {
        return $this->temporario;
    }

    public function setTemporario($temporario) {
        $this->temporario = $temporario;
    }

    function validate() {
        return $this->nome != null && !empty($this->nome);
    }

}
