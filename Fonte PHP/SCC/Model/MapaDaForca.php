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
class MapaDaForca {

    private $cel_previsto,
            $tc_previsto,
            $maj_previsto,
            $cap_previsto,
            $ten1_previsto,
            $ten2_previsto,
            $aspof_previsto,
            $sten_previsto,
            $sgt1_previsto,
            $sgt2_previsto,
            $sgt3_previsto,
            $cb_previsto,
            $cbev_previsto,
            $sdep_previsto,
            $sdev_previsto,
            $cel_existente,
            $tc_existente,
            $maj_existente,
            $cap_existente,
            $ten1_existente,
            $ten2_existente,
            $aspof_existente,
            $sten_existente,
            $sgt1_existente,
            $sgt2_existente,
            $sgt3_existente,
            $cb_existente,
            $cbev_existente,
            $sdep_existente,
            $sdev_existente,
            $cel_adido,
            $tc_adido,
            $maj_adido,
            $cap_adido,
            $ten1_adido,
            $ten2_adido,
            $aspof_adido,
            $sten_adido,
            $sgt1_adido,
            $sgt2_adido,
            $sgt3_adido,
            $cb_adido,
            $cbev_adido,
            $sdep_adido,
            $sdev_adido,
            $cel_adidoTexto,
            $tc_adidoTexto,
            $maj_adidoTexto,
            $cap_adidoTexto,
            $ten1_adidoTexto,
            $ten2_adidoTexto,
            $aspof_adidoTexto,
            $sten_adidoTexto,
            $sgt1_adidoTexto,
            $sgt2_adidoTexto,
            $sgt3_adidoTexto,
            $cb_adidoTexto,
            $cbev_adidoTexto,
            $sdep_adidoTexto,
            $sdev_adidoTexto,
            $cap_pttc_previsto,
            $ten1_pttc_previsto,
            $ten2_pttc_previsto,
            $sten_pttc_previsto,
            $sgt1_pttc_previsto,
            $sgt2_pttc_previsto,
            $cap_pttc_existente,
            $ten1_pttc_existente,
            $ten2_pttc_existente,
            $sten_pttc_existente,
            $sgt1_pttc_existente,
            $sgt2_pttc_existente,
            $cap_pttc_adido,
            $ten1_pttc_adido,
            $ten2_pttc_adido,
            $sten_pttc_adido,
            $sgt1_pttc_adido,
            $sgt2_pttc_adido,
            $cap_pttc_adidoTexto,
            $ten1_pttc_adidoTexto,
            $ten2_pttc_adidoTexto,
            $sten_pttc_adidoTexto,
            $sgt1_pttc_adidoTexto,
            $sgt2_pttc_adidoTexto,
            $encostados,
            $agregados;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            
        } else if (is_array($idOrRow)) {
            $this->cel_previsto = $idOrRow["cel_previsto"];
            $this->tc_previsto = $idOrRow["tc_previsto"];
            $this->maj_previsto = $idOrRow["maj_previsto"];
            $this->cap_previsto = $idOrRow["cap_previsto"];
            $this->ten1_previsto = $idOrRow["ten1_previsto"];
            $this->ten2_previsto = $idOrRow["ten2_previsto"];
            $this->aspof_previsto = $idOrRow["aspof_previsto"];
            $this->sten_previsto = $idOrRow["sten_previsto"];
            $this->sgt1_previsto = $idOrRow["sgt1_previsto"];
            $this->sgt2_previsto = $idOrRow["sgt2_previsto"];
            $this->sgt3_previsto = $idOrRow["sgt3_previsto"];
            $this->cb_previsto = $idOrRow["cb_previsto"];
            $this->cbev_previsto = $idOrRow["cbev_previsto"];
            $this->sdep_previsto = $idOrRow["sdep_previsto"];
            $this->sdev_previsto = $idOrRow["sdev_previsto"];
            $this->cel_existente = $idOrRow["cel_existente"];
            $this->tc_existente = $idOrRow["tc_existente"];
            $this->maj_existente = $idOrRow["maj_existente"];
            $this->cap_existente = $idOrRow["cap_existente"];
            $this->ten1_existente = $idOrRow["ten1_existente"];
            $this->ten2_existente = $idOrRow["ten2_existente"];
            $this->aspof_existente = $idOrRow["aspof_existente"];
            $this->sten_existente = $idOrRow["sten_existente"];
            $this->sgt1_existente = $idOrRow["sgt1_existente"];
            $this->sgt2_existente = $idOrRow["sgt2_existente"];
            $this->sgt3_existente = $idOrRow["sgt3_existente"];
            $this->cb_existente = $idOrRow["cb_existente"];
            $this->cbev_existente = $idOrRow["cbev_existente"];
            $this->sdep_existente = $idOrRow["sdep_existente"];
            $this->sdev_existente = $idOrRow["sdev_existente"];
            $this->cel_adido = $idOrRow["cel_adido"];
            $this->tc_adido = $idOrRow["tc_adido"];
            $this->maj_adido = $idOrRow["maj_adido"];
            $this->cap_adido = $idOrRow["cap_adido"];
            $this->ten1_adido = $idOrRow["ten1_adido"];
            $this->ten2_adido = $idOrRow["ten2_adido"];
            $this->aspof_adido = $idOrRow["aspof_adido"];
            $this->sten_adido = $idOrRow["sten_adido"];
            $this->sgt1_adido = $idOrRow["sgt1_adido"];
            $this->sgt2_adido = $idOrRow["sgt2_adido"];
            $this->sgt3_adido = $idOrRow["sgt3_adido"];
            $this->cb_adido = $idOrRow["cb_adido"];
            $this->cbev_adido = $idOrRow["cbev_adido"];
            $this->sdep_adido = $idOrRow["sdep_adido"];
            $this->sdev_adido = $idOrRow["sdev_adido"];
            $this->cel_adidoTexto = $idOrRow["cel_adidoTexto"];
            $this->tc_adidoTexto = $idOrRow["tc_adidoTexto"];
            $this->maj_adidoTexto = $idOrRow["maj_adidoTexto"];
            $this->cap_adidoTexto = $idOrRow["cap_adidoTexto"];
            $this->ten1_adidoTexto = $idOrRow["ten1_adidoTexto"];
            $this->ten2_adidoTexto = $idOrRow["ten2_adidoTexto"];
            $this->aspof_adidoTexto = $idOrRow["aspof_adidoTexto"];
            $this->sten_adidoTexto = $idOrRow["sten_adidoTexto"];
            $this->sgt1_adidoTexto = $idOrRow["sgt1_adidoTexto"];
            $this->sgt2_adidoTexto = $idOrRow["sgt2_adidoTexto"];
            $this->sgt3_adidoTexto = $idOrRow["sgt3_adidoTexto"];
            $this->cb_adidoTexto = $idOrRow["cb_adidoTexto"];
            $this->cbev_adidoTexto = $idOrRow["cbev_adidoTexto"];
            $this->sdep_adidoTexto = $idOrRow["sdep_adidoTexto"];
            $this->sdev_adidoTexto = $idOrRow["sdev_adidoTexto"];
            $this->cap_pttc_previsto = $idOrRow["cap_pttc_previsto"];
            $this->ten1_pttc_previsto = $idOrRow["ten1_pttc_previsto"];
            $this->ten2_pttc_previsto = $idOrRow["ten2_pttc_previsto"];
            $this->sten_pttc_previsto = $idOrRow["sten_pttc_previsto"];
            $this->sgt1_pttc_previsto = $idOrRow["sgt1_pttc_previsto"];
            $this->sgt2_pttc_previsto = $idOrRow["sgt2_pttc_previsto"];
            $this->cap_pttc_existente = $idOrRow["cap_pttc_existente"];
            $this->ten1_pttc_existente = $idOrRow["ten1_pttc_existente"];
            $this->ten2_pttc_existente = $idOrRow["ten2_pttc_existente"];
            $this->sten_pttc_existente = $idOrRow["sten_pttc_existente"];
            $this->sgt1_pttc_existente = $idOrRow["sgt1_pttc_existente"];
            $this->sgt2_pttc_existente = $idOrRow["sgt2_pttc_existente"];
            $this->cap_pttc_adido = $idOrRow["cap_pttc_adido"];
            $this->ten1_pttc_adido = $idOrRow["ten1_pttc_adido"];
            $this->ten2_pttc_adido = $idOrRow["ten2_pttc_adido"];
            $this->sten_pttc_adido = $idOrRow["sten_pttc_adido"];
            $this->sgt1_pttc_adido = $idOrRow["sgt1_pttc_adido"];
            $this->sgt2_pttc_adido = $idOrRow["sgt2_pttc_adido"];
            $this->cap_pttc_adidoTexto = $idOrRow["cap_pttc_adidoTexto"];
            $this->ten1_pttc_adidoTexto = $idOrRow["ten1_pttc_adidoTexto"];
            $this->ten2_pttc_adidoTexto = $idOrRow["ten2_pttc_adidoTexto"];
            $this->sten_pttc_adidoTexto = $idOrRow["sten_pttc_adidoTexto"];
            $this->sgt1_pttc_adidoTexto = $idOrRow["sgt1_pttc_adidoTexto"];
            $this->sgt2_pttc_adidoTexto = $idOrRow["sgt2_pttc_adidoTexto"];
            $this->encostados = $idOrRow["encostados"];
            $this->agregados = $idOrRow["agregados"];
        }
    }

    function getCel_previsto() {
        return $this->cel_previsto;
    }

    function getTc_previsto() {
        return $this->tc_previsto;
    }

    function getMaj_previsto() {
        return $this->maj_previsto;
    }

    function getCap_previsto() {
        return $this->cap_previsto;
    }

    function getTen1_previsto() {
        return $this->ten1_previsto;
    }

    function getTen2_previsto() {
        return $this->ten2_previsto;
    }

    function getAspof_previsto() {
        return $this->aspof_previsto;
    }

    function getSten_previsto() {
        return $this->sten_previsto;
    }

    function getSgt1_previsto() {
        return $this->sgt1_previsto;
    }

    function getSgt2_previsto() {
        return $this->sgt2_previsto;
    }

    function getSgt3_previsto() {
        return $this->sgt3_previsto;
    }

    function getCb_previsto() {
        return $this->cb_previsto;
    }

    function getCbev_previsto() {
        return $this->cbev_previsto;
    }

    function getSdep_previsto() {
        return $this->sdep_previsto;
    }

    function getSdev_previsto() {
        return $this->sdev_previsto;
    }

    function getCel_existente() {
        return $this->cel_existente;
    }

    function getTc_existente() {
        return $this->tc_existente;
    }

    function getMaj_existente() {
        return $this->maj_existente;
    }

    function getCap_existente() {
        return $this->cap_existente;
    }

    function getTen1_existente() {
        return $this->ten1_existente;
    }

    function getTen2_existente() {
        return $this->ten2_existente;
    }

    function getAspof_existente() {
        return $this->aspof_existente;
    }

    function getSten_existente() {
        return $this->sten_existente;
    }

    function getSgt1_existente() {
        return $this->sgt1_existente;
    }

    function getSgt2_existente() {
        return $this->sgt2_existente;
    }

    function getSgt3_existente() {
        return $this->sgt3_existente;
    }

    function getCb_existente() {
        return $this->cb_existente;
    }

    function getCbev_existente() {
        return $this->cbev_existente;
    }

    function getSdep_existente() {
        return $this->sdep_existente;
    }

    function getSdev_existente() {
        return $this->sdev_existente;
    }

    function getCel_adido() {
        return $this->cel_adido;
    }

    function getTc_adido() {
        return $this->tc_adido;
    }

    function getMaj_adido() {
        return $this->maj_adido;
    }

    function getCap_adido() {
        return $this->cap_adido;
    }

    function getTen1_adido() {
        return $this->ten1_adido;
    }

    function getTen2_adido() {
        return $this->ten2_adido;
    }

    function getAspof_adido() {
        return $this->aspof_adido;
    }

    function getSten_adido() {
        return $this->sten_adido;
    }

    function getSgt1_adido() {
        return $this->sgt1_adido;
    }

    function getSgt2_adido() {
        return $this->sgt2_adido;
    }

    function getSgt3_adido() {
        return $this->sgt3_adido;
    }

    function getCb_adido() {
        return $this->cb_adido;
    }

    function getCbev_adido() {
        return $this->cbev_adido;
    }

    function getSdep_adido() {
        return $this->sdep_adido;
    }

    function getSdev_adido() {
        return $this->sdev_adido;
    }

    function getCel_adidoTexto() {
        return $this->cel_adidoTexto;
    }

    function getTc_adidoTexto() {
        return $this->tc_adidoTexto;
    }

    function getMaj_adidoTexto() {
        return $this->maj_adidoTexto;
    }

    function getCap_adidoTexto() {
        return $this->cap_adidoTexto;
    }

    function getTen1_adidoTexto() {
        return $this->ten1_adidoTexto;
    }

    function getTen2_adidoTexto() {
        return $this->ten2_adidoTexto;
    }

    function getAspof_adidoTexto() {
        return $this->aspof_adidoTexto;
    }

    function getSten_adidoTexto() {
        return $this->sten_adidoTexto;
    }

    function getSgt1_adidoTexto() {
        return $this->sgt1_adidoTexto;
    }

    function getSgt2_adidoTexto() {
        return $this->sgt2_adidoTexto;
    }

    function getSgt3_adidoTexto() {
        return $this->sgt3_adidoTexto;
    }

    function getCb_adidoTexto() {
        return $this->cb_adidoTexto;
    }

    function getCbev_adidoTexto() {
        return $this->cbev_adidoTexto;
    }

    function getSdep_adidoTexto() {
        return $this->sdep_adidoTexto;
    }

    function getSdev_adidoTexto() {
        return $this->sdev_adidoTexto;
    }

    function getCap_pttc_previsto() {
        return $this->cap_pttc_previsto;
    }

    function getTen1_pttc_previsto() {
        return $this->ten1_pttc_previsto;
    }

    function getTen2_pttc_previsto() {
        return $this->ten2_pttc_previsto;
    }

    function getSten_pttc_previsto() {
        return $this->sten_pttc_previsto;
    }

    function getSgt1_pttc_previsto() {
        return $this->sgt1_pttc_previsto;
    }

    function getSgt2_pttc_previsto() {
        return $this->sgt2_pttc_previsto;
    }

    function getCap_pttc_existente() {
        return $this->cap_pttc_existente;
    }

    function getTen1_pttc_existente() {
        return $this->ten1_pttc_existente;
    }

    function getTen2_pttc_existente() {
        return $this->ten2_pttc_existente;
    }

    function getSten_pttc_existente() {
        return $this->sten_pttc_existente;
    }

    function getSgt1_pttc_existente() {
        return $this->sgt1_pttc_existente;
    }

    function getSgt2_pttc_existente() {
        return $this->sgt2_pttc_existente;
    }

    function getCap_pttc_adido() {
        return $this->cap_pttc_adido;
    }

    function getTen1_pttc_adido() {
        return $this->ten1_pttc_adido;
    }

    function getTen2_pttc_adido() {
        return $this->ten2_pttc_adido;
    }

    function getSten_pttc_adido() {
        return $this->sten_pttc_adido;
    }

    function getSgt1_pttc_adido() {
        return $this->sgt1_pttc_adido;
    }

    function getSgt2_pttc_adido() {
        return $this->sgt2_pttc_adido;
    }

    function getCap_pttc_adidoTexto() {
        return $this->cap_pttc_adidoTexto;
    }

    function getTen1_pttc_adidoTexto() {
        return $this->ten1_pttc_adidoTexto;
    }

    function getTen2_pttc_adidoTexto() {
        return $this->ten2_pttc_adidoTexto;
    }

    function getSten_pttc_adidoTexto() {
        return $this->sten_pttc_adidoTexto;
    }

    function getSgt1_pttc_adidoTexto() {
        return $this->sgt1_pttc_adidoTexto;
    }

    function getSgt2_pttc_adidoTexto() {
        return $this->sgt2_pttc_adidoTexto;
    }

    function getEncostados() {
        return $this->encostados;
    }

    function getAgregados() {
        return $this->agregados;
    }

    function setCel_previsto($cel_previsto) {
        $this->cel_previsto = $cel_previsto;
    }

    function setTc_previsto($tc_previsto) {
        $this->tc_previsto = $tc_previsto;
    }

    function setMaj_previsto($maj_previsto) {
        $this->maj_previsto = $maj_previsto;
    }

    function setCap_previsto($cap_previsto) {
        $this->cap_previsto = $cap_previsto;
    }

    function setTen1_previsto($ten1_previsto) {
        $this->ten1_previsto = $ten1_previsto;
    }

    function setTen2_previsto($ten2_previsto) {
        $this->ten2_previsto = $ten2_previsto;
    }

    function setAspof_previsto($aspof_previsto) {
        $this->aspof_previsto = $aspof_previsto;
    }

    function setSten_previsto($sten_previsto) {
        $this->sten_previsto = $sten_previsto;
    }

    function setSgt1_previsto($sgt1_previsto) {
        $this->sgt1_previsto = $sgt1_previsto;
    }

    function setSgt2_previsto($sgt2_previsto) {
        $this->sgt2_previsto = $sgt2_previsto;
    }

    function setSgt3_previsto($sgt3_previsto) {
        $this->sgt3_previsto = $sgt3_previsto;
    }

    function setCb_previsto($cb_previsto) {
        $this->cb_previsto = $cb_previsto;
    }

    function setCbev_previsto($cbev_previsto) {
        $this->cbev_previsto = $cbev_previsto;
    }

    function setSdep_previsto($sdep_previsto) {
        $this->sdep_previsto = $sdep_previsto;
    }

    function setSdev_previsto($sdev_previsto) {
        $this->sdev_previsto = $sdev_previsto;
    }

    function setCel_existente($cel_existente) {
        $this->cel_existente = $cel_existente;
    }

    function setTc_existente($tc_existente) {
        $this->tc_existente = $tc_existente;
    }

    function setMaj_existente($maj_existente) {
        $this->maj_existente = $maj_existente;
    }

    function setCap_existente($cap_existente) {
        $this->cap_existente = $cap_existente;
    }

    function setTen1_existente($ten1_existente) {
        $this->ten1_existente = $ten1_existente;
    }

    function setTen2_existente($ten2_existente) {
        $this->ten2_existente = $ten2_existente;
    }

    function setAspof_existente($aspof_existente) {
        $this->aspof_existente = $aspof_existente;
    }

    function setSten_existente($sten_existente) {
        $this->sten_existente = $sten_existente;
    }

    function setSgt1_existente($sgt1_existente) {
        $this->sgt1_existente = $sgt1_existente;
    }

    function setSgt2_existente($sgt2_existente) {
        $this->sgt2_existente = $sgt2_existente;
    }

    function setSgt3_existente($sgt3_existente) {
        $this->sgt3_existente = $sgt3_existente;
    }

    function setCb_existente($cb_existente) {
        $this->cb_existente = $cb_existente;
    }

    function setCbev_existente($cbev_existente) {
        $this->cbev_existente = $cbev_existente;
    }

    function setSdep_existente($sdep_existente) {
        $this->sdep_existente = $sdep_existente;
    }

    function setSdev_existente($sdev_existente) {
        $this->sdev_existente = $sdev_existente;
    }

    function setCel_adido($cel_adido) {
        $this->cel_adido = $cel_adido;
    }

    function setTc_adido($tc_adido) {
        $this->tc_adido = $tc_adido;
    }

    function setMaj_adido($maj_adido) {
        $this->maj_adido = $maj_adido;
    }

    function setCap_adido($cap_adido) {
        $this->cap_adido = $cap_adido;
    }

    function setTen1_adido($ten1_adido) {
        $this->ten1_adido = $ten1_adido;
    }

    function setTen2_adido($ten2_adido) {
        $this->ten2_adido = $ten2_adido;
    }

    function setAspof_adido($aspof_adido) {
        $this->aspof_adido = $aspof_adido;
    }

    function setSten_adido($sten_adido) {
        $this->sten_adido = $sten_adido;
    }

    function setSgt1_adido($sgt1_adido) {
        $this->sgt1_adido = $sgt1_adido;
    }

    function setSgt2_adido($sgt2_adido) {
        $this->sgt2_adido = $sgt2_adido;
    }

    function setSgt3_adido($sgt3_adido) {
        $this->sgt3_adido = $sgt3_adido;
    }

    function setCb_adido($cb_adido) {
        $this->cb_adido = $cb_adido;
    }

    function setCbev_adido($cbev_adido) {
        $this->cbev_adido = $cbev_adido;
    }

    function setSdep_adido($sdep_adido) {
        $this->sdep_adido = $sdep_adido;
    }

    function setSdev_adido($sdev_adido) {
        $this->sdev_adido = $sdev_adido;
    }

    function setCel_adidoTexto($cel_adidoTexto) {
        $this->cel_adidoTexto = $cel_adidoTexto;
    }

    function setTc_adidoTexto($tc_adidoTexto) {
        $this->tc_adidoTexto = $tc_adidoTexto;
    }

    function setMaj_adidoTexto($maj_adidoTexto) {
        $this->maj_adidoTexto = $maj_adidoTexto;
    }

    function setCap_adidoTexto($cap_adidoTexto) {
        $this->cap_adidoTexto = $cap_adidoTexto;
    }

    function setTen1_adidoTexto($ten1_adidoTexto) {
        $this->ten1_adidoTexto = $ten1_adidoTexto;
    }

    function setTen2_adidoTexto($ten2_adidoTexto) {
        $this->ten2_adidoTexto = $ten2_adidoTexto;
    }

    function setAspof_adidoTexto($aspof_adidoTexto) {
        $this->aspof_adidoTexto = $aspof_adidoTexto;
    }

    function setSten_adidoTexto($sten_adidoTexto) {
        $this->sten_adidoTexto = $sten_adidoTexto;
    }

    function setSgt1_adidoTexto($sgt1_adidoTexto) {
        $this->sgt1_adidoTexto = $sgt1_adidoTexto;
    }

    function setSgt2_adidoTexto($sgt2_adidoTexto) {
        $this->sgt2_adidoTexto = $sgt2_adidoTexto;
    }

    function setSgt3_adidoTexto($sgt3_adidoTexto) {
        $this->sgt3_adidoTexto = $sgt3_adidoTexto;
    }

    function setCb_adidoTexto($cb_adidoTexto) {
        $this->cb_adidoTexto = $cb_adidoTexto;
    }

    function setCbev_adidoTexto($cbev_adidoTexto) {
        $this->cbev_adidoTexto = $cbev_adidoTexto;
    }

    function setSdep_adidoTexto($sdep_adidoTexto) {
        $this->sdep_adidoTexto = $sdep_adidoTexto;
    }

    function setSdev_adidoTexto($sdev_adidoTexto) {
        $this->sdev_adidoTexto = $sdev_adidoTexto;
    }

    function setCap_pttc_previsto($cap_pttc_previsto) {
        $this->cap_pttc_previsto = $cap_pttc_previsto;
    }

    function setTen1_pttc_previsto($ten1_pttc_previsto) {
        $this->ten1_pttc_previsto = $ten1_pttc_previsto;
    }

    function setTen2_pttc_previsto($ten2_pttc_previsto) {
        $this->ten2_pttc_previsto = $ten2_pttc_previsto;
    }

    function setSten_pttc_previsto($sten_pttc_previsto) {
        $this->sten_pttc_previsto = $sten_pttc_previsto;
    }

    function setSgt1_pttc_previsto($sgt1_pttc_previsto) {
        $this->sgt1_pttc_previsto = $sgt1_pttc_previsto;
    }

    function setSgt2_pttc_previsto($sgt2_pttc_previsto) {
        $this->sgt2_pttc_previsto = $sgt2_pttc_previsto;
    }

    function setCap_pttc_existente($cap_pttc_existente) {
        $this->cap_pttc_existente = $cap_pttc_existente;
    }

    function setTen1_pttc_existente($ten1_pttc_existente) {
        $this->ten1_pttc_existente = $ten1_pttc_existente;
    }

    function setTen2_pttc_existente($ten2_pttc_existente) {
        $this->ten2_pttc_existente = $ten2_pttc_existente;
    }

    function setSten_pttc_existente($sten_pttc_existente) {
        $this->sten_pttc_existente = $sten_pttc_existente;
    }

    function setSgt1_pttc_existente($sgt1_pttc_existente) {
        $this->sgt1_pttc_existente = $sgt1_pttc_existente;
    }

    function setSgt2_pttc_existente($sgt2_pttc_existente) {
        $this->sgt2_pttc_existente = $sgt2_pttc_existente;
    }

    function setCap_pttc_adido($cap_pttc_adido) {
        $this->cap_pttc_adido = $cap_pttc_adido;
    }

    function setTen1_pttc_adido($ten1_pttc_adido) {
        $this->ten1_pttc_adido = $ten1_pttc_adido;
    }

    function setTen2_pttc_adido($ten2_pttc_adido) {
        $this->ten2_pttc_adido = $ten2_pttc_adido;
    }

    function setSten_pttc_adido($sten_pttc_adido) {
        $this->sten_pttc_adido = $sten_pttc_adido;
    }

    function setSgt1_pttc_adido($sgt1_pttc_adido) {
        $this->sgt1_pttc_adido = $sgt1_pttc_adido;
    }

    function setSgt2_pttc_adido($sgt2_pttc_adido) {
        $this->sgt2_pttc_adido = $sgt2_pttc_adido;
    }

    function setCap_pttc_adidoTexto($cap_pttc_adidoTexto) {
        $this->cap_pttc_adidoTexto = $cap_pttc_adidoTexto;
    }

    function setTen1_pttc_adidoTexto($ten1_pttc_adidoTexto) {
        $this->ten1_pttc_adidoTexto = $ten1_pttc_adidoTexto;
    }

    function setTen2_pttc_adidoTexto($ten2_pttc_adidoTexto) {
        $this->ten2_pttc_adidoTexto = $ten2_pttc_adidoTexto;
    }

    function setSten_pttc_adidoTexto($sten_pttc_adidoTexto) {
        $this->sten_pttc_adidoTexto = $sten_pttc_adidoTexto;
    }

    function setSgt1_pttc_adidoTexto($sgt1_pttc_adidoTexto) {
        $this->sgt1_pttc_adidoTexto = $sgt1_pttc_adidoTexto;
    }

    function setSgt2_pttc_adidoTexto($sgt2_pttc_adidoTexto) {
        $this->sgt2_pttc_adidoTexto = $sgt2_pttc_adidoTexto;
    }

    function setEncostados($encostados) {
        $this->encostados = $encostados;
    }

    function setAgregados($agregados) {
        $this->agregados = $agregados;
    }

}
