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
require '../include/global.php';
require_once '../include/comum.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sistema de Controle do Comando 2º BE Cmb</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">                   
        <link rel="stylesheet" href="../include/css/bootstrap.min.css">
        <link rel="stylesheet" href="../include/css/estilos.css">
        <script src="../include/js/jquery.min.js"></script>
        <script src="../include/js/bootstrap.min.js"></script>        
        <script src="../include/js/popper.min.js"></script>                       
        <style type="text/css">
            .container h2 {
                font-size: 16px;
                margin-top: 14px;
            }
            .container h2 button {
                font-size: 14px;
                padding: 2px 7px 2px 7px;
            }
            .feedback {
                font-size: 14px;
                font-family: sans-serif;
            }
        </style>
    </head>
    <body style="margin-top: 7px;">
        <a name="topo"></a>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="bottom" style="text-align: center;">
                                <h1 style="margin: 0px; padding: 0px; font-family: serif; letter-spacing: 2px; font-weight: bold; font-size: 29px; color: #34b2ee;">
                                    <img src="../include/imagens/castelo.jpg" height="29">
                                    <?= $SOFTWARE ?>
                                    <span style="color: #99ccff; font-family: sans-serif; letter-spacing: 0px; font-weight: normal; font-size: 12px;">V. <?= $VERSAO ?></span>
                                </h1>                                                                
                            </td>
                        </tr>
                    </table>                                                   
                </div>                
                <div class="col-md-3" style="text-align: left; padding-top: 7px;">
                    <span style="font-size: 10px; font-family: sans-serif;">                            
                        <?php if (isAdminLevel($LISTAR_USUARIO)) { ?>
                            <a href="../Controller/UsuarioController.php?action=getAllList">                            
                                <img src="../include/imagens/gerenciar_usuarios.png" width="25" height="25" hspace="2" vspace="2"> Usuários
                            </a> |
                        <?php } ?>    
                        <?php if (isAdminLevel($LISTAR_CATEGORIA)) { ?>
                            <a href="../Controller/CategoriaController.php?action=getAllList">                            
                                <img src="../include/imagens/gerenciar_categorias.jpg" width="25" height="25" hspace="2" vspace="2"> Categorias
                            </a> |
                        <?php } ?>
                    </span>
                    <!--<hr style="margin: 0px;">-->
                </div>
                <div class="col-md-6" style="text-align: right; padding-top: 7px;">
                    <?php if (isLoggedIn()) { ?>                                                                    
                        <span style="font-size: 14px; color: green">
                            Usuário: <?= $_SESSION["scclogin"] ?>
                        </span> 
                        |
                        <span style="font-size: 14px;">
                            <a href="../Controller/UsuarioController.php?action=changePassword&id=<?= $_SESSION["sccid"] ?>">
                                Alterar senha
                            </a> 
                            | 
                            <a href="../Controller/UsuarioController.php?action=logout">
                                <img src="../include/imagens/sair.png" width="20" height="20"> Sair                                
                            </a>                                      
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
        $address = $_SERVER['REQUEST_URI'];
        $secoes = $_SESSION["sccsecoes"];
        ?>        
        <ul class="nav nav-tabs" style="margin-top: 2px;">  
            <?php if (isAdminLevel($LISTAR_COMANDO)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "ComandoController") > 0 ? "active" : ""; ?>" href='../Controller/ComandoController.php?action=getAllList&resolvido=0'>
                        <img src="../include/imagens/comando.png" height="35" hspace="2"> Comando
                    </a>                        
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_S1) || isAdminLevel($LISTAR_JURIDICO)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "S1Controller") > 0 ? "active" : ""; ?>" href='../Controller/S1Controller.php?action=getAllList'>
                        <img src="../include/imagens/s1.png" height="35" hspace="2"> S1
                    </a>                        
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_S2)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "S2Controller") > 0 ? "active" : ""; ?>" href='../Controller/S2Controller.php?action=getAllList'>
                        <img src="../include/imagens/s2.png" height="35" hspace="2"> S2
                    </a>                        
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_S3)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "S3Controller") > 0 ? "active" : ""; ?>" href='../Controller/S3Controller.php?action=getAllList'>
                        <img src="../include/imagens/s3.png" height="35" hspace="2"> S3
                    </a>                        
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_S4)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "S4Controller") > 0 ? "active" : ""; ?>" href='../Controller/S4Controller.php?action=getAllList'>
                        <img src="../include/imagens/s4.jpg" height="35" hspace="2"> S4
                    </a>                        
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_FS)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "FSController") > 0 ? "active" : ""; ?>" href='../Controller/FSController.php?action=getAllList'>
                        <img src="../include/imagens/fs.png" height="35" hspace="2"> FS
                    </a>                        
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_RP)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "RPController") > 0 ? "active" : ""; ?>" href='../Controller/RPController.php?action=getAllList'>
                        <img src="../include/imagens/rp.png" height="35" hspace="2"> RP
                    </a>
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_FISCALIZACAO)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "FiscalizacaoController") > 0 ? "active" : ""; ?>" href='../Controller/FiscalizacaoController.php?action=getAllList&ano=<?= date('Y'); ?>'>
                        <img src="../include/imagens/fiscalizacao.png" height="35" hspace="2">Fiscalização
                    </a>
                </li>
            <?php } ?>
            <?php if (isAdminLevel($LISTAR_IDENTIDADE)) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= substr_count($address, "IdentidadeController") > 0 ? "active" : ""; ?>" href='../Controller/IdentidadeController.php?action=getAllList'>
                        <img src="../include/imagens/identidade.png" height="35" hspace="2">Identidade
                    </a>
                </li>
            <?php } ?>                  
        </ul>
