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
class Combustivel {

    private $ctc01celula1,
            $ctc01celula2,
            $ctc01celula3,
            $ctc01celula1valor,
            $ctc01celula2valor,
            $ctc01celula3valor,
            $ctc04celula1,
            $ctc04celula2,
            $ctc04celula3,
            $ctc04celula1valor,
            $ctc04celula2valor,
            $ctc04celula3valor,
            $diesel,
            $gasolina;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->ctc01celula1 = $idOrRow["ctc01celula1"];
            $this->ctc01celula2 = $idOrRow["ctc01celula2"];
            $this->ctc01celula3 = $idOrRow["ctc01celula3"];
            $this->ctc01celula1valor = $idOrRow["ctc01celula1valor"];
            $this->ctc01celula2valor = $idOrRow["ctc01celula2valor"];
            $this->ctc01celula3valor = $idOrRow["ctc01celula3valor"];
            $this->ctc04celula1 = $idOrRow["ctc04celula1"];
            $this->ctc04celula2 = $idOrRow["ctc04celula2"];
            $this->ctc04celula3 = $idOrRow["ctc04celula3"];
            $this->ctc04celula1valor = $idOrRow["ctc04celula1valor"];
            $this->ctc04celula2valor = $idOrRow["ctc04celula2valor"];
            $this->ctc04celula3valor = $idOrRow["ctc04celula3valor"];
            $this->diesel = $idOrRow["diesel"];
            $this->gasolina = $idOrRow["gasolina"];
        }
    }

    function getCtc01celula1() {
        return $this->ctc01celula1;
    }

    function getCtc01celula2() {
        return $this->ctc01celula2;
    }

    function getCtc01celula3() {
        return $this->ctc01celula3;
    }

    function getCtc01celula1valor() {
        return $this->ctc01celula1valor;
    }

    function getCtc01celula2valor() {
        return $this->ctc01celula2valor;
    }

    function getCtc01celula3valor() {
        return $this->ctc01celula3valor;
    }

    function getCtc04celula1() {
        return $this->ctc04celula1;
    }

    function getCtc04celula2() {
        return $this->ctc04celula2;
    }

    function getCtc04celula3() {
        return $this->ctc04celula3;
    }

    function getCtc04celula1valor() {
        return $this->ctc04celula1valor;
    }

    function getCtc04celula2valor() {
        return $this->ctc04celula2valor;
    }

    function getCtc04celula3valor() {
        return $this->ctc04celula3valor;
    }

    function getDiesel() {
        return $this->diesel;
    }

    function getGasolina() {
        return $this->gasolina;
    }

    function setCtc01celula1($ctc01celula1) {
        $this->ctc01celula1 = $ctc01celula1;
    }

    function setCtc01celula2($ctc01celula2) {
        $this->ctc01celula2 = $ctc01celula2;
    }

    function setCtc01celula3($ctc01celula3) {
        $this->ctc01celula3 = $ctc01celula3;
    }

    function setCtc01celula1valor($ctc01celula1valor) {
        $this->ctc01celula1valor = $ctc01celula1valor;
    }

    function setCtc01celula2valor($ctc01celula2valor) {
        $this->ctc01celula2valor = $ctc01celula2valor;
    }

    function setCtc01celula3valor($ctc01celula3valor) {
        $this->ctc01celula3valor = $ctc01celula3valor;
    }

    function setCtc04celula1($ctc04celula1) {
        $this->ctc04celula1 = $ctc04celula1;
    }

    function setCtc04celula2($ctc04celula2) {
        $this->ctc04celula2 = $ctc04celula2;
    }

    function setCtc04celula3($ctc04celula3) {
        $this->ctc04celula3 = $ctc04celula3;
    }

    function setCtc04celula1valor($ctc04celula1valor) {
        $this->ctc04celula1valor = $ctc04celula1valor;
    }

    function setCtc04celula2valor($ctc04celula2valor) {
        $this->ctc04celula2valor = $ctc04celula2valor;
    }

    function setCtc04celula3valor($ctc04celula3valor) {
        $this->ctc04celula3valor = $ctc04celula3valor;
    }

    function setDiesel($diesel) {
        $this->diesel = $diesel;
    }

    function setGasolina($gasolina) {
        $this->gasolina = $gasolina;
    }

    function validate() {
        return $this->ctc01celula1valor != null;
    }

}
