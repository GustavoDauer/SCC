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
require_once '../Model/MapaDaForca.php';

class MapaDaForcaDAO {

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE `scc`.`MapaDaForca`
            SET
            `cel_previsto` = " . $object->getCel_previsto() . ",
            `tc_previsto` = " . $object->getTc_previsto() . ",
            `maj_previsto` = " . $object->getMaj_previsto() . ",
            `cap_previsto` = " . $object->getCap_previsto() . ",
            `1ten_previsto` = " . $object->getTen1_previsto() . ",
            `2ten_previsto` = " . $object->getTen2_previsto() . ",
            `aspof_previsto` = " . $object->getAspof_previsto() . ",
            `cel_existente` = " . $object->getCel_existente() . ",
            `tc_existente` = " . $object->getTc_existente() . ",
            `maj_existente` = " . $object->getMaj_existente() . ",
            `cap_existente` = " . $object->getCap_existente() . ",
            `1ten_existente` = " . $object->getTen1_existente() . ",
            `2ten_existente` = " . $object->getTen2_existente() . ",
            `aspof_existente` = " . $object->getAspof_existente() . ",
            `sten_previsto` = " . $object->getSten_previsto() . ",
            `1sgt_previsto` = " . $object->getSgt1_previsto() . ",
            `2sgt_previsto` = " . $object->getSgt2_previsto() . ",
            `3sgt_previsto` = " . $object->getSgt3_previsto() . ",
            `cb_previsto` = " . $object->getCb_previsto() . ",
            `cbev_previsto` = " . $object->getCbev_previsto() . ",
            `sdep_previsto` = " . $object->getSdep_previsto() . ",
            `sdev_previsto` = " . $object->getSdev_previsto() . ",
            `sten_existente` = " . $object->getSten_existente() . ",
            `1sgt_existente` = " . $object->getSgt1_existente() . ",
            `2sgt_existente` = " . $object->getSgt2_existente() . ",
            `3sgt_existente` = " . $object->getSgt3_existente() . ",
            `cb_existente` = " . $object->getCb_existente() . ",
            `cbev_existente` = " . $object->getCbev_existente() . ",
            `sdep_existente` = " . $object->getSdep_existente() . ",
            `sdev_existente` = " . $object->getSdev_existente() . ",
            `cel_adido` = " . $object->getCel_adido() . ",
            `tc_adido` = " . $object->getTc_adido() . ",
            `maj_adido` = " . $object->getMaj_adido() . ",
            `cap_adido` = " . $object->getCap_adido() . ",
            `1ten_adido` = " . $object->getTen1_adido() . ",
            `2ten_adido` = " . $object->getTen2_adido() . ",
            `aspof_adido` = " . $object->getAspof_adido() . ",
            `sten_adido` = " . $object->getSten_adido() . ",
            `1sgt_adido` = " . $object->getSgt1_adido() . ",
            `2sgt_adido` = " . $object->getSgt2_adido() . ",
            `3sgt_adido` = " . $object->getSgt3_adido() . ",
            `cb_adido` = " . $object->getCb_adido() . ",
            `cbev_adido` = " . $object->getCbev_adido() . ",
            `sdep_adido` = " . $object->getSdep_adido() . ",
            `sdev_adido` = " . $object->getSdev_adido() . ",             
            `cap_pttc_existente` = " . $object->getCap_pttc_existente() . ",
            `1ten_pttc_existente` = " . $object->getTen1_pttc_existente() . ",
            `2ten_pttc_existente` = " . $object->getTen2_pttc_existente() . ",            
            `sten_pttc_existente` = " . $object->getSten_pttc_existente() . ",
            `1sgt_pttc_existente` = " . $object->getSgt1_pttc_existente() . ",
            `2sgt_pttc_existente` = " . $object->getSgt2_pttc_existente() . ",                        
            `cel_adidoTexto` = '" . $object->getCel_adidoTexto() . "',
            `tc_adidoTexto` = '" . $object->getTc_adidoTexto() . "',
            `maj_adidoTexto` = '" . $object->getMaj_adidoTexto() . "',
            `cap_adidoTexto` = '" . $object->getCap_adidoTexto() . "',
            `1ten_adidoTexto` = '" . $object->getTen1_adidoTexto() . "',
            `2ten_adidoTexto` = '" . $object->getTen2_adidoTexto() . "',
            `aspof_adidoTexto` = '" . $object->getAspof_adidoTexto() . "',
            `sten_adidoTexto` = '" . $object->getSten_adidoTexto() . "',
            `1sgt_adidoTexto` = '" . $object->getSgt1_adidoTexto() . "',
            `2sgt_adidoTexto` = '" . $object->getSgt2_adidoTexto() . "',
            `3sgt_adidoTexto` = '" . $object->getSgt3_adidoTexto() . "',
            `cb_adidoTexto` = '" . $object->getCb_adidoTexto() . "',
            `cbev_adidoTexto` = '" . $object->getCbev_adidoTexto() . "',
            `sdep_adidoTexto` = '" . $object->getSdep_adidoTexto() . "',
            `sdev_adidoTexto` = '" . $object->getSdev_adidoTexto() . "',
            `encostados` = '" . $object->getEncostados() . "',
            `agregados` = '" . $object->getAgregados() . "';";            
            $stmt = $c->prepare($sql);            
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList() {
        try {
            $c = connect();
            $sql = "SELECT * FROM `scc`.`MapaDaForca`;
";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new MapaDaForca($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "cel_previsto" => $row["cel_previsto"],
            "tc_previsto" => $row["tc_previsto"],
            "maj_previsto" => $row["maj_previsto"],
            "cap_previsto" => $row["cap_previsto"],
            "ten1_previsto" => $row["1ten_previsto"],
            "ten2_previsto" => $row["2ten_previsto"],
            "aspof_previsto" => $row["aspof_previsto"],
            "sten_previsto" => $row["sten_previsto"],
            "sgt1_previsto" => $row["1sgt_previsto"],
            "sgt2_previsto" => $row["2sgt_previsto"],
            "sgt3_previsto" => $row["3sgt_previsto"],
            "cb_previsto" => $row["cb_previsto"],
            "cbev_previsto" => $row["cbev_previsto"],
            "sdep_previsto" => $row["sdep_previsto"],
            "sdev_previsto" => $row["sdev_previsto"],
            "cel_existente" => $row["cel_existente"],
            "tc_existente" => $row["tc_existente"],
            "maj_existente" => $row["maj_existente"],
            "cap_existente" => $row["cap_existente"],
            "ten1_existente" => $row["1ten_existente"],
            "ten2_existente" => $row["2ten_existente"],
            "aspof_existente" => $row["aspof_existente"],
            "sten_existente" => $row["sten_existente"],
            "sgt1_existente" => $row["1sgt_existente"],
            "sgt2_existente" => $row["2sgt_existente"],
            "sgt3_existente" => $row["3sgt_existente"],
            "cb_existente" => $row["cb_existente"],
            "cbev_existente" => $row["cbev_existente"],
            "sdep_existente" => $row["sdep_existente"],
            "sdev_existente" => $row["sdev_existente"],
            "cel_adido" => $row["cel_adido"],
            "tc_adido" => $row["tc_adido"],
            "maj_adido" => $row["maj_adido"],
            "cap_adido" => $row["cap_adido"],
            "ten1_adido" => $row["1ten_adido"],
            "ten2_adido" => $row["2ten_adido"],
            "aspof_adido" => $row["aspof_adido"],
            "sten_adido" => $row["sten_adido"],
            "sgt1_adido" => $row["1sgt_adido"],
            "sgt2_adido" => $row["2sgt_adido"],
            "sgt3_adido" => $row["3sgt_adido"],
            "cb_adido" => $row["cb_adido"],
            "cbev_adido" => $row["cbev_adido"],
            "sdep_adido" => $row["sdep_adido"],
            "sdev_adido" => $row["sdev_adido"],
            "cel_adidoTexto" => $row["cel_adidoTexto"],
            "tc_adidoTexto" => $row["tc_adidoTexto"],
            "maj_adidoTexto" => $row["maj_adidoTexto"],
            "cap_adidoTexto" => $row["cap_adidoTexto"],
            "ten1_adidoTexto" => $row["1ten_adidoTexto"],
            "ten2_adidoTexto" => $row["2ten_adidoTexto"],
            "aspof_adidoTexto" => $row["aspof_adidoTexto"],
            "sten_adidoTexto" => $row["sten_adidoTexto"],
            "sgt1_adidoTexto" => $row["1sgt_adidoTexto"],
            "sgt2_adidoTexto" => $row["2sgt_adidoTexto"],
            "sgt3_adidoTexto" => $row["3sgt_adidoTexto"],
            "cb_adidoTexto" => $row["cb_adidoTexto"],
            "cbev_adidoTexto" => $row["cbev_adidoTexto"],
            "sdep_adidoTexto" => $row["sdep_adidoTexto"],
            "sdev_adidoTexto" => $row["sdev_adidoTexto"],
            "cap_pttc_previsto" => $row["cap_pttc_previsto"],
            "ten1_pttc_previsto" => $row["1ten_pttc_previsto"],
            "ten2_pttc_previsto" => $row["2ten_pttc_previsto"],
//            "aspof_pttc_previsto" => $row["aspof_pttc_previsto"],
            "sten_pttc_previsto" => $row["sten_pttc_previsto"],
            "sgt1_pttc_previsto" => $row["1sgt_pttc_previsto"],
            "sgt2_pttc_previsto" => $row["2sgt_pttc_previsto"],
            "cap_pttc_existente" => $row["cap_pttc_existente"],
            "ten1_pttc_existente" => $row["1ten_pttc_existente"],
            "ten2_pttc_existente" => $row["2ten_pttc_existente"],
//            "aspof_pttc_existente" => $row["aspof_pttc_existente"],
            "sten_pttc_existente" => $row["sten_pttc_existente"],
            "sgt1_pttc_existente" => $row["1sgt_pttc_existente"],
            "sgt2_pttc_existente" => $row["2sgt_pttc_existente"],
            "cap_pttc_adido" => $row["cap_pttc_adido"],
            "ten1_pttc_adido" => $row["1ten_pttc_adido"],
            "ten2_pttc_adido" => $row["2ten_pttc_adido"],
//            "aspof_pttc_adido" => $row["aspof_pttc_adido"],
            "sten_pttc_adido" => $row["sten_pttc_adido"],
            "sgt1_pttc_adido" => $row["1sgt_pttc_adido"],
            "sgt2_pttc_adido" => $row["2sgt_pttc_adido"],
            "cap_pttc_adidoTexto" => $row["cap_pttc_adidoTexto"],
            "ten1_pttc_adidoTexto" => $row["1ten_pttc_adidoTexto"],
            "ten2_pttc_adidoTexto" => $row["2ten_pttc_adidoTexto"],
//            "aspof_pttc_adidoTexto" => $row["aspof_pttc_adidoTexto"],
            "sten_pttc_adidoTexto" => $row["sten_pttc_adidoTexto"],
            "sgt1_pttc_adidoTexto" => $row["1sgt_pttc_adidoTexto"],
            "sgt2_pttc_adidoTexto" => $row["2sgt_pttc_adidoTexto"],
            "encostados" => $row["encostados"],
            "agregados" => $row["agregados"]
        );
    }

    function getFoto() {
        try {
            $foto = "../include/fotos/mapaDaForca.jpg";
            if (file_exists($foto)) {
                return $foto;
            }
            $foto = "../include/fotos/mapaDaForca.jpeg";
            if (file_exists($foto)) {
                return $foto;
            }
            $foto = "../include/fotos/mapaDaForca.png";
            if (file_exists($foto)) {
                return $foto;
            }
        } catch (Exception $e) {
            throw($e);
        }
    }

    function getDataFotoModificadaOriginal() {
        try {
            $foto = "../include/fotos/mapaDaForca.jpg";
            if (file_exists($foto)) {
                return date("Y/m/d", filectime($foto));
            }
            $foto = "../include/fotos/mapaDaForca.jpeg";
            if (file_exists($foto)) {
                return date("Y/m/d", filectime($foto));
            }
            $foto = "../include/fotos/mapaDaForca.png";
            if (file_exists($foto)) {
                return date("Y/m/d", filectime($foto));
            }
            return "";
        } catch (Exception $e) {
            throw($e);
        }
    }

    function getDataFotoModificada() {
        try {
            $foto = "../include/fotos/mapaDaForca.jpg";
            if (file_exists($foto)) {
                return date("d/m/Y às H:i", filectime($foto));
            }
            $foto = "../include/fotos/mapaDaForca.jpeg";
            if (file_exists($foto)) {
                return date("d/m/Y às H:i", filectime($foto));
            }
            $foto = "../include/fotos/mapaDaForca.png";
            if (file_exists($foto)) {
                return date("d/m/Y H:i", filectime($foto));
            }
            return "";
        } catch (Exception $e) {
            throw($e);
        }
    }

    function uploadFoto($foto) {
        try {
            $this->deleteFoto();
            $nome = "mapaDaForca";
            $tipo = strtolower($foto["type"]);
            switch ($tipo) {
                case "image/jpeg":
                    $extensao = ".jpg";
                    break;
                case "image/png":
                    $extensao = ".png";
                    break;
                default:
                    return false;
            }
            if (move_uploaded_file($foto["tmp_name"], "../include/fotos/" . $nome . $extensao)) {
                return true;
            } else {
                return false;
            }
            return false;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function deleteFoto() {
        try {
            $delete = unlink("../include/fotos/mapaDaForca.jpg");
            if (!$delete) {
                $delete = unlink("../include/fotos/mapaDaForca.jpeg");
                if (!$delete) {
                    $delete = unlink("../include/fotos/mapaDaForca.png");
                    if (!$delete) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            } else {
                return true;
            }
        } catch (Exception $e) {
            throw($e);
        }
    }

}
