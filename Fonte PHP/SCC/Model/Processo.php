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
class Processo {

    private $id,
            $portaria,
            $responsavel,
            $dataInicio,
            $dataFim,
            $dataInicioOriginal,
            $dataFimOriginal,
            $solucao,
            $tipo,
            $assunto,
            $prorrogacao,
            $prorrogacaoPrazo,
            $prorrogacaoPrazoOriginal,
            $dataPrazo,
            $dataPrazoOriginal;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->portaria = $idOrRow["portaria"];
            $this->responsavel = $idOrRow["responsavel"];
            $this->dataInicio = $idOrRow["dataInicio"];
            $this->dataFim = $idOrRow["dataFim"];
            $this->dataInicioOriginal = $idOrRow["dataInicioOriginal"];
            $this->dataFimOriginal = $idOrRow["dataFimOriginal"];
            $this->solucao = $idOrRow["solucao"];
            $this->tipo = $idOrRow["tipo"];
            $this->assunto = $idOrRow["assunto"];
            $this->prorrogacao = $idOrRow["prorrogacao"];
            $this->prorrogacaoPrazo = $idOrRow["prorrogacaoPrazo"];
            $this->prorrogacaoPrazoOriginal = $idOrRow["prorrogacaoPrazoOriginal"];
            $this->dataPrazo = $idOrRow["dataPrazo"];
            $this->dataPrazoOriginal = $idOrRow["dataPrazoOriginal"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getPortaria() {
        return $this->portaria;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDataFim() {
        return $this->dataFim;
    }

    function getSolucao() {
        return $this->solucao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPortaria($portaria) {
        $this->portaria = $portaria;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    function setSolucao($solucao) {
        $this->solucao = $solucao;
    }

    function getDataInicioOriginal() {
        return $this->dataInicioOriginal;
    }

    function getDataFimOriginal() {
        return $this->dataFimOriginal;
    }

    function setDataInicioOriginal($dataInicioOriginal) {
        $this->dataInicioOriginal = $dataInicioOriginal;
    }

    function setDataFimOriginal($dataFimOriginal) {
        $this->dataFimOriginal = $dataFimOriginal;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getAssunto() {
        return $this->assunto;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setAssunto($assunto) {
        $this->assunto = $assunto;
    }

    function getProrrogacao() {
        return $this->prorrogacao;
    }

    function getProrrogacaoPrazo() {
        return $this->prorrogacaoPrazo;
    }

    function getProrrogacaoPrazoOriginal() {
        return $this->prorrogacaoPrazoOriginal;
    }

    function setProrrogacao($prorrogacao) {
        $this->prorrogacao = $prorrogacao;
    }

    function setProrrogacaoPrazo($prorrogacaoPrazo) {
        $this->prorrogacaoPrazo = $prorrogacaoPrazo;
    }

    function setProrrogacaoPrazoOriginal($prorrogacaoPrazoOriginal) {
        $this->prorrogacaoPrazoOriginal = $prorrogacaoPrazoOriginal;
    }

    function getDataPrazo() {
        return $this->dataPrazo;
    }

    function getDataPrazoOriginal() {
        return $this->dataPrazoOriginal;
    }

    function setDataPrazo($dataPrazo) {
        $this->dataPrazo = $dataPrazo;
    }

    function setDataPrazoOriginal($dataPrazoOriginal) {
        $this->dataPrazoOriginal = $dataPrazoOriginal;
    }

    function validate() {
        return $this->portaria != null;
    }

}
