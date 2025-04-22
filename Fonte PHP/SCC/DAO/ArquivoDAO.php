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

class ArquivoDAO {

    function getArquivo($id) {
        try {
            $arquivo = "../include/arquivos/$id";
            if (file_exists($arquivo . ".pdf")) {
                return $arquivo . ".pdf";
            }            
            return "../include/imagens/semarquivo.pdf";
        } catch (Exception $e) {
            throw($e);
        }
    }

    function uploadArquivo($arquivo, $id) {
        try {
            if (is_array($arquivo) && !empty($arquivo["name"])) {
                $tamanho = filesize($arquivo["tmp_name"]);
                $tamanhoMaximo = 25 * 1024 * 1024; // 25 MB em bytes

                if ($tamanho > $tamanhoMaximo) {
                    throw new Exception("Tamanho do arquivo deve ser de no máximo 25 MB.<br>O arquivo selecionado possui " . round($tamanho / (1024 * 1024), 2) . " MB.");
                    return false;
                }
                $this->deleteArquivo($id);
                $nome = "$id";
                $tipo = strtolower($arquivo["type"]);
                switch ($tipo) {
                    case "application/pdf":
                        $extensao = ".pdf";
                        break;                    
                    default:
                        return false;
                }
                if (!empty($nome)) {
                    if (move_uploaded_file($arquivo["tmp_name"], "../include/arquivos/" . $nome . $extensao)) {
                        return true;
                    }
                } else {
                    throw new Exception("Erro na geração do nome do arquivo.<br><i>O arquivo apresentou o nome $nome.$extensao");
                }
                throw new Exception("Erro desconhecido ao tentar salvar o arquivo. É possível que haja erro na configuração do diretório. Informe a Seção de Informática.");
                return false;
            }
            return true;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function deleteArquivo($id) {
        try {
            $arquivo = "../include/arquivos/$id.pdf";
            if (file_exists($arquivo)) {
                $delete = unlink($arquivo);
                if ($delete) {
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            throw($e);
        }
    }
}
