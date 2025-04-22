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
        <script type="text/javascript">
            function permissionError() {
                $("#erroPermissao").modal();
                return false;
            }
        </script>
    </head>
    <body style="margin-top: 7px;">
        <div class="modal fade" id="erroPermissao" tabindex="-1" role="dialog" aria-labelledby="mensagemLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="width: 800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mensagemLabel" style="color: red;">Acesso Negado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                  
                        <span style='font-size: 14px;'>
                            Você não possui permissão para acessar este setor.<br>
                            Caso haja necessidade de acesso, procure o administrador do sistema.
                        </span>
                    </div>
                    <div class="modal-footer">
                        <span style='font-size: 14px; font-weight: bold;'>Seção de Informática</span>
                    </div>
                </div>
            </div>
        </div>
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

            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "ComandoController") > 0 ? "active" : ""; ?>" href='../Controller/ComandoController.php?action=getAllList&resolvido=0' <?php if (!isAdminLevel($LISTAR_COMANDO)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/comando.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_COMANDO)) { ?> style="filter: grayscale(1);" <?php } ?>> Comando
                </a>                        
            </li>                                        
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "S1Controller") > 0 ? "active" : ""; ?>" href='../Controller/S1Controller.php?action=getAllList' <?php if (!isAdminLevel($LISTAR_S1) && !isAdminLevel($LISTAR_JURIDICO)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/s1.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_S1) && !isAdminLevel($LISTAR_JURIDICO)) { ?> style="filter: grayscale(1);" <?php } ?>> S1
                </a>                        
            </li>                        
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "S2Controller") > 0 ? "active" : ""; ?>" href='../Controller/S2Controller.php?action=getAllList&dataExpiracao=ativos' <?php if (!isAdminLevel($LISTAR_S2)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/s2.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_S2)) { ?> style="filter: grayscale(1);" <?php } ?>> S2
                </a>                        
            </li>                                 
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "S4Controller") > 0 ? "active" : ""; ?>" href='../Controller/S4Controller.php?action=getAllList' <?php if (!isAdminLevel($LISTAR_S4)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/s4.jpg" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_S4)) { ?> style="filter: grayscale(1);" <?php } ?>> S4
                </a>                        
            </li>                        
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "FSController") > 0 ? "active" : ""; ?>" href='../Controller/FSController.php?action=getAllList' <?php if (!isAdminLevel($LISTAR_FS)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/fs.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_FS)) { ?> style="filter: grayscale(1);" <?php } ?>> FS
                </a>                        
            </li>                        
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "RPController") > 0 ? "active" : ""; ?>" href='../Controller/RPController.php?action=getAllList' <?php if (!isAdminLevel($LISTAR_RP)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/rp.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_RP)) { ?> style="filter: grayscale(1);" <?php } ?>> RP
                </a>
            </li>                        
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "FiscalizacaoController") > 0 || substr_count($address, "CategoriaController") > 0 ? "active" : ""; ?>" href='../Controller/FiscalizacaoController.php?action=getAllList&ano=<?= date('Y'); ?>' <?php if (!isAdminLevel($LISTAR_FISCALIZACAO)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/fiscalizacao.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_FISCALIZACAO)) { ?> style="filter: grayscale(1);" <?php } ?>>Fiscalização
                </a>
            </li>                        
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "IdentidadeController") > 0 ? "active" : ""; ?>" href='../Controller/IdentidadeController.php?action=getAllList' <?php if (!isAdminLevel($LISTAR_IDENTIDADE)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/identidade.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_IDENTIDADE)) { ?> style="filter: grayscale(1);" <?php } ?>>Identidade
                </a>
            </li>                        
            <li class="nav-item">
                <a class="nav-link <?= substr_count($address, "SPPController") > 0 ? "active" : ""; ?>" href='../Controller/SPPController.php?action=getAllList' <?php if (!isAdminLevel($LISTAR_SPP)) { ?> onclick="return permissionError();" <?php } ?>>
                    <img src="../include/imagens/spp.png" height="35" hspace="2" <?php if (!isAdminLevel($LISTAR_SPP)) { ?> style="filter: grayscale(1);" <?php } ?>> SPP
                </a>
            </li>            
        </ul>
