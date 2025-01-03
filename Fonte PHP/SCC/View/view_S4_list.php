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
require_once '../include/header.php';
$hoje = new DateTime();

function formatValue($value) {
    echo "<span style='color:" . ($value <= 0 ? "red" : "green") . "'>$value</span>";
}
?>
<script type="text/javascript" src="../include/js/common.js"></script>
<div class="conteudo"> 
    <?php
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("S4")->getDataAtualizacaoOriginal()), $hoje);
    if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 7) {
        $color = "red";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') > 2 && $dateDif->format('%a') < 7) {
        $color = "darkorange";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') <= 2) {
        $color = "darkgreen";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    }
    ?>    
    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("S4")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("S4")->getMensagem(); ?></h6>
    <div align="left">                        
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#combustivel">Editar mensagem</button>
    </div>        
    <br>
    <?php
    if (is_array($combustivelList) && isAdminLevel($LISTAR_S4)) {
        foreach ($combustivelList as $object) {
            ?>
            <div style="border: 1px dashed lightskyblue; padding: 7px;">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTableC1');minimize('myTableC2');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTableC1');maximize('myTableC2');">
                <?php if (isAdminLevel($EDITAR_S4)) { ?>
                    <span style="text-align: right;">
                        <a href="../Controller/S4Controller.php?action=combustivel_update"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar' style="margin-left: 14px;"></a>
                    </span>                                   
                <?php } ?>
                <span style="margin-left: 14px; font-weight: bold;">RELATÓRIO DE COMBUSTÍVEL</span>
            </div>
            <table class="table table-bordered" style="margin-top: 7px;" id="myTableC1">
                <thead>
                    <tr>    
                        <th colspan="6" style="background-color: #fffdd7; border: 0;">
                            SALDO DE COMBUSTÍVEL - COTA 02                             
                        </th>       
                        <th style="text-align: right; background-color: #fffdd7; border: 0;">

                        </th>
                    </tr>         
                    <tr style="text-align: center">    
                        <th colspan="3" style="width: 50%;">CTC 01</th>                                          
                        <th colspan="4">CTC 04</th>
                    </tr>
                </thead>
                <tbody> 
                    <tr style="text-align: center; font-weight: bold;">
                        <td><?= $object->getCtc01celula1() ?></td>
                        <td><?= $object->getCtc01celula2() ?></td>
                        <td><?= $object->getCtc01celula3() ?></td>
                        <td><?= $object->getCtc04celula1() ?></td>
                        <td><?= $object->getCtc04celula2() ?></td>
                        <td colspan="2"><?= $object->getCtc04celula3() ?></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td><?= formatValue($object->getCtc01celula1valor()) ?></td>
                        <td><?= formatValue($object->getCtc01celula2valor()) ?></td>
                        <td><?= formatValue($object->getCtc01celula3valor()) ?></td>
                        <td><?= formatValue($object->getCtc04celula1valor()) ?></td>
                        <td><?= formatValue($object->getCtc04celula2valor()) ?></td>
                        <td colspan="2"><?= formatValue($object->getCtc04celula3valor()) ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" id="myTableC2">
                <thead>
                    <tr>    
                        <th colspan="2" style="background-color: #fffdd7;  border: 0;">SALDO TOTAL DOS TANQUES (PCA)</th>     
                        <th style="text-align: right; background-color: #fffdd7; border: 0;">                                
                        </th>
                    </tr>         
                    <tr style="text-align: center">    
                        <th style="width: 50%;">DIESEL</th>                                          
                        <th colspan="2">GASOLINA</th>
                    </tr>
                </thead>
                <tbody> 
                    <tr style="text-align: center">
                        <td style="width: 50%;"><?= formatValue($object->getDiesel()) ?></td>
                        <td colspan="2"><?= formatValue($object->getGasolina()) ?></td>                
                    </tr>
                </tbody>
            </table>            
            <?php
        }
    }
    ?>
    <br>
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTableM');"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTableM');">
        <?php if (isAdminLevel($ADICIONAR_S4)) { ?>
            <a href="../Controller/S4Controller.php?action=material_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar' style="margin-left: 14px;"></a>
        <?php } ?>
        <span style="margin-left: 14px; font-weight: bold;">RELATÓRIO DE MATERIAIS</span>
    </div>
    <form accept-charset="UTF-8" id="filtro" action="../Controller/S4Controller.php?action=getAllList" method="get">
        <input type="hidden" name="action" value="getAllList">            
        <div class="form-row">  
            <div class="col" align="left" style="padding-top: 7px;">   
                <!--<input type="radio" id="solucao" name="solucao" value="todos" onchange="update();" <?= $solucao == "todos" ? " checked" : "" ?>> Exibir todos <input type="radio" id="solucao" name="solucao" value="concluido" onchange="update();" <?= $solucao == "concluido" ? " checked" : "" ?>>Concluídos  <input type="radio" id="solucao" name="solucao" value="emandamento" onchange="update();" <?= $solucao == "emandamento" ? " checked" : "" ?>> Em andamento--> 
            </div>
        </div>                            
    </form>    
    <table class="table table-bordered" id="myTableM">
        <thead>
            <tr>
                <th colspan="7">
                    <div id="contador" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar...">
                </th>
            </tr>
            <tr>    
                <th>Classe</th>
                <th>Item <sup>Marca/Modelo/Ano</sup></th>
                <th>Situação</th>
                <th>Motivo <sup>Informações</sup></th>
                <th>Local</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_S4)) { ?>
                        <a href="../Controller/S4Controller.php?action=material_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTable">   
            <?php if (is_array($materialList) && isAdminLevel($LISTAR_S4)) { ?> 
                <?php foreach ($materialList as $object): ?>
                    <tr style="background-color: <?= $object->getIdSituacao() == 1 ? "#ebffeb;" : "#ffebeb;" ?>">
                        <td><?= $classeDAO->getById($object->getIdClasse())->getClasse() ?></td>
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getMarca(); ?> / <?= $object->getModelo(); ?> / <?= $object->getAno(); ?>"><?= $object->getItem() ?></a></td>        
                        <td style="white-space: nowrap"><span class="alert alert-<?= $object->getIdSituacao() == 1 ? "success" : "danger" ?>"><small><strong><?= $situacaoDAO->getById($object->getIdSituacao())->getSituacao(); ?></strong></small></span></td>
                        <td><?php if ($object->getIdSituacao() != 1) { ?><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getMotivoDetalhado(); ?>"><?= $object->getMotivo() ?></a><?php } ?></td>
                        <td><?= $object->getLocal(); ?></td>
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_S4)) { ?>
                                <a href="../Controller/S4Controller.php?action=material_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_S4)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do material?') ? document.location = '../Controller/S4Controller.php?action=material_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php
            }
            ?>
        </tbody>
    </table>
    <br>       
    <div class="modal fade" id="combustivel" tabindex="-1" role="dialog" aria-labelledby="combustivelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 800px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="combustivelLabel">Mensagem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                  
                    <?php
                    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("S4")->getDataAtualizacaoOriginal()), $hoje);
                    if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 7) {
                        $color = "red";
                        $alert = $dateDif->format('%a') . " dia(s) atrás";
                    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') > 2 && $dateDif->format('%a') < 7) {
                        $color = "darkorange";
                        $alert = $dateDif->format('%a') . " dia(s) atrás";
                    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') <= 2) {
                        $color = "darkgreen";
                        $alert = $dateDif->format('%a') . " dia(s) atrás";
                    }
                    ?>    
                    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("S4")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= empty($secaoDAO->getBySecao("S4")->getDataAtualizacao()) ? "" : $alert; ?></span></h6>
                    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("S4")->getMensagem(); ?></h6>                
                </div>
                <div class="modal-footer">                
                    <form accept-charset="UTF-8" id="formMapaDaForca" action="../Controller/S4Controller.php?action=mensagem_update" method="post">                    
                        <?php if (isAdminLevel($EDITAR_S4)) { ?>                        
                            <textarea name="mensagem" cols="81" placeholder="Mensagem opcional para o Comandante" maxlength="700"><?= $secaoDAO->getBySecao("S4")->getMensagem(); ?></textarea><br>
                            <input type="submit" class="btn btn-primary" value="Atualizar">
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    countRows();
                });
            });
        });

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        if (getCookie("myTableM") === "1") {
            minimize("myTableM");
        }

        if (getCookie("myTableC1") === "1") {
            minimize("myTableC1");
            minimize("myTableC2");
        }

        function countRows() {
            let rowCount = $('#myTable tr:visible').length;
            var message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
            document.getElementById("contador").innerHTML = message;
        }

        countRows();
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <?php
    require_once '../include/footer.php';
    