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
$VERSAO = "21.17";
$SOFTWARE = "SCC";
$TODAS_SECOES = array("S1", "S2", "S4", "FS", "Juridico", "Fiscalizacao", "RP", "SecInfo", "Comando", "Identidade", "SPP");
$ADMINISTRADORES = array("S2", "SecInfo", "Comando");

$LISTAR_USUARIO = $ADMINISTRADORES;
$ADICIONAR_USUARIO = array("SecInfo");
$EDITAR_USUARIO = array("SecInfo");
$EXCLUIR_USUARIO = array("SecInfo");

$LISTAR_S1 = array_merge(array("S1", "Juridico"), $ADMINISTRADORES);
$ADICIONAR_S1 = array_merge(array("S1"), $ADMINISTRADORES);
$EDITAR_S1 = array_merge(array("S1"), $ADMINISTRADORES);
$EXCLUIR_S1 = $ADMINISTRADORES;

$LISTAR_S2 = array_merge(array("S2"), $ADMINISTRADORES);
$ADICIONAR_S2 = array_merge(array("S2"), $ADMINISTRADORES);
$EDITAR_S2 = array_merge(array("S2"), $ADMINISTRADORES);
$EXCLUIR_S2 = $ADMINISTRADORES;

$LISTAR_JURIDICO = array_merge(array("S1", "Juridico"), $ADMINISTRADORES);
$ADICIONAR_JURIDICO = array_merge(array("Juridico"), $ADMINISTRADORES);
$EDITAR_JURIDICO = array_merge(array("Juridico"), $ADMINISTRADORES);
$EXCLUIR_JURIDICO = array_merge(array("Juridico"), $ADMINISTRADORES);

$LISTAR_S4 = array_merge(array("S4"), $ADMINISTRADORES);
$ADICIONAR_S4 = array_merge(array("S4"), $ADMINISTRADORES);
$EDITAR_S4 = array_merge(array("S4"), $ADMINISTRADORES);
$EXCLUIR_S4 = $ADMINISTRADORES;

$LISTAR_FS = array_merge(array("FS"), $ADMINISTRADORES);
$ADICIONAR_FS = array_merge(array("FS"), $ADMINISTRADORES);
$EDITAR_FS = array_merge(array("FS"), $ADMINISTRADORES);
$EXCLUIR_FS = array_merge(array("FS"), $ADMINISTRADORES);

$LISTAR_FISCALIZACAO = $ADMINISTRADORES;
$ADICIONAR_FISCALIZACAO = $TODAS_SECOES;
$EDITAR_FISCALIZACAO = $TODAS_SECOES;
$EXCLUIR_FISCALIZACAO = array_merge(array("Fiscalizacao"), $ADMINISTRADORES);

$LISTAR_FISCALIZACAO_NC = $ADMINISTRADORES;
$ADICIONAR_FISCALIZACAO_NC = $ADMINISTRADORES;
$EDITAR_FISCALIZACAO_NC = $ADMINISTRADORES;
$EXCLUIR_FISCALIZACAO_NC = $ADMINISTRADORES;

$LISTAR_RP = array_merge(array("RP"), $ADMINISTRADORES);
$ADICIONAR_RP = array_merge(array("RP"), $ADMINISTRADORES);
$EDITAR_RP = array_merge(array("RP"), $ADMINISTRADORES);
$EXCLUIR_RP = array_merge(array("RP"), $ADMINISTRADORES);

$LISTAR_CATEGORIA = $ADMINISTRADORES;
$ADICIONAR_CATEGORIA = $ADMINISTRADORES;
$EDITAR_CATEGORIA = $ADMINISTRADORES;
$EXCLUIR_CATEGORIA = $ADMINISTRADORES;

$LISTAR_COMANDO = array_merge(array("Comando"), $ADMINISTRADORES);
$ADICIONAR_COMANDO = array_merge(array("Comando"), $ADMINISTRADORES);
$EDITAR_COMANDO = array_merge(array("Comando"), $ADMINISTRADORES);
$EXCLUIR_COMANDO = array_merge(array("Comando"), $ADMINISTRADORES);

$LISTAR_IDENTIDADE = array_merge(array("Identidade"), $ADMINISTRADORES);
$ADICIONAR_IDENTIDADE = array_merge(array("Identidade"), $ADMINISTRADORES);
$EDITAR_IDENTIDADE = array_merge(array("Identidade"), $ADMINISTRADORES);
$EXCLUIR_IDENTIDADE = array_merge(array("Identidade"), $ADMINISTRADORES);

$LISTAR_SPP = array_merge(array("SPP"), $ADMINISTRADORES);

// INEXISTENTES
$LISTAR_SECINFO = array("SecInfo");
$ADICIONAR_SECINFO = array("SecInfo");
$EDITAR_SECINFO = array("SecInfo");
$EXCLUIR_SECINFO = array("SecInfo");
