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
?>
<style type="text/css">    
    .encostado { 
        color: gray;
    }    

    .destaque {
        background-color: lightyellow;
        font-weight: bold;
    }

    .mapaDaForcaInput {
        text-align: center;
        width: 35px;
    }
    
    .adido {
        width: 70px;
        resize: both;
    }
</style>
<div class="container">     
    <h2>Editar Mapa da Força</h2>
    <a href="#" onclick="history.back(-1);">Voltar</a>
    <hr>
    <form accept-charset="UTF-8" action="../Controller/S1Controller.php?action=mapaDaForca_update" class="needs-validation" novalidate method="post">
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">                            
        <table class="table table-bordered" id="mapaDaForcaOficiais">                
            <tbody>
                <tr class="destaque">
                    <td>OFICIAIS</td>
                    <td>Cel</td>
                    <td>TC</td>
                    <td>Maj</td>
                    <td>Cap</td>
                    <td>1º Ten</td>
                    <td>2º Ten</td>
                    <td>Asp Of</td>                    
                </tr>
                <tr>                
                    <td>
                        PREVISTO
                    </td>   
                    <td>
                        <input type="text" name="cel_previsto" value="<?= $object->getCel_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Cel -->
                    <td>
                        <input type="text" name="tc_previsto" value="<?= $object->getTc_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- TC -->
                    <td>
                        <input type="text" name="maj_previsto" value="<?= $object->getMaj_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Maj -->
                    <td>
                        <input type="text" name="cap_previsto" value="<?= $object->getCap_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Cap -->
                    <td>
                        <input type="text" name="ten1_previsto" value="<?= $object->getTen1_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 1º Ten -->
                    <td>
                        <input type="text" name="ten2_previsto" value="<?= $object->getTen2_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 2º Ten -->
                    <td>
                        <input type="text" name="aspof_previsto" value="<?= $object->getAspof_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Asp Of -->                    
                </tr> 
                <tr>                
                    <td>
                        EXISTENTE
                    </td>   
                    <td>
                        <input type="text" name="cel_existente" value="<?= $object->getCel_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Cel -->
                    <td>
                        <input type="text" name="tc_existente" value="<?= $object->getTc_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- TC -->
                    <td>
                        <input type="text" name="maj_existente" value="<?= $object->getMaj_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Maj -->
                    <td>
                        <input type="text" name="cap_existente" value="<?= $object->getCap_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Cap -->
                    <td>
                        <input type="text" name="ten1_existente" value="<?= $object->getTen1_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 1º Ten -->
                    <td>
                        <input type="text" name="ten2_existente" value="<?= $object->getTen2_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 2º Ten -->
                    <td>
                        <input type="text" name="aspof_existente" value="<?= $object->getAspof_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Asp Of -->                    
                </tr>
                <tr>                
                    <td>
                        ADIDOS
                    </td>                        
                    <td><input type="text" name="cel_adido" value="<?= $object->getCel_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="cel_adidoTexto" maxlength="500"><?= $object->getCel_adidoTexto() ?></textarea></td> <!-- Cel -->
                    <td><input type="text" name="tc_adido" value="<?= $object->getTc_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="tc_adidoTexto" maxlength="500"><?= $object->getTc_adidoTexto() ?></textarea></td>  <!-- TC --> 
                    <td><input type="text" name="maj_adido" value="<?= $object->getMaj_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="maj_adidoTexto" maxlength="500"><?= $object->getMaj_adidoTexto() ?></textarea></td>  <!-- Maj --> 
                    <td><input type="text" name="cap_adido" value="<?= $object->getCap_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="cap_adidoTexto" maxlength="500"><?= $object->getCap_adidoTexto() ?></textarea></td>  <!-- Cap --> 
                    <td><input type="text" name="ten1_adido" value="<?= $object->getTen1_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="ten1_adidoTexto" maxlength="500"><?= $object->getTen1_adidoTexto() ?></textarea></td>  <!-- 1º Ten --> 
                    <td><input type="text" name="ten2_adido" value="<?= $object->getTen2_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="ten2_adidoTexto" maxlength="500"><?= $object->getTen2_adidoTexto() ?></textarea></td>  <!-- 2º Ten --> 
                    <td><input type="text" name="aspof_adido" value="<?= $object->getAspof_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="aspof_adidoTexto" maxlength="500"><?= $object->getAspof_adidoTexto() ?></textarea></td>  <!-- Asp Of -->            
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered" id="mapaDaForcaStsgt">
            <tbody>
                <tr class="destaque">
                    <td>S TEN / SGT</td>
                    <td>S Ten</td>
                    <td>1º Sgt</td>
                    <td>2º Sgt</td>
                    <td>3º Sgt</td>                          
                </tr>
                <tr>                
                    <td>
                        PREVISTO
                    </td>   
                    <td><input type="text" name="sten_previsto" value="<?= $object->getSten_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- S Ten -->
                    <td><input type="text" name="sgt1_previsto" value="<?= $object->getSgt1_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- 1º Sgt -->
                    <td><input type="text" name="sgt2_previsto" value="<?= $object->getSgt2_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- 2º Sgt -->
                    <td><input type="text" name="sgt3_previsto" value="<?= $object->getSgt3_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- 3º Sgt -->                           
                </tr>  
                <tr>                
                    <td>
                        EXISTENTE
                    </td>   
                    <td>
                        <input type="text" name="sten_existente" value="<?= $object->getSten_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- S Ten -->
                    <td>
                        <input type="text" name="sgt1_existente" value="<?= $object->getSgt1_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 1º Sgt -->
                    <td>
                        <input type="text" name="sgt2_existente" value="<?= $object->getSgt2_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 2º Sgt -->
                    <td>
                        <input type="text" name="sgt3_existente" value="<?= $object->getSgt3_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 3º Sgt -->                         
                </tr>
                <tr>                
                    <td>
                        ADIDOS
                    </td>                        
                    <td><input type="text" name="sten_adido" value="<?= $object->getSten_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sten_adidoTexto" maxlength="500"><?= $object->getSten_adidoTexto() ?></textarea class="adido"></td> <!-- S Ten -->
                    <td><input type="text" name="sgt1_adido" value="<?= $object->getSgt1_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sgt1_adidoTexto" maxlength="500"><?= $object->getSgt1_adidoTexto() ?></textarea class="adido"></td> <!-- 1º Sgt -->
                    <td><input type="text" name="sgt2_adido" value="<?= $object->getSgt2_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sgt2_adidoTexto" maxlength="500"><?= $object->getSgt2_adidoTexto() ?></textarea class="adido"></td> <!-- 2º Sgt -->
                    <td><input type="text" name="sgt3_adido" value="<?= $object->getSgt3_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sgt3_adidoTexto" maxlength="500"><?= $object->getSgt3_adidoTexto() ?></textarea class="adido"></td> <!-- 3º Sgt -->                     
                </tr>                                                         
            </tbody>   
        </table>
        <table class="table table-bordered" id="mapaDaForcaCbsd">
            <tbody>
                <tr class="destaque">
                    <td>CB / SD</td>
                    <td>Cb</td>
                    <td>Cb EV</td>
                    <td>Sd EP</td>
                    <td>Sd EV</td>                         
                </tr>
                <tr>                
                    <td>
                        PREVISTO
                    </td>   
                    <td><input type="text" name="cb_previsto" value="<?= $object->getCb_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- Cb -->
                    <td><input type="text" name="cbev_previsto" value="<?= $object->getCbev_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- Cb EV -->
                    <td><input type="text" name="sdep_previsto" value="<?= $object->getSdep_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- Sd EP -->
                    <td><input type="text" name="sdev_previsto" value="<?= $object->getSdev_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"></td> <!-- Sd EV -->                      
                </tr>    
                <tr>                
                    <td>
                        EXISTENTE
                    </td>   
                    <td>
                        <input type="text" name="cb_existente" value="<?= $object->getCb_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Cb -->
                    <td>
                        <input type="text" name="cbev_existente" value="<?= $object->getCbev_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Cb EV -->
                    <td>
                        <input type="text" name="sdep_existente" value="<?= $object->getSdep_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Sd EP -->
                    <td>
                        <input type="text" name="sdev_existente" value="<?= $object->getSdev_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Sd EV -->                          
                </tr>
                <tr>                
                    <td>
                        ADIDOS
                    </td>                        
                    <td><input type="text" name="cb_adido" value="<?= $object->getCb_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="cb_adidoTexto" maxlength="500"><?= $object->getCb_adidoTexto() ?></textarea class="adido"></td>  <!-- Cb --> 
                    <td><input type="text" name="cbev_adido" value="<?= $object->getCbev_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="cbev_adidoTexto" maxlength="500"><?= $object->getCbev_adidoTexto() ?></textarea class="adido"></td>  <!-- Cb EV --> 
                    <td><input type="text" name="sdep_adido" value="<?= $object->getSdep_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sdep_adidoTexto" maxlength="500"><?= $object->getSdep_adidoTexto() ?></textarea class="adido"></td>  <!-- Sd EP --> 
                    <td><input type="text" name="sdev_adido" value="<?= $object->getSdev_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sdev_adidoTexto" maxlength="500"><?= $object->getSdev_adidoTexto() ?></textarea class="adido"></td>  <!-- Sd EV -->                    
                </tr>  
            </tbody>
        </table>
        <table class="table table-bordered" id="mapaDaForcaPttc">                
            <tbody>
                <tr class="destaque">
                    <td>PTTC</td>                        
                    <td>Cap</td>
                    <td>1º Ten</td>
                    <td>2º Ten</td>
                    <td>S Ten</td>
                    <td>1º Sgt</td>
                    <td>2º Sgt</td>                    
                </tr>
<!--                <tr>                
                    <td>
                        PREVISTO
                    </td>                                           
                    <td>
                        <input type="text" name="cap_pttc_previsto" value="<?= $object->getCap_pttc_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td>  Cap 
                    <td>
                        <input type="text" name="ten1_pttc_previsto" value="<?= $object->getTen1_pttc_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td>  1º Ten 
                    <td>
                        <input type="text" name="ten2_pttc_previsto" value="<?= $object->getTen2_pttc_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td>  2º Ten   
                    <td>
                        <input type="text" name="sten_pttc_previsto" value="<?= $object->getSten_pttc_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td>  S Ten 
                    <td>
                        <input type="text" name="sgt1_pttc_previsto" value="<?= $object->getSgt1_pttc_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td>  1º Sgt 
                    <td>
                        <input type="text" name="sgt2_pttc_previsto" value="<?= $object->getSgt2_pttc_previsto() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td>  2º Sgt                                    
                </tr> -->
                <tr>                
                    <td>
                        EXISTENTE
                    </td>                       
                    <td>
                        <input type="text" name="cap_pttc_existente" value="<?= $object->getCap_pttc_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- Cap -->
                    <td>
                        <input type="text" name="ten1_pttc_existente" value="<?= $object->getTen1_pttc_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 1º Ten -->
                    <td>
                        <input type="text" name="ten2_pttc_existente" value="<?= $object->getTen2_pttc_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 2º Ten -->  
                    <td>
                        <input type="text" name="sten_pttc_existente" value="<?= $object->getSten_pttc_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- S Ten -->
                    <td>
                        <input type="text" name="sgt1_pttc_existente" value="<?= $object->getSgt1_pttc_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 1º Sgt -->
                    <td>
                        <input type="text" name="sgt2_pttc_existente" value="<?= $object->getSgt2_pttc_existente() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);">
                    </td> <!-- 2º Sgt -->                                     
                </tr>
<!--                <tr>                
                    <td>
                        ADIDOS
                    </td>                                            
                    <td>
                        <input type="text" name="cap_pttc_adido" value="<?= $object->getCap_pttc_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="cap_pttc_adidoTexto" maxlength="500"><?= $object->getCap_pttc_adidoTexto() ?></textarea class="adido">
                    </td>  Cap 
                    <td>
                        <input type="text" name="ten1_pttc_adido" value="<?= $object->getTen1_pttc_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="ten1_pttc_adidoTexto" maxlength="500"><?= $object->getTen1_pttc_adidoTexto() ?></textarea class="adido">
                    </td>  1º Ten 
                    <td>
                        <input type="text" name="ten2_pttc_adido" value="<?= $object->getTen2_pttc_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="ten2_pttc_adidoTexto" maxlength="500"><?= $object->getTen2_pttc_adidoTexto() ?></textarea class="adido">
                    </td>  2º Ten   
                    <td>
                        <input type="text" name="sten_pttc_adido" value="<?= $object->getSten_pttc_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sten_pttc_adidoTexto" maxlength="500"><?= $object->getSten_pttc_adidoTexto() ?></textarea class="adido">
                    </td>  S Ten 
                    <td>
                        <input type="text" name="sgt1_pttc_adido" value="<?= $object->getSgt1_pttc_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sgt1_pttc_adidoTexto" maxlength="500"><?= $object->getSgt1_pttc_adidoTexto() ?></textarea class="adido">
                    </td>  1º Sgt 
                    <td>
                        <input type="text" name="sgt2_pttc_adido" value="<?= $object->getSgt2_pttc_adido() ?>" class="mapaDaForcaInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onblur="check(this);"><br><textarea class="adido" name="sgt2_pttc_adidoTexto" maxlength="500"><?= $object->getSgt2_pttc_adidoTexto() ?></textarea class="adido">
                    </td>  2º Sgt                     
                </tr>-->
            </tbody>
        </table>
        <table class="table table-bordered" id="mapaDaForcaEncostado">
            <tbody>
                <tr class="encostado">                
                    <th>
                        ENCOSTADOS
                    </th>                        
                    <td><textarea name="encostados" cols="25"><?= $object->getEncostados() ?></textarea class="adido"></td>                        
                </tr>
                <tr class="encostado">                
                    <th>
                        AGREGADOS
                    </th>                        
                    <td><textarea name="agregados" cols="25"><?= $object->getAgregados() ?></textarea class="adido"></td>                        
                </tr>
            </tbody>  
        </table>
        <hr>
        <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
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

    function check(input) {
        input.value = input.value === "" ? "0" : input.value;
    }
</script>
<?php
require_once '../include/footer.php';
