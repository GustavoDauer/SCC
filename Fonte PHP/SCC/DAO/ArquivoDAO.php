<?php

/* * *****************************************************************************
 * 
 * Copyright © 2021 Gustavo Henrique Mello Dauer - 2º Ten 
 * Chefe da Seção de Informática do 2º BE Cmb
 * Email: gustavodauer@gmail.com
 * 
 * Este arquivo é parte do programa SOSPO
 * 
 * SOSPO é um software livre; você pode redistribuí-lo e/ou
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

class FotoDAO {

    function getFoto($id) {
        try {
            $foto = "../include/fotos/$id";
            if (file_exists($foto . ".jpg")) {
                return $foto . ".jpg";
            }
            if (file_exists($foto . ".png")) {
                return $foto . ".png";
            }
            return "../include/imagens/semfoto.jpg";
        } catch (Exception $e) {
            throw($e);
        }
    }

    function uploadFoto($foto, $id, $prefix = "") {
        try {
            if (is_array($foto) && !empty($foto["name"])) {
                $tamanho = filesize($foto["tmp_name"]);
                if ($tamanho / 1024 > 40) {
                    throw new Exception("Tamanho do arquivo deve ser de no máximo 40 KB.<br>O arquivo selecionado possui " . round($tamanho / 1024, 2) . "KB.");
                    return false;
                }
                $this->deleteFoto($id);
                $nome = "$id";
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
                if (!empty($nome)) {
                    if (move_uploaded_file($foto["tmp_name"], "../include/fotos/" . $prefix . $nome . $extensao)) {
                        return true;
                    }
                } else {
                    throw new Exception("Erro na geração do nome do arquivo.<br><i>O arquivo apresentou o nome $prefix.$nome.$extensao");
                }
                throw new Exception("Erro desconhecido ao tentar salvar o arquivo. É possível que haja erro na configuração do diretório. Informe a Seção de Informática.");
                return false;
            }
            return true;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function deleteFoto($id) {
        try {
            $foto = "../include/fotos/$id.jpg";
            if (file_exists($foto)) {
                $delete = unlink($foto);
                if ($delete) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $foto = "../include/fotos/$id.png";
                if (file_exists($foto)) {
                    $delete = unlink($foto);
                    if ($delete) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            throw($e);
        }
    }
}
