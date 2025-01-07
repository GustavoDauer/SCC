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
 * publicada pela Free Software Foundation (RPF); na versão 3 da
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
require_once '../include/global.php';
require_once '../include/comum.php';
$hoje = date('Y-m-d');
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
        <script src="../include/js/jquery-3.4.1.slim.min.js"></script>
        <script src="../include/js/popper.min.js"></script>
        <script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
    </head>
    <body style="margin-top: 7px;">
        <div align="center">                          
            <?php
            if (isset($autorizado)) {
                ?>
                <img src="../include/imagens/<?= $autorizado ?>.png" width="100"><br>
                <?php
            }
            ?>  
            <?php
            if (isset($autorizado) && $autorizado !== "") {
                if ($autorizado === "autorizado") {
                    ?>
                    <span style="color: darkgreen; font-weight: bold;">AUTORIZADO!</span><br>   
                    <span style="font-family: serif; font-size: 14px;">
                        <?php if (!is_null($object)) { ?>    
                            <?= $object->getMarca() ?> <?= $object->getModelo() ?> <?= $object->getAnoFabricacao() ?><br>
                            Cor: <?= $object->getAnoModelo() ?> <input type="color" value="<?= $object->getCor() ?>" disabled> 
                            Placa: <?= $object->getPlaca() ?>
                        </span>
                        <?php
                    } else if (!is_null($pessoa)) {
                        ?>
                        <span style="font-family: serif; font-size: 14px;font-weight: bold; color: darkgreen;">
                            <img src="../include/imagens/visitantes.jpeg" width="115"><br>
                            Nome: <?= $pessoa->getNome(); ?> <u>(TITULAR)</u><br>
                            PREC-CP: <?= $pessoa->getPreccp(); ?><br>
                            Placa: <?= $placa ?>
                        </span>
                        <?php
                    }
                } else {
                    ?>
                    <span style="color: red; font-weight: bold;">NÃO AUTORIZADO!</span><br>                                          
                    <span style="color:red;">
                        O veículo de placa <?= $placa ?> <strong><u>NÃO</u></strong> está autorizado adentrar ao Estacionamento do Batalhão.<br>
                    </span>
                    <?php if (isset($preccp)) { ?>
                        <span style="color:red;">
                            O PREC-CP <?= $preccp ?> <strong><u>NÃO</u></strong> foi encontrado na base de dados do FuSEx.<br>
                            O usuário <strong><u>NÃO</u></strong> pode utilizar o Estacionamento do Batalhão.<br>
                        </span>
                    <?php } ?>
                    <form accept-charset="UTF-8" action="../Controller/S2Controller.php?action=servico_veiculo_preccp" class="needs-validation" novalidate method="post">
                        <input type="hidden" name="placa" value="<?= $placa ?>">
                        <table cellspacing="7" cellpadding="7" style="border: 1px dotted red; margin-top: 7px;">
                            <tr>
                                <th colspan="2" style="border-bottom: 1px dotted red;">ALTERNATIVAS</th>
                            </tr>
                            <tr>
                                <td style="border-right: 1px dotted red; color: #ff6600; text-align: center;">
                                    <strong>1ª POSSIBILIDADE<br><span style="color: red;">VAGAS DE VISITANTES</span></strong></td>
                                <td style="text-align: center;">
                                    <strong>Destinada para usuários FuSEx, SVP, Dentista ou Identidade</strong><br><br>
                                    <input type="text" class="form-control" id="preccp" name="preccp" maxlength="9" placeholder="INFORME PREC-CP" style="text-align: center;" oninput="verifyPreccp();return event.charCode >= 48 && event.charCode <= 57;">
                                    <div id="avisoPreccp" style="color: red; font-size: 10px; text-align: center;margin-top: 7px;margin-bottom: 7px;"></div>
                                    <button id="verificarPreccp" type="submit" class="btn btn-danger" disabled onmouseover="verifyButtonPreccp();">Verificar PREC-CP</button>
                                </td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px dotted red; border-top: 1px dotted red; color: #ff6600; text-align: center;">
                                    <strong>2ª POSSIBILIDADE<br></strong>
                                </td>
                                <td style="border-top: 1px dotted red;">
                                    <strong><u>Orientar o usuário a estacionar FORA do estacionamento do Batalhão.</u></strong>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php
                }
            }
            ?>
            <hr>
            <h2 style="font-family: serif;">
                <img src="../include/imagens/estacionamento.png" width="100"><br>
                Checagem de Veículos                             
            </h2>
            <form accept-charset="UTF-8" action="../Controller/S2Controller.php?action=servico_veiculo" class="needs-validation" novalidate method="post">                     
                <hr>
                <table cellpadding="2" cellspacing="0">
                    <tr>                        
                        <td>
                            <input type="text" class="form-control" id="placa" name="placa" maxlength="8" oninput="this.value = this.value.toUpperCase();verifyPlaca();" placeholder="PLACA" style="text-align: center;" minlength="7" required>
                            <div id="aviso" style="color: red; font-size: 10px; text-align: center; margin-top: 7px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button id="verificar" type="submit" class="btn btn-primary" disabled onmouseover="verifyButton();">Verificar</button>
                        </td>
                    </tr>
                </table>                                                                                 
            </form>
        </div>
        <script>
            // Disable form submissions if there are invalid fields
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    // Get the forms we want to add validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();

            String.prototype.reverse = function () {
                return this.split('').reverse().join('');
            };

            $(document).ready(function () {
                $('[name=placa]').mask('SSS-0A00');
                $('[name=preccp]').mask('000000000');
            });

            function verifyPlaca() {
                var placaInput = document.getElementById("placa");
                var verificarButton = document.getElementById("verificar");
                if (placaInput.value.length >= 8) {
                    verificarButton.disabled = false;
                } else {
                    verificarButton.disabled = true;
                }
            }

            function verifyPreccp() {
                var preccpInput = document.getElementById("preccp");
                var verificarButton = document.getElementById("verificarPreccp");
                if (preccpInput.value.length >= 9) {
                    verificarButton.disabled = false;
                } else {
                    verificarButton.disabled = true;
                }

            }

            function verifyButton() {
                var verificarButton = document.getElementById("verificar");
                if (verificarButton.disabled) {
                    document.getElementById("aviso").innerHTML = "Preencha a placa do veículo corretamente!";
                } else {
                    document.getElementById("aviso").innerHTML = "";
                }
            }

            function verifyButtonPreccp() {
                var verificarButton = document.getElementById("verificarPreccp");
                if (verificarButton.disabled) {
                    document.getElementById("avisoPreccp").innerHTML = "Preencha o PREC-CP corretamente!";
                } else {
                    document.getElementById("avisoPreccp").innerHTML = "";
                }
            }
        </script>
        <hr>
        <!--<div style="font-size: 10px; font-family: sans-serif; text-align: center;">
            <br><br><img src="../include/imagens/logo_2becmb.png" width="50"><br><br>
            Sistema de Controle do Comando (SCC) - (<a href="https://github.com/GustavoDauer/SCC" target="_blank">GitHub</a>)<br>SecInfo - 2º BECmb
        </div>-->
        <br><br>
    </body>
</html>        