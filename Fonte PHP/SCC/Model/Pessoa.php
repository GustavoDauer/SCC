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
class Pessoa {

    private $id,
            $nome,
            $nomeGuerra,
            $idPosto,
            $cpf,
            $identidadeMilitar,
            $preccp,
            $foto,
            $idVinculo,
            $dataCadastro,
            $idFoto,
            $arquivoFoto,
            $arquivoExtensao,
            $dataExpiracao,
            $telefone,
            $dataNascimento;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->nome = $idOrRow["nome"];
            $this->nomeGuerra = $idOrRow["nomeGuerra"];
            $this->idPosto = $idOrRow["idPosto"];
            $this->cpf = $idOrRow["cpf"];
            $this->identidadeMilitar = $idOrRow["identidadeMilitar"];
            $this->preccp = $idOrRow["preccp"];
            $this->foto = $idOrRow["foto"];
            $this->idVinculo = $idOrRow["idVinculo"];
            $this->dataCadastro = $idOrRow["dataCadastro"];
            $this->dataExpiracao = $idOrRow["dataExpiracao"];
            $this->telefone = $idOrRow["telefone"];
            $this->dataNascimento = $idOrRow["dataNascimento"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getNomeGuerra() {
        return $this->nomeGuerra;
    }

    public function getIdPosto() {
        return $this->idPosto;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getIdentidadeMilitar() {
        return $this->identidadeMilitar;
    }

    public function getPreccp() {
        return $this->preccp;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getIdVinculo() {
        return $this->idVinculo;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setNomeGuerra($nomeGuerra) {
        $this->nomeGuerra = $nomeGuerra;
    }

    public function setIdPosto($idPosto) {
        $this->idPosto = $idPosto;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setIdentidadeMilitar($identidadeMilitar) {
        $this->identidadeMilitar = $identidadeMilitar;
    }

    public function setPreccp($preccp) {
        $this->preccp = $preccp;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setIdVinculo($idVinculo) {
        $this->idVinculo = $idVinculo;
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    public function getIdFoto() {
        return $this->idFoto;
    }

    public function getArquivoFoto() {
        return $this->arquivoFoto;
    }

    public function setIdFoto($idFoto) {
        $this->idFoto = $idFoto;
    }

    public function setArquivoFoto($arquivoFoto) {
        $this->arquivoFoto = $arquivoFoto;
    }

    public function validate() {
        return $this->nome != null && !empty($this->nome);
    }

    public function getDataExpiracao() {
        return $this->dataExpiracao;
    }

    public function setDataExpiracao($dataExpiracao) {
        $this->dataExpiracao = $dataExpiracao;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getArquivoExtensao() {
        return $this->arquivoExtensao;
    }

    public function setArquivoExtensao($arquivoExtensao) {
        $this->arquivoExtensao = $arquivoExtensao;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function getUploadedPhoto() {
        try {
            if (file_exists("../include/fotos/" . $this->getFoto())) {
                return "../include/fotos/" . $this->getFoto();
            } else if (file_exists("../include/fotos/" . $this->getFoto() . "jpg")) {
                return "../include/fotos/" . $this->getFoto() . "jpg";
            } else if (file_exists("../include/fotos/" . $this->getFoto() . ".png")) {
                return "../include/fotos/" . $this->getFoto() . "png";
            }
            return "../include/imagens/semfoto.jpg";
        } catch (Exception $e) {
            throw($e);
        }
    }
}
