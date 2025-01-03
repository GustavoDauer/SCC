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
// FILTROS
$idSecao = filter_input(INPUT_GET, "idSecao", FILTER_VALIDATE_INT);
$idNotaCredito = filter_input(INPUT_GET, "idNotaCredito", FILTER_VALIDATE_INT) > 0 ? filter_input(INPUT_GET, "idNotaCredito", FILTER_VALIDATE_INT) : 0;
$ug = filter_input(INPUT_GET, "ug", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
$ne = filter_input(INPUT_GET, "ne", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
$materiaisEntregues = filter_input(INPUT_GET, "materiaisEntregues", FILTER_VALIDATE_INT);
$ano = filter_input(INPUT_GET, "ano", FILTER_VALIDATE_INT);
$notaCreditoAtivas = filter_input(INPUT_GET, "notaCreditoAtivas", FILTER_VALIDATE_INT);
$notaCreditoAtivas = ($notaCreditoAtivas === 0 || $notaCreditoAtivas === 1) ? $notaCreditoAtivas : "";

function formatValue($value) {
    echo "<span style='color:" . ($value <= 0 ? "red" : "green") . "'>$value</span>";
}
?>
<script type="text/javascript" src="../include/js/common.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<style type="text/css">
    .timeline {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style-type: none;
    }

    .timestamp {
        margin-bottom: 2px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #ffcccc;
        font-size: 10px;
    }

    .timestampCompleted {
        margin-bottom: 2px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #00cc00;/*#000;*/
        font-size: 10px;
    }

    .timestampYellow {
        margin-bottom: 2px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #cccc00;
        font-size: 10px;
    }

    .timestampNext {
        margin-bottom: 2px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: red; /*#00cc00;*/
        font-size: 10px;
    }

    .status {
        padding: 0px 4px;
        display: flex;
        justify-content: center;
        border: 1px solid;
        border-radius: 7px;
        border-color: #ffcccc;
        height: 1px;
        /*background-color: #ffcccc;*/
    }

    .statusCompleted {
        padding: 0px 4px;
        display: flex;
        justify-content: center;
        border: 1px solid;
        border-radius: 7px;
        border-color: #00cc00;/*#000;*/
        height: 1px;
        background-color: #ccffcc;
    }

    .statusYellow {
        padding: 0px 4px;
        display: flex;
        justify-content: center;
        border: 2px solid;
        border-radius: 7px;
        border-color: #cccc00;
        height: 1px;
        /*background-color: #ffcccc;*/
    }

    .statusNext {
        padding: 0px 4px;
        display: flex;
        justify-content: center;
        border: 2px solid;
        border-radius: 7px;
        border-color: red; /*#00cc00;*/
        height: 1px;
        /*background-color: #ffcccc;*/
    }

    .status h4 {
        color: white;
        font-weight: bold;
        font-size: 10px;
        margin-top: 7px;
    }

    .statusCompleted h4 {
        color: #00cc00;/*#000;*/
        font-weight: bold;
        font-size: 10px;
        margin-top: 7px;
    }

    .statusYellow h4 {
        color: #cccc00;
        font-weight: normal;
        font-size: 10px;
        margin-top: 7px;
    }

    .statusNext h4 {
        color: red; /*#00cc00;*/
        font-weight: normal;
        font-size: 10px;
        margin-top: 7px;
    }

    .explanation {
        font-size: 12px;
        color: red;
    }
</style>
<div class="conteudo"> 
    <?php

    function checaSituacao($object) {
        $timeline = new Timeline($object);
        $object->setTimeline($timeline);
        $requisitante = $timeline->getRequisitante();
        $salc1 = $timeline->getSalc1();
        $conformidade = $timeline->getConformidade();
        $salc2 = $timeline->getSalc2();
        $almox = $timeline->getAlmox();
        $tesouraria = $timeline->getTesouraria();
        $marcador = "&LongRightArrow;"; //"&FilledSmallSquare;";
        ?>
        <ul class="timeline">
            <li>
                <div class="timestamp<?= $requisitante[0] ?>" id="requisitanteTimestamp">
                    REQ
                </div>
                <div class="status<?= $requisitante[0] ?>" id="requisitanteStatus">
                    <h4><?= $requisitante[0] === "Next" || $requisitante[0] === "Yellow" ? $requisitante[1] : $marcador; ?></h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $salc1[0] ?>" id="salc1Timestamp">
                    SALC
                </div>
                <div class="status<?= $salc1[0] ?>" id="salc1Status">
                    <h4><?= $salc1[0] === "Next" || $salc1[0] === "Yellow" ? $salc1[1] : $marcador; ?></h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $conformidade[0] ?>" id="conformidadeTimestamp">
                    CONF
                </div>
                <div class="status<?= $conformidade[0] ?>" id="conformidadeStatus">
                    <h4><?= $conformidade[0] === "Next" || $conformidade[0] === "Yellow" ? $conformidade[1] : $marcador; ?></h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $salc2[0] ?>" id="salc2Timestamp">
                    SALC
                </div>
                <div class="status<?= $salc2[0] ?>" id="salc2Status">
                    <h4><?= $salc2[0] === "Next" || $salc2[0] === "Yellow" ? $salc2[1] : $marcador; ?></h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $almox[0] ?>" id="almoxarifadoTimestamp">
                    <?= $object->getResponsavel() === "Aprovisionamento" ? "APROV" : "ALMOX" ?>
                </div>
                <div class="status<?= $almox[0] ?>" id="almoxarifadoStatus">
                    <h4><?= $almox[0] === "Next" || $almox[0] === "Yellow" ? $almox[1] : $marcador; ?></h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $tesouraria[0] ?>" id="tesourariaTimestamp">
                    TESO
                </div>
                <div class="status<?= $tesouraria[0] ?>" id="tesourariaStatus">
                    <h4><?= $tesouraria[0] === "Next" || $tesouraria[0] === "Yellow" ? $tesouraria[1] : "FIM"; ?></h4>
                </div>
            </li>
        </ul>
        <?php
    }

    // Verificações de datas e atualizações de datas
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacaoOriginal()), $hoje);
    $alert = "";
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
    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <div style="margin-top: 7px;margin-left: 7px; font-size: 11px;">
        <?php if (isAdminLevel($LISTAR_CATEGORIA)) { ?>
            <a href="../Controller/CategoriaController.php?action=getAllList">                            
                <img src="../include/imagens/gerenciar_categorias.jpg" width="25" height="25" hspace="2" vspace="2"> Categorias
            </a> |
        <?php } ?>
    </div>
    <!--    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getMensagem(); ?></h6>
        <div align="left">                        
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mensagem">Editar mensagem</button>
        </div>        
        <br>    -->
</div>
<div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
    <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('requisicoes');"> 
    <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('requisicoes');">        
    <span style="margin-left: 14px; font-weight: bold;">REQUISIÇÕES</span>
</div>
<br>
<div style="width:99%;margin: 0 auto">                                         
    <table class="table table-bordered" id="requisicoes">
        <thead>            
            <tr>
                <th colspan="25">
                    <div align="center">
                        <form accept-charset="UTF-8" id="filtro" action="../Controller/FiscalizacaoController.php?action=getAllList" method="get">
                            <input type="hidden" name="action" value="getAllList">            
                            <div class="form-row">    
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <select class="form-control" name="ano" onchange="update();">
                                        <option disabled selected>Filtrar por ano</option>
                                        <?php
                                        for ($i = 2021; $i <= date('Y'); $i++) {
                                            ?>
                                            <option <?= $ano === $i ? "selected" : "" ?>><?= $i ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <select class="form-control" name="idSecao" onchange="update();">
                                        <option disabled selected>Filtrar por seção</option>
                                        <?php
                                        if (!empty($secaoList) && $secaoList != null) {
                                            foreach ($secaoList as $secao) {
                                                ?>
                                                <option value="<?= $secao->getId() ?>" <?= $idSecao == $secao->getId() ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <select class="form-control" name="idNotaCredito" onchange="update();">
                                        <option disabled selected>Filtrar por Nota de crédito</option>
                                        <?php
                                        $notaCreditoSelectList = $notaCreditoDAO->getAllList();
                                        $notaCredito = new NotaCredito();
                                        $idNotaCredito = 0;
                                        if (!empty($notaCreditoSelectList) && $notaCreditoSelectList != null) {
                                            foreach ($notaCreditoSelectList as $notaCredito) {
                                                ?>
                                                <option value="<?= $notaCredito->getId() ?>" <?= $idNotaCredito == $notaCredito->getId() ? "selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                                <?php
                                            }
                                        } else {
                                            $notaCreditoSelectList = $notaCreditoDAO->getAllList(array("notaCreditoAtivas" => 0));
                                            if (!empty($notaCreditoSelectList) && $notaCreditoSelectList != null) {
                                                foreach ($notaCreditoSelectList as $notaCredito) {
                                                    ?>
                                                    <option value="<?= $notaCredito->getId(); ?>" <?= $notaCredito->getId() == $idNotaCredito ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>                                        
                                    </select>
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;" onchange="update();">   
                                    <select class="form-control" name="ug" id="ug">
                                        <option disabled selected>Filtrar por UG da NC</option>
                                        <option <?= $ug == "160477" ? "selected" : "" ?>>160477</option>
                                        <option <?= $ug == "167477" ? "selected" : "" ?>>167477</option>
                                    </select>
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <input type="text" class="form-control" id="ne" placeholder="Filtrar por nota de empenho" name="ne" maxlength="12" onkeypress="return event.charCode === 78 || event.charCode === 69 || (event.charCode >= 48 && event.charCode <= 57);" onblur="update();" value="<?= $ne ?>" />
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <input type="radio" id="materiaisEntregues" name="materiaisEntregues" value="1" onclick="update();" <?= $materiaisEntregues === 1 ? "checked" : "" ?> /> Entregues <br><input type="radio" id="materiaisEntregues" name="materiaisEntregues" value="0" onclick="update();" <?= $materiaisEntregues === 0 ? "checked" : "" ?> /> Não entregues
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <a href="../Controller/FiscalizacaoController.php?action=getAllList">Remover filtros</a>
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#informacoes">Informações!</button>
                                </div>                                
                                <div id="informacoes" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-lg">                                        
                                        <div class="modal-content">
                                            <div class="modal-header" align="center">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info" style="text-align: justify; font-weight:normal;">
                                                    <strong>INFORMAÇÕES!</strong>
                                                    <hr>
                                                    <ol>
                                                        <li>A Seção REQUISITANTE cadastra a REQUISIÇÃO, encaminhando o processo à SALC;</li>
                                                        <li>A SALC realiza o empenho;</li>
                                                        <li>A CONFORMIDADE emite o parecer e despacha com o OD para assinatura do Empenho;</li>
                                                        <li>A SALC envia a Nota de Empenho ao ALMOXARIFADO;</li>
                                                        <li>O ALMOXARIFADO envia a Nota de Empenho à Empresa e realiza o controle da entrega do material. Caso não tenha recebido, passado-se o prazo estipulado após envio da Nota de Empenho, o ALMOXARIFADO notifica a empresa através de Ofício. Passado-se o prazo estipulado no Ofício, sem recebimento do material, o ALMOXARIFADO solicita a abertura de Processo Administrativo;</li>
                                                        <li>A TESOURARIA, após o recebimento do material pelo ALMOXARIFADO e remessa do processo à TESOURARIA, faz a Liquidação da Nota de Empenho;</li>
                                                    </ol>
                                                    A Situação da REQUISIÇÃO será calculada pelo sistema com base no fluxo de informações que são fornecidos no decorrer do tempo de vida da REQUISIÇÃO, que passa a condição de LIQUIDADA, após preenchimento pela TESOURARIA do valor liquidado.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </th>
            </tr>
            <tr>
                <th>UG NC</th>
                <th>OM/Seção</th>                   
                <th>NE <sup>NC</sup></th>
                <th>Data NE</th>
                <th>Valor NE</th>
                <th>Empresa</th>                
                <th>Situação</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_FISCALIZACAO)) { ?>
                        <a href="../Controller/FiscalizacaoController.php?action=insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>        
        <tbody>
            <?php
            if (is_array($objectList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                foreach ($objectList as $object) {
                    ?> 
                    <tr style="height: 95px;">
                        <td><?= $object->getIdNotaCredito() > 0 ? $notaCreditoDAO->getById($object->getIdNotaCredito())->getUg() : "" ?></td>
                        <td><?= $object->getOm() . " / " . $object->getIdSecao() > 0 ? $secaoDAO->getById($object->getIdSecao())->getSecao() : ""; ?> </td>                  
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getIdNotaCredito() > 0 ? $notaCreditoDAO->getById($object->getIdNotaCredito())->getNc() : $object->getIdNotaCredito() ?>"><?= $object->getNe() ?></a></td>
                        <td><?= dateFormat($object->getDataNE()) ?></td>                        
                        <td>R$ <?= number_format($object->getValorNE(), 2, ",", ".") ?></td>                        
                        <td><?= $object->getEmpresa() ?></td>                        
                        <td style="white-space: nowrap;"><?= checaSituacao($object); ?></td>
                        <td style="white-space: nowrap;">
                            <?php if (isAdminLevel($EDITAR_FISCALIZACAO)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_FISCALIZACAO)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=delete&id=<?= $object->getId() ?>"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>               
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>    
</div>
<div  class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
    <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('notasCredito');"> 
    <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('notasCredito');">        
    <span style="margin-left: 14px; font-weight: bold;">NOTAS DE CRÉDITO</span>
</div>
<br>
<div style="width:99%;margin: 0 auto">                                         
    <table class="table table-bordered" id="notasCredito">
        <thead>
            <tr>
                <th colspan="25">
                    <div align="center">
                        <form accept-charset="UTF-8" id="filtroNC" action="../Controller/FiscalizacaoController.php?action=getAllList" method="get">
                            <input type="hidden" name="action" value="getAllList">            
                            <div class="form-row">                                                                    
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <input type="radio" id="notaCreditoAtivas" name="notaCreditoAtivas" value="1" onclick="update('filtroNC');" <?= $notaCreditoAtivas === 1 ? "checked" : "" ?> /> Com saldo <br><input type="radio" id="notaCreditoAtivas" name="notaCreditoAtivas" value="0" onclick="update('filtroNC');" <?= $notaCreditoAtivas === 0 ? "checked" : "" ?> /> Sem saldo
                                </div>
                                <div class="col" align="left" style="padding-top: 7px;">   
                                    <a href="../Controller/FiscalizacaoController.php?action=getAllList">Remover filtros</a>
                                </div>                                                                                     
                            </div>                            
                        </form>
                    </div>
                </th>
                <th colspan="25">                    
                    <div id="contador" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                </th>
            </tr>
            <tr>
                <th>Data NC</th>   
                <th>Nota de Crédito</th>
                <th>PI</th>
                <th>Valor</th>
                <th>Total Empenhado</th>
                <th>Gestor NC</th>                             
                <th>PTRes</th>
                <th>Fonte</th>
                <th>UG</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_FISCALIZACAO_NC)) { ?>
                        <a href="../Controller/FiscalizacaoController.php?action=insert_nc"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>        
        <tbody>
            <?php
            if (is_array($notaCreditoList) && isAdminLevel($LISTAR_FISCALIZACAO_NC)) {
                foreach ($notaCreditoList as $object) {
                    $totalEmpenhado = number_format($object->getTotalEmpenhado(), 2, ",", ".");
                    ?> 
                    <tr>
                        <td><?= dateFormat($object->getDataNc()) ?></td>
                        <td><?= $object->getNc() ?></td>
                        <td><?= $object->getPi() ?></td>
                        <td>R$ <?= $object->getValor() ?></td>
                        <td><?= $totalEmpenhado >= $object->getValor() ? "<span style='color: red;font-weight: bold;'>R$ $totalEmpenhado</span>" : "<span style='color: green;font-weight: bold;'>R$ $totalEmpenhado</span>" ?></td>
                        <td><?= $object->getGestorNc() ?></td>
                        <td><?= $object->getPtres() ?></td>
                        <td><?= $object->getFonte() ?></td>
                        <td><?= $object->getUg() ?></td>                        
                        <td>
                            <?php if (isAdminLevel($EDITAR_FISCALIZACAO_NC)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=update_nc&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_FISCALIZACAO_NC)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=delete_nc&id=<?= $object->getId() ?>"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>               
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="mensagem" tabindex="-1" role="dialog" aria-labelledby="mensagemLabel" aria-hidden="true">
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
                $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacaoOriginal()), $hoje);
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
                <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= empty($secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacao()) ? "" : $alert; ?></span></h6>
                <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getMensagem(); ?></h6>                
            </div>
            <div class="modal-footer">                
                <form accept-charset="UTF-8" id="formAgenda" action="../Controller/FiscalizacaoController.php?action=mensagem_update" method="post">                    
                    <?php if (isAdminLevel($EDITAR_FISCALIZACAO)) { ?>                        
                        <textarea name="mensagem" cols="81" placeholder="Mensagem opcional para o Comandante" maxlength="700"><?= $secaoDAO->getBySecao("Fiscalizacao")->getMensagem(); ?></textarea><br>
                        <input type="submit" class="btn btn-primary" value="Atualizar">
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
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
        $('[name=ne]').mask('0000NE000000');
    });
</script>
<?php
require_once '../include/footer.php';
