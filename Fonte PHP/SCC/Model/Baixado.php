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
class Baixado {

    private $id,
            $idPosto,
            $nome,
            $cia,
            $turma, // Ano
            $diagnostico,
            $situacao,
            $bi,
            $bar,
            $dispensa,
            $amparo, // Observação
            $acao,
            $dataAtualizacao,
            $dataAtualizacaoOriginal;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->idPosto = $idOrRow["idPosto"];
            $this->nome = $idOrRow["nome"];
            $this->cia = $idOrRow["cia"];
            $this->turma = $idOrRow["turma"];
            $this->diagnostico = $idOrRow["diagnostico"];
            $this->situacao = $idOrRow["situacao"];
            $this->bi = $idOrRow["bi"];
            $this->bar = $idOrRow["bar"];
            $this->dispensa = $idOrRow["dispensa"];
            $this->amparo = $idOrRow["amparo"];
            $this->acao = $idOrRow["acao"];
            $this->dataAtualizacao = $idOrRow["dataAtualizacao"];
            $this->dataAtualizacaoOriginal = $idOrRow["dataAtualizacaoOriginal"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getIdPosto() {
        return $this->idPosto;
    }

    function getNome() {
        return $this->nome;
    }

    function getCia() {
        return $this->cia;
    }

    function getTurma() {
        return $this->turma;
    }

    function getDiagnostico() {
        return $this->diagnostico;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getBi() {
        return $this->bi;
    }

    function getBar() {
        return $this->bar;
    }

    function getDispensa() {
        return $this->dispensa;
    }

    function getAmparo() {
        return $this->amparo;
    }

    function getAcao() {
        return $this->acao;
    }

    function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    function getDataAtualizacaoOriginal() {
        return $this->dataAtualizacaoOriginal;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdPosto($idPosto) {
        $this->idPosto = $idPosto;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCia($cia) {
        $this->cia = $cia;
    }

    function setTurma($turma) {
        $this->turma = $turma;
    }

    function setDiagnostico($diagnostico) {
        $this->diagnostico = $diagnostico;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setBi($bi) {
        $this->bi = $bi;
    }

    function setBar($bar) {
        $this->bar = $bar;
    }

    function setDispensa($dispensa) {
        $this->dispensa = $dispensa;
    }

    function setAmparo($amparo) {
        $this->amparo = $amparo;
    }

    function setAcao($acao) {
        $this->acao = $acao;
    }

    function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

    function setDataAtualizacaoOriginal($dataAtualizacaoOriginal) {
        $this->dataAtualizacaoOriginal = $dataAtualizacaoOriginal;
    }

    function validate() {
        return $this->nome != null;
    }

}
