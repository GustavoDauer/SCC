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
require_once '../include/global.php';

$erro = isset($_REQUEST["error"]) ? $_REQUEST["error"] : "";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sistema de Controle do Comando 2º BE Cmb</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">                  
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>                  
        <link rel="stylesheet" href="../include/css/bootstrap.min.css">                
        <script src="../include/js/bootstrap.min.js"></script>
        <script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
        <style type="text/css">
            @-webkit-keyframes formFadeIn {
                0% { opacity: 0; }
                100% { opacity: 0.7; } 
            }
            @-moz-keyframes formFadeIn {
                0% { opacity: 0;}
                100% { opacity: 0.7; }
            }
            @-o-keyframes formFadeIn {
                0% { opacity: 0; }
                100% { opacity: 0.7; }
            }
            @keyframes formFadeIn {
                0% { opacity: 0; }
                100% { opacity: 0.7; }
            }             

            .formFadeIn {
                width: 500px;   
                background: black;
                opacity: 0.7;
                -webkit-animation: formFadeIn 2s ease-in-out;
                -moz-animation: formFadeIn 2s ease-in-out;
                -o-animation: formFadeIn 2s ease-in-out;
                animation: formFadeIn 2s ease-in-out;
            }           

            .container h2 {
                margin-top: 14px;
            }
        </style>
    </head>
    <body style="margin: 0px; padding: 0px; background: #c5f9d0; background-image: url('../include/imagens/fundo_pagina.jpg'); background-repeat: no-repeat; background-size: 100% 100%;">
        <?php if ($erro == 1) { ?>
            <div class="alert alert-danger">
                <strong>ERRO!</strong> Usuário ou senha incorretos, tempo de seção expirado ou usuário sem seção válida!
            </div>
        <?php } ?>
        <div align="center" style="color: white;">
            <div align="center" style="margin-top: 25px; padding-top: 70px;">                                
                <form accept-charset="UTF-8" action="../Controller/UsuarioController.php?action=login" method="post" class="formFadeIn">   
                    <h1 style="font-family: serif; letter-spacing: 2px; font-weight: bold; font-size: 55px; color: #34b2ee;">
                        <img src="../include/imagens/estandarte.png" height="100"><br>
                        <?= $SOFTWARE ?>
                        <span style="font-size: 14px;">Versão <?= $VERSAO ?></span>
                    </h1>            
                    <h2 style="font-family: serif; font-size: 25px; font-weight: bold; color: #4afd70;">Sistema de Controle do Comando <br>2º BE Cmb</h2>
                    <hr>
                    <table border="0" cellpadding="7" cellspacing="0">
                        <tr>
                            <td class="form-label">Login:</td>
                            <td><input type="text" name="login" style="color: blue;" maxlength="250"></td>
                        </tr>
                        <tr>
                            <td class="form-label">Senha:</td>
                            <td><input type="password" name="senha" style="color: blue;" maxlength="250"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" value="Entrar"></td>
                        </tr>
                    </table> 
                    <hr>
                </form>                
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#myInput").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>        
        <hr>
        <div style="color: white; font-size: 14px; font-family: sans-serif; text-align: center;">
            <br><br><img src="../include/imagens/logo_2becmb.png"><br><br>
            Sistema de Controle do Comando (SCC) - Versão <?= $VERSAO ?> (<a href="https://github.com/GustavoDauer/SCC" target="_blank">GitHub</a>)<br>SecInfo - 2º BECmb
        </div>
        <br><br>
    </body>
</html>