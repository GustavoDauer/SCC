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
$solucao = filter_input(INPUT_GET, "solucao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$hoje = new DateTime();
?>
<script type="text/javascript" src="../include/js/common.js"></script>
<script type="text/javascript">
    function minimizeMapaDaForca() {
        minimize('mapaDaForcaOficiais');
        minimize('mapaDaForcaStsgt');
        minimize('mapaDaForcaCbsd');
        minimize('mapaDaForcaEncostado');
        minimize('mapaDaForcaTotais');
        minimize('mapaDaForcaPttc');
    }

    function maximizeMapaDaForca() {
        maximize('mapaDaForcaOficiais');
        maximize('mapaDaForcaStsgt');
        maximize('mapaDaForcaCbsd');
        maximize('mapaDaForcaEncostado');
        maximize('mapaDaForcaTotais');
        maximize('mapaDaForcaPttc');
    }
</script>
<style type="text/css">
    .encostado {
        color: gray;
    }

    .positivo {
        color: green;
    }

    .negativo {
        color: red;
    }

    .neutro {
        color: blue;
    }

    .destaque {
        background-color: lightyellow;
        font-weight: bold;
    }

    .primeiraColuna {
        width: 125px;
    }

    .ultimaColuna {
        width: 205px;
    }

    #mapaDaForcaOficiais th {
        text-align: center;
    }

    #mapaDaForcaOficiais td {
        text-align: center;
    }

    #mapaDaForcaStsgt th {
        text-align: center;
    }

    #mapaDaForcaStsgt td {
        text-align: center;
    }

    #mapaDaForcaCbsd th {
        text-align: center;
    }

    #mapaDaForcaCbsd td {
        text-align: center;
    }

    #mapaDaForcaPttc th {
        text-align: center;
    }

    #mapaDaForcaPttc td {
        text-align: center;
    }
</style>
<?php

function check($previsto, $existente) {
    if ($previsto > $existente)
        return "negativo";
    else if ($previsto < $existente)
        return "positivo";
    return "neutro";
}

function contaCheck($previsto, $existente) {
    $resultado = $previsto - $existente;
    if ($resultado > 0) {
        $classe = "negativo";
        echo "<sub class='$classe'>-" . abs($resultado) . "</sub>";
    } else if ($resultado < 0) {
        $classe = "positivo";
        echo "<sup class='$classe'>+" . abs($resultado) . "</sup>";
    }
}
?>
<div class="conteudo">              
    <br>
    <?php
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("S1")->getDataAtualizacaoOriginal()), $hoje);
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
    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("S1")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("S1")->getMensagem(); ?></h6>
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimizeMapaDaForca()"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximizeMapaDaForca()">
<?php if (isAdminLevel($EDITAR_S1)) { ?>
            <span style="text-align: right;">
                <a href="../Controller/S1Controller.php?action=mapaDaForca_update"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar' style="margin-left: 14px;"></a>
            </span>                                   
<?php } ?>
        <span style="margin-left: 14px; font-weight: bold;">MAPA DA FORÇA</span>
    </div>
    <?php if (is_array($mapaDaForcaList) && isAdminLevel($LISTAR_S1)) { ?> 
        <?php foreach ($mapaDaForcaList as $object): ?>
            <?php
            $totalPrevistoOficiais = $object->getCel_previsto() +
                    $object->getTc_previsto() +
                    $object->getMaj_previsto() +
                    $object->getCap_previsto() +
                    $object->getTen1_previsto() +
                    $object->getTen2_previsto() +
                    $object->getAspof_previsto();
            $totalExistenteOficiais = $object->getCel_existente() +
                    $object->getTc_existente() +
                    $object->getMaj_existente() +
                    $object->getCap_existente() +
                    $object->getTen1_existente() +
                    $object->getTen2_existente() +
                    $object->getAspof_existente();
            $totalAdidoOficiais = $object->getCel_adido() +
                    $object->getTc_adido() +
                    $object->getMaj_adido() +
                    $object->getCap_adido() +
                    $object->getTen1_adido() +
                    $object->getTen2_adido() +
                    $object->getAspof_adido();
            $totalPrevistoStsgt = $object->getSten_previsto() +
                    $object->getSgt1_previsto() +
                    $object->getSgt2_previsto() +
                    $object->getSgt3_previsto();
            $totalExistenteStsgt = $object->getSten_existente() +
                    $object->getSgt1_existente() +
                    $object->getSgt2_existente() +
                    $object->getSgt3_existente();
            $totalAdidoStsgt = $object->getSten_adido() +
                    $object->getSgt1_adido() +
                    $object->getSgt2_adido() +
                    $object->getSgt3_adido();
            $totalPrevistoCbsd = $object->getCb_previsto() +
                    $object->getCbev_previsto() +
                    $object->getSdep_previsto() +
                    $object->getSdev_previsto();
            $totalExistenteCbsd = $object->getCb_existente() +
                    $object->getCbev_existente() +
                    $object->getSdep_existente() +
                    $object->getSdev_existente();
            $totalAdidoCbsd = $object->getCb_adido() +
                    $object->getCbev_adido() +
                    $object->getSdep_adido() +
                    $object->getSdev_adido();
            $totalPrevistoPttc = $object->getCap_pttc_previsto() +
                    $object->getTen1_pttc_previsto() +
                    $object->getTen2_pttc_previsto() +
                    $object->getSten_pttc_previsto() +
                    $object->getSgt1_pttc_previsto() +
                    $object->getSgt2_pttc_previsto();
            $totalExistentePttc = $object->getCap_pttc_existente() +
                    $object->getTen1_pttc_existente() +
                    $object->getTen2_pttc_existente() +
                    $object->getSten_pttc_existente() +
                    $object->getSgt1_pttc_existente() +
                    $object->getSgt2_pttc_existente();
            $totalAdidoPttc = $object->getCap_pttc_adido() +
                    $object->getTen1_pttc_adido() +
                    $object->getTen2_pttc_adido() +
                    $object->getSten_pttc_adido() +
                    $object->getSgt1_pttc_adido() +
                    $object->getSgt2_pttc_adido();
            ?>
            <table class="table table-bordered" id="mapaDaForcaOficiais">                
                <tbody>
                    <tr class="destaque">
                        <td class="primeiraColuna">OFICIAIS</td>
                        <td>Cel</td>
                        <td>TC</td>
                        <td>Maj</td>
                        <td>Cap</td>
                        <td>1º Ten</td>
                        <td>2º Ten</td>
                        <td>Asp Of</td>
                        <td class="ultimaColuna">TOTAL</td>
                    </tr>
                    <tr>                
                        <td>
                            PREVISTO
                        </td>   
                        <td class="<?= check($object->getCel_previsto(), $object->getCel_existente()) ?>"><?= $object->getCel_previsto() ?></td> <!-- Cel -->
                        <td class="<?= check($object->getTc_previsto(), $object->getTc_existente()) ?>"><?= $object->getTc_previsto() ?></td> <!-- TC -->
                        <td class="<?= check($object->getMaj_previsto(), $object->getMaj_existente()) ?>"><?= $object->getMaj_previsto() ?></td> <!-- Maj -->
                        <td class="<?= check($object->getCap_previsto(), $object->getCap_existente()) ?>"><?= $object->getCap_previsto() ?></td> <!-- Cap -->
                        <td class="<?= check($object->getTen1_previsto(), $object->getTen1_existente()) ?>"><?= $object->getTen1_previsto() ?></td> <!-- 1º Ten -->
                        <td class="<?= check($object->getTen2_previsto(), $object->getTen2_existente()) ?>"><?= $object->getTen2_previsto() ?></td> <!-- 2º Ten -->
                        <td class="<?= check($object->getAspof_previsto(), $object->getAspof_existente()) ?>"><?= $object->getAspof_previsto() ?></td> <!-- Asp Of -->
                        <td>
        <?= $totalPrevistoOficiais ?>
                        </td>
                    </tr> 
                    <tr>                
                        <td class="primeiraColuna">
                            EXISTENTE
                        </td>   
                        <td class="<?= check($object->getCel_previsto(), $object->getCel_existente()) ?>">
        <?= $object->getCel_existente() ?> <?= contaCheck($object->getCel_previsto(), $object->getCel_existente()); ?>
                        </td> <!-- Cel -->
                        <td class="<?= check($object->getTc_previsto(), $object->getTc_existente()) ?>">
        <?= $object->getTc_existente() ?> <?= contaCheck($object->getTc_previsto(), $object->getTc_existente()); ?>
                        </td> <!-- TC -->
                        <td class="<?= check($object->getMaj_previsto(), $object->getMaj_existente()) ?>">
        <?= $object->getMaj_existente() ?> <?= contaCheck($object->getMaj_previsto(), $object->getMaj_existente()); ?>
                        </td> <!-- Maj -->
                        <td class="<?= check($object->getCap_previsto(), $object->getCap_existente()) ?>">
        <?= $object->getCap_existente() ?> <?= contaCheck($object->getCap_previsto(), $object->getCap_existente()); ?>
                        </td> <!-- Cap -->
                        <td class="<?= check($object->getTen1_previsto(), $object->getTen1_existente()) ?>">
        <?= $object->getTen1_existente() ?> <?= contaCheck($object->getTen1_previsto(), $object->getTen1_existente()); ?>
                        </td> <!-- 1º Ten -->
                        <td class="<?= check($object->getTen2_previsto(), $object->getTen2_existente()) ?>">
        <?= $object->getTen2_existente() ?> <?= contaCheck($object->getTen2_previsto(), $object->getTen2_existente()); ?>
                        </td> <!-- 2º Ten -->
                        <td class="<?= check($object->getAspof_previsto(), $object->getAspof_existente()) ?>">
        <?= $object->getAspof_existente() ?> <?= contaCheck($object->getAspof_previsto(), $object->getAspof_existente()); ?>
                        </td> <!-- Asp Of -->
                        <td>
        <?= $totalExistenteOficiais ?> <small>+<?= $totalAdidoOficiais ?> adidos</small> = <?= $totalExistenteOficiais + $totalAdidoOficiais ?>
                        </td>
                    </tr>
                    <tr>                
                        <td>
                            ADIDOS
                        </td>                        
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getCel_adidoTexto() ?>"><?= $object->getCel_adido() ?></a></td> <!-- Cel -->
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getTc_adidoTexto() ?>"><?= $object->getTc_adido() ?></a></td>  <!-- TC --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getMaj_adidoTexto() ?>"><?= $object->getMaj_adido() ?></a></td> <!-- Maj --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getCap_adidoTexto() ?>"><?= $object->getCap_adido() ?></a></td>  <!-- Cap --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getTen1_adidoTexto() ?>"><?= $object->getTen1_adido() ?></a></td>  <!-- 1º Ten --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getTen2_adidoTexto() ?>"><?= $object->getTen2_adido() ?></a></td>  <!-- 2º Ten --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getAspof_adidoTexto() ?>"><?= $object->getAspof_adido() ?></a></td>  <!-- Asp Of -->
                        <td>
        <?= $totalAdidoOficiais ?>
                        </td>
                    </tr>
                </tbody>
            </table>                    
            <table class="table table-bordered" id="mapaDaForcaStsgt">
                <tbody>
                    <tr class="destaque">
                        <td class="primeiraColuna">S TEN / SGT</td>
                        <td>S Ten</td>
                        <td>1º Sgt</td>
                        <td>2º Sgt</td>
                        <td>3º Sgt</td>      
                        <td class="ultimaColuna">TOTAL</td>
                    </tr>
                    <tr>                
                        <td>
                            PREVISTO
                        </td>   
                        <td class="<?= check($object->getSten_previsto(), $object->getSten_existente()) ?>"><?= $object->getSten_previsto() ?></td> <!-- S Ten -->
                        <td class="<?= check($object->getSgt1_previsto(), $object->getSgt1_existente()) ?>"><?= $object->getSgt1_previsto() ?></td> <!-- 1º Sgt -->
                        <td class="<?= check($object->getSgt2_previsto(), $object->getSgt2_existente()) ?>"><?= $object->getSgt2_previsto() ?></td> <!-- 2º Sgt -->
                        <td class="<?= check($object->getSgt3_previsto(), $object->getSgt3_existente()) ?>"><?= $object->getSgt3_previsto() ?></td> <!-- 3º Sgt -->     
                        <td>
        <?= $totalPrevistoStsgt ?>
                        </td>
                    </tr>  
                    <tr>                
                        <td>
                            EXISTENTE
                        </td>   
                        <td class="<?= check($object->getSten_previsto(), $object->getSten_existente()) ?>">
        <?= $object->getSten_existente() ?> <?= contaCheck($object->getSten_previsto(), $object->getSten_existente()); ?>
                        </td> <!-- S Ten -->
                        <td class="<?= check($object->getSgt1_previsto(), $object->getSgt1_existente()) ?>">
        <?= $object->getSgt1_existente() ?> <?= contaCheck($object->getSgt1_previsto(), $object->getSgt1_existente()); ?>
                        </td> <!-- 1º Sgt -->
                        <td class="<?= check($object->getSgt2_previsto(), $object->getSgt2_existente()) ?>">
        <?= $object->getSgt2_existente() ?> <?= contaCheck($object->getSgt2_previsto(), $object->getSgt2_existente()); ?>
                        </td> <!-- 2º Sgt -->
                        <td class="<?= check($object->getSgt3_previsto(), $object->getSgt3_existente()) ?>">
        <?= $object->getSgt3_existente() ?> <?= contaCheck($object->getSgt3_previsto(), $object->getSgt3_existente()); ?>
                        </td> <!-- 3º Sgt -->     
                        <td>
        <?= $totalExistenteStsgt ?> <small>+<?= $totalAdidoStsgt ?> adidos</small> = <?= $totalExistenteStsgt + $totalAdidoStsgt ?>
                        </td>
                    </tr>
                    <tr>                
                        <td>
                            ADIDOS
                        </td>                        
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSten_adidoTexto() ?>"><?= $object->getSten_adido() ?></a></td> <!-- S Ten -->
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSgt1_adidoTexto() ?>"><?= $object->getSgt1_adido() ?></a></td> <!-- 1º Sgt -->
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSgt2_adidoTexto() ?>"><?= $object->getSgt2_adido() ?></a></td> <!-- 2º Sgt -->
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSgt3_adidoTexto() ?>"><?= $object->getSgt3_adido() ?></a></td> <!-- 3º Sgt --> 
                        <td>
        <?= $totalAdidoStsgt ?>
                        </td>
                    </tr>                                                         
                </tbody>   
            </table>                                         
            <table class="table table-bordered" id="mapaDaForcaCbsd">
                <tbody>
                    <tr class="destaque">
                        <td class="primeiraColuna">CB / SD</td>
                        <td>Cb</td>
                        <td>Cb EV</td>
                        <td>Sd EP</td>
                        <td>Sd EV</td>     
                        <td class="ultimaColuna">TOTAL</td>
                    </tr>
                    <tr>                
                        <td>
                            PREVISTO
                        </td>   
                        <td class="<?= check($object->getCb_previsto(), $object->getCb_existente()) ?>"><?= $object->getCb_previsto() ?> <small style="color: black;">(QCP 78)</small></td> <!-- Cb -->
                        <td class="<?= check($object->getCbev_previsto(), $object->getCbev_existente()) ?>"><?= $object->getCbev_previsto() ?></td> <!-- Cb EV -->
                        <td class="<?= check($object->getSdep_previsto(), $object->getSdep_existente()) ?>"><?= $object->getSdep_previsto() ?> <small style="color: black;">(QCP 121)</small></td> <!-- Sd EP -->
                        <td class="<?= check($object->getSdev_previsto(), $object->getSdev_existente()) ?>"><?= $object->getSdev_previsto() ?></td> <!-- Sd EV -->    
                        <td>
        <?= $totalPrevistoCbsd ?>
                        </td>
                    </tr>    
                    <tr>                
                        <td>
                            EXISTENTE
                        </td>   
                        <td class="<?= check($object->getCb_previsto(), $object->getCb_existente()) ?>">
        <?= $object->getCb_existente() ?> <?= contaCheck($object->getCb_previsto(), $object->getCb_existente()); ?>
                        </td> <!-- Cb -->
                        <td class="<?= check($object->getCbev_previsto(), $object->getCbev_existente()) ?>">
        <?= $object->getCbev_existente() ?> <?= contaCheck($object->getCbev_previsto(), $object->getCbev_existente()); ?>
                        </td> <!-- Cb EV -->
                        <td class="<?= check($object->getSdep_previsto(), $object->getSdep_existente()) ?>">
        <?= $object->getSdep_existente() ?> <?= contaCheck($object->getSdep_previsto(), $object->getSdep_existente()); ?>
                        </td> <!-- Sd EP -->
                        <td class="<?= check($object->getSdev_previsto(), $object->getSdev_existente()) ?>">
        <?= $object->getSdev_existente() ?> <?= contaCheck($object->getSdev_previsto(), $object->getSdev_existente()); ?>
                        </td> <!-- Sd EV -->      
                        <td>
        <?= $totalExistenteCbsd ?> <small>+<?= $totalAdidoCbsd ?> adidos</small> = <?= $totalExistenteCbsd + $totalAdidoCbsd ?>
                        </td>
                    </tr>
                    <tr>                
                        <td>
                            ADIDOS
                        </td>                        
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getCb_adidoTexto() ?>"><?= $object->getCb_adido() ?></a></td>  <!-- Cb --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getCbev_adidoTexto() ?>"><?= $object->getCbev_adido() ?></a></td>  <!-- Cb EV --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSdep_adidoTexto() ?>"><?= $object->getSdep_adido() ?></a></td>  <!-- Sd EP --> 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSdev_adidoTexto() ?>"><?= $object->getSdev_adido() ?></a></td>  <!-- Sd EV -->  
                        <td>
        <?= $totalAdidoCbsd ?>
                        </td>
                    </tr>  
                </tbody>
            </table>            
            <table class="table table-bordered" id="mapaDaForcaPttc">                
                <tbody>
                    <tr class="destaque">
                        <td class="primeiraColuna">PTTC</td>                        
                        <td>Cap</td>
                        <td>1º Ten</td>
                        <td>2º Ten</td>
                        <td>S Ten</td>
                        <td>1º Sgt</td>
                        <td>2º Sgt</td>
                        <td class="ultimaColuna">TOTAL</td>
                    </tr>
        <!--                    <tr>                
                        <td>
                            PREVISTO
                        </td>   
                        <td class="<?= check($object->getCap_pttc_previsto(), $object->getCap_pttc_existente()) ?>"><?= $object->getCap_pttc_previsto() ?></td>  Cap 
                        <td class="<?= check($object->getTen1_pttc_previsto(), $object->getTen1_pttc_existente()) ?>"><?= $object->getTen1_pttc_previsto() ?></td>  1º Ten 
                        <td class="<?= check($object->getTen2_pttc_previsto(), $object->getTen2_pttc_existente()) ?>"><?= $object->getTen2_pttc_previsto() ?></td>  2º Ten 
                        <td class="<?= check($object->getSten_pttc_previsto(), $object->getSten_pttc_existente()) ?>"><?= $object->getSten_pttc_previsto() ?></td>  S Ten 
                        <td class="<?= check($object->getSgt1_pttc_previsto(), $object->getSgt1_pttc_existente()) ?>"><?= $object->getSgt1_pttc_previsto() ?></td>  1º Sgt 
                        <td class="<?= check($object->getSgt2_pttc_previsto(), $object->getSgt2_pttc_existente()) ?>"><?= $object->getSgt2_pttc_previsto() ?></td>  2º Sgt                         
                        <td>
        <?= $totalPrevistoPttc ?>
                        </td>
                    </tr> -->
                    <tr>                
                        <td>
                            EXISTENTE
                        </td>   
                        <td class="<?= check($object->getCap_pttc_previsto(), $object->getCap_pttc_existente()) ?>">
        <?= $object->getCap_pttc_existente() ?> <?= contaCheck($object->getCap_pttc_previsto(), $object->getCap_pttc_existente()); ?>
                        </td> <!-- Cap -->
                        <td class="<?= check($object->getTen1_pttc_previsto(), $object->getTen1_pttc_existente()) ?>">
        <?= $object->getTen1_pttc_existente() ?> <?= contaCheck($object->getTen1_pttc_previsto(), $object->getTen1_pttc_existente()); ?>
                        </td> <!-- 1º Ten -->
                        <td class="<?= check($object->getTen2_pttc_previsto(), $object->getTen2_pttc_existente()) ?>">
        <?= $object->getTen2_pttc_existente() ?> <?= contaCheck($object->getTen2_pttc_previsto(), $object->getTen2_pttc_existente()); ?>
                        </td> <!-- 2º Ten -->                        
                        <td class="<?= check($object->getSten_pttc_previsto(), $object->getSten_pttc_existente()) ?>">
        <?= $object->getSten_pttc_existente() ?> <?= contaCheck($object->getSten_pttc_previsto(), $object->getSten_pttc_existente()); ?>
                        </td> <!-- S Ten -->
                        <td class="<?= check($object->getSgt1_pttc_previsto(), $object->getSgt1_pttc_existente()) ?>">
        <?= $object->getSgt1_pttc_existente() ?> <?= contaCheck($object->getSgt1_pttc_previsto(), $object->getSgt1_pttc_existente()); ?>
                        </td> <!-- 1º Sgt -->
                        <td class="<?= check($object->getSgt2_pttc_previsto(), $object->getSgt2_pttc_existente()) ?>">
        <?= $object->getSgt2_pttc_existente() ?> <?= contaCheck($object->getSgt2_pttc_previsto(), $object->getSgt2_pttc_existente()); ?>
                        </td> <!-- 2º Sgt -->
                        <td>
        <?= $totalExistentePttc ?> <!--<small>+<?= $totalAdidoPttc ?> adidos</small> = <?= $totalExistentePttc + $totalAdidoPttc ?>-->
                        </td>
                    </tr>
        <!--                    <tr>                
                        <td>
                            ADIDOS
                        </td>                        
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getCap_pttc_adidoTexto() ?>"><?= $object->getCap_pttc_adido() ?></a></td>  Cap 
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getTen1_pttc_adidoTexto() ?>"><?= $object->getTen1_pttc_adido() ?></a></td>   1º Ten  
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getTen2_pttc_adidoTexto() ?>"><?= $object->getTen2_pttc_adido() ?></a></td>   2º Ten  
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSten_pttc_adidoTexto() ?>"><?= $object->getSten_pttc_adido() ?></a></td>   S Ten  
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getSgt1_pttc_adidoTexto() ?>"><?= $object->getSgt1_pttc_adido() ?></a></td>   1º Sgt  
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getTen2_pttc_adidoTexto() ?>"><?= $object->getTen2_pttc_adido() ?></a></td>   2º Sgt                          
                        <td>
        <?= $totalAdidoPttc ?>
                        </td>
                    </tr>-->
                </tbody>
            </table>
            <table class="table table-bordered" id="mapaDaForcaTotais">
                <tbody>
                    <tr>                
                        <th style="text-align: right;">
                            TOTAL EFETIVO
                        </th>                          
                        <td class="ultimaColuna">
        <?= $totalExistenteOficiais + $totalExistenteStsgt + $totalExistenteCbsd ?>
                            <small>+<?= $totalAdidoOficiais + $totalAdidoStsgt + $totalAdidoCbsd ?> adidos</small> = <?= $totalExistenteOficiais + $totalExistenteStsgt + $totalExistenteCbsd + $totalAdidoOficiais + $totalAdidoStsgt + $totalAdidoCbsd ?>
                        </td>
                    </tr>
                </tbody>  
            </table>
            <table class="table table-bordered" id="mapaDaForcaEncostado">
                <tbody>
                    <tr class="encostado">                
                        <th class="primeiraColuna" style="text-align: right;">
                            <a href="../Controller/FSController.php?action=getAllList">ENCOSTADOS</a>
                        </th>                        
                        <td><a href="../Controller/FSController.php?action=getAllList"><?= $object->getEncostados() ?></a></td>                        
                    </tr>
                    <tr class="encostado">                
                        <th class="primeiraColuna" style="text-align: right;">
                            <a href="../Controller/FSController.php?action=getAllList">AGREGADOS</a>
                        </th>                        
                        <td><a href="../Controller/FSController.php?action=getAllList"><?= $object->getAgregados() ?></a></td>                        
                    </tr>
                </tbody>  
            </table>                                                       
            <?php
        endforeach;
    }
    ?>
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('juridico');"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('juridico');">        
        <span style="margin-left: 14px; font-weight: bold;">JURÍDICO</span>
    </div>    
    <table class="table table-bordered" id="juridico">
        <thead>
            <tr>
                <th colspan="7">
                    <div align="center">
                        <form accept-charset="UTF-8" id="filtro" action="../Controller/S1Controller.php?action=getAllList" method="get">
                            <input type="hidden" name="action" value="getAllList">            
                            <div class="form-row">  
                                <div class="col-4" align="left">                                                
                                </div>
                                <div class="col-8" align="left" style="padding-top: 7px;">   
                                    <input type="radio" id="solucao" name="solucao" value="todos" onchange="update();" <?= $solucao == "todos" ? " checked" : "" ?>> Exibir todos <input type="radio" id="solucao" name="solucao" value="concluido" onchange="update();" <?= $solucao == "concluido" ? " checked" : "" ?>> Concluídos  <input type="radio" id="solucao" name="solucao" value="emandamento" onchange="update();" <?= $solucao == "emandamento" ? " checked" : "" ?>> Em andamento <input type="radio" id="solucao" name="solucao" value="protocolado" onchange="update();" <?= $solucao == "protocolado" ? " checked" : "" ?>> Protocolados
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar...">
                    <div id="contador" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                </th>
            </tr>
            <tr>                
                <th>Portaria <sup>Tipo</sup></th>
                <th>Responsável</th>
                <th>Início / Prorrogação / Fim</th>                                  
                <th>
                    <?php if (isAdminLevel($ADICIONAR_JURIDICO)) { ?>
                        <a href="../Controller/S1Controller.php?action=processo_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
<?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTable">   
            <?php if (is_array($objectList) && isAdminLevel($LISTAR_JURIDICO)) { ?> 
    <?php foreach ($objectList as $object): ?>
                    <tr>
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getAssunto(); ?>"><?= $object->getPortaria() ?></a> <sup><?= $object->getTipo() ?></sup></td>
                        <td><small><?= $object->getResponsavel() ?></small></td>
                        <?php
                        $class = "dark";
                        $alert = "<strong>Concluído</strong>";

                        if (empty($object->getSolucao())) {
                            $class = $alert = "";
                            if (empty($object->getProrrogacaoPrazo())) {
                                $dateDif = date_diff($hoje, new DateTime($object->getDataPrazoOriginal()));
                                $dias = $dateDif->format('%a');
                                if (empty($object->getDataPrazoOriginal())) {
                                    $class = "info";
                                    $alert = "<strong>Sem prazo</strong>";
                                } else if ($dias == 0) {
                                    $class = "warning";
                                    $alert = "<strong>Vencendo</strong>";
                                } else if ($dateDif->format('%R') == "+") {
                                    $class = "success";
                                    $alert = "<strong>" . $dias . " dia(s) restantes</strong>";
                                } else if ($dateDif->format('%R') == "-" && $dias > 0) {
                                    $class = "danger";
                                    $alert = "<strong>" . abs($dias) . " dia(s) atrasada</strong>";
                                }
                            } else {
                                $dateDif = date_diff(new DateTime($object->getProrrogacaoPrazoOriginal()), $hoje);
                                $dias = $dateDif->format('%a');
                                if ($dias == 0) {
                                    $class = "warning";
                                    $alert = "<strong>Vencendo</strong>";
                                } else if ($dateDif->format('%R') == "+") {
                                    $class = "danger";
                                    $alert = "<strong>" . $dateDif->format('%a') . " dia(s) atrasada</strong>";
                                } else if ($dateDif->format('%R') == "-" && $dias > 0) {
                                    $class = "success";
                                    $alert = "<strong> $dias dia(s) restantes</strong>";
                                }
                            }
                            if (!empty($object->getDataFim())) {
                                $dateDif = date_diff(new DateTime($object->getDataFimOriginal()), $hoje);
                                $dias = $dateDif->format('%a');
                                $sinal = $dateDif->format('%R');
                                $class = "info";
                                if ($sinal == "+") {
                                    $alert = "<strong>Protocolado há $dias dia(s)</strong>";
                                } else {
                                    $alert = "<strong>Será protocolado em $dias dia(s)</strong>";
                                }
                            }
                        }
                        ?>
                        <td style="white-space: nowrap">                            
                            <span class="alert alert-<?= $class ?>" role="alert">   
                                <?= $object->getDataInicio() ?>
                                <?= !empty($object->getSolucao()) ? " até " . $object->getDataFim() : "" ?>  
                                <?php
                                if (empty($object->getSolucao()) && !empty($object->getProrrogacaoPrazo())) {
                                    echo "<img src='../include/imagens/seta.png' width='25' title='PRORROGADO ATÉ'> " . $object->getProrrogacaoPrazo();
                                }
                                ?>
        <?= $alert ?>   
                            </span>                  
                        </td>                                                
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_JURIDICO)) { ?>
                                <a href="../Controller/S1Controller.php?action=processo_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_JURIDICO)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do processo?') ? document.location = '../Controller/S1Controller.php?action=processo_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
        <?php } ?>
                        </td>
                    </tr>                    
                <?php endforeach; ?>    
<?php } ?>
        </tbody>
    </table>    
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

//    $(document).ready(function () {
//        $('[data-toggle="tooltip"]').tooltip();
//    });

    if (getCookie("juridico") === "1") {
        minimize("juridico");
    }

    if (getCookie("mapaDaForcaOficiais") === "1") {
        minimizeMapaDaForca();
    }

    function countRows() {
        let rowCount = $('#myTable tr:visible').length;
        var message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
        document.getElementById("contador").innerHTML = message;
    }

    countRows();
</script>
<script src="../include/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
