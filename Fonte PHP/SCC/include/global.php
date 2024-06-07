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
$VERSAO = "19.14";
$SOFTWARE = "SCC";
$TODAS_SECOES = array("SALC", "Conformidade", "Almoxarifado", "Tesouraria", "S1", "S2", "S3", "S4", "FS", "Juridico", "Fiscalizacao", "RP", "SecInfo", "Comando", "Identidade");
$ADMINISTRADORES = array("S2", "SecInfo", "Comando");
$REQUISITANTES = $TODAS_SECOES; // Referenciar seções que podem adicionar requisições
$SALC = array("SALC", "SecInfo"); // Referenciar seções que podem administrar informações da SALC (caso haja)
$CONFORMIDADE = array("Conformidade", "SecInfo"); // Referenciar seções que podem administrar informações da Conformidade (caso haja)
$ALMOXARIFADO = array("Almoxarifado", "SecInfo"); // Referenciar seções que podem administrar informações do Almoxarifado (caso haja)
$TESOURARIA = array("Tesouraria", "SecInfo"); // Referenciar seções que podem administrar informações da Tesouraria (caso haja)

$LISTAR_USUARIO = $ADMINISTRADORES;
$ADICIONAR_USUARIO = array("SecInfo");
$EDITAR_USUARIO = array("SecInfo");
$EXCLUIR_USUARIO = array("SecInfo");

$LISTAR_S1 = array_merge(array("S1"), $ADMINISTRADORES);
$ADICIONAR_S1 = array("S1", "SecInfo");
$EDITAR_S1 = array("S1", "SecInfo");
$EXCLUIR_S1 = array("SecInfo");

$LISTAR_S2 = array_merge(array("S2"), $ADMINISTRADORES);
$ADICIONAR_S2 = array("S2", "SecInfo");
$EDITAR_S2 = array("S2", "SecInfo");
$EXCLUIR_S2 = array("SecInfo");

$LISTAR_JURIDICO = $TODAS_SECOES;
$ADICIONAR_JURIDICO = array("Juridico", "SecInfo");
$EDITAR_JURIDICO = array("Juridico", "SecInfo");
$EXCLUIR_JURIDICO = array("Juridico", "SecInfo");

$LISTAR_S3 = array_merge(array("S3"), $ADMINISTRADORES);
$ADICIONAR_S3 = array("S3", "SecInfo");
$EDITAR_S3 = array("S3", "SecInfo");
$EXCLUIR_S3 = array("SecInfo");

$LISTAR_S4 = array_merge(array("S4"), $ADMINISTRADORES);
$ADICIONAR_S4 = array("S4", "SecInfo");
$EDITAR_S4 = array("S4", "SecInfo", "Comando"); // Comando para visualizar providências
$EXCLUIR_S4 = array("SecInfo");

$LISTAR_FS = array_merge(array("FS"), $ADMINISTRADORES); // Informação semi-confidencial relevante apenas a FS e aos administradores
$ADICIONAR_FS = array("FS", "SecInfo");
$EDITAR_FS = array("FS", "SecInfo");
$EXCLUIR_FS = array("FS", "SecInfo");

$LISTAR_FISCALIZACAO = $TODAS_SECOES;
$ADICIONAR_FISCALIZACAO = $TODAS_SECOES;
$EDITAR_FISCALIZACAO = $TODAS_SECOES;
$EXCLUIR_FISCALIZACAO = array("SecInfo");

$LISTAR_FISCALIZACAO_NC = $TODAS_SECOES;
$ADICIONAR_FISCALIZACAO_NC = array("SALC", "SecInfo");
$EDITAR_FISCALIZACAO_NC = array("SALC", "SecInfo");
$EXCLUIR_FISCALIZACAO_NC = array("SecInfo");

$LISTAR_RP = array_merge(array("RP"), $ADMINISTRADORES);
$ADICIONAR_RP = array("RP", "SecInfo");
$EDITAR_RP = array("RP", "SecInfo");
$EXCLUIR_RP = array("RP", "SecInfo");

$LISTAR_CATEGORIA = array_merge(array("Almoxarifado"), $ADMINISTRADORES);
$ADICIONAR_CATEGORIA = array("Almoxarifado", "SecInfo");
$EDITAR_CATEGORIA = array("Almoxarifado", "SecInfo");
$EXCLUIR_CATEGORIA = array("SecInfo");

$LISTAR_COMANDO = array("Comando", "SecInfo");
$ADICIONAR_COMANDO = array("Comando", "SecInfo");
$EDITAR_COMANDO = array("Comando", "SecInfo");
$EXCLUIR_COMANDO = array("Comando", "SecInfo");

$LISTAR_IDENTIDADE = array("Identidade", "SecInfo");
$ADICIONAR_IDENTIDADE = array("Identidade", "SecInfo");
$EDITAR_IDENTIDADE = array("Identidade", "SecInfo");
$EXCLUIR_IDENTIDADE = array("Identidade", "SecInfo");

// INEXISTENTES
$LISTAR_SECINFO = array("SecInfo");
$ADICIONAR_SECINFO = array("SecInfo");
$EDITAR_SECINFO = array("SecInfo");
$EXCLUIR_SECINFO = array("SecInfo");
