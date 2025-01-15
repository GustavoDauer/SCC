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
require_once '../include/header.php';
?>
<form action="../Controller/SPPController.php?action=gerar" method="post">
    <div class="container">
        <h2>Comparador de nomes para o Exame de Pagamento | <a href="#" onclick="history.back(-1);">Voltar</a></h2>
        <hr>   
        <div class="alert alert-warning">
            <strong>ATENÇÃO: </strong>
            Lembre-se que a discrepância pode ser resultado de divergências nos nomes!
        </div>             
        <div style="margin: 7px;">                          
            <table cellpadding="7" cellspacing="7">
                <tr>
                    <td>
                        <b>EFETIVO</b><br>
                        <textarea cols='61' rows='7' name="efetivo"><?php
                            if (isset($exameEfetivoList) && !is_null($exameEfetivoList)) {
                                foreach ($exameEfetivoList as $object):
                                    echo "$object\n";
                                endforeach;
                            }
                            ?></textarea>
                    </td>
                    <td>
                        <b>CPEX</b><br>
                        <textarea cols='61' rows='7' name="cpex"><?php
                            if (isset($exameCPEXList) && !is_null($exameCPEXList)) {
                                foreach ($exameCPEXList as $object):
                                    echo "$object\n";
                                endforeach;
                            }
                            ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div style='border: 1px solid red; border-bottom: 0px; padding: 7px; margin-bottom: 7px; text-align: center;'>
                            <h1 style="font-size: 25px; font-weight: bold;">RESULTADO</h1>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>                                
                        <span style="font-weight: bold;">CONTIDOS EM EFETIVO E <span style="color: red;"> NÃO CONTIDOS </span> EM CPEX</span>
                        <hr>
                        <textarea cols='61' rows='7' style='border: 0px;' readonly>
                            <?php
                            echo "\n";
                            if (isset($exameEfetivoNotInCPEXList) && !is_null($exameEfetivoNotInCPEXList)) {
                                foreach ($exameEfetivoNotInCPEXList as $object):
                                    echo "$object\n";
                                endforeach;
                            }
                            ?>
                        </textarea>
                    </td> 
                    <td>
                        <span style="font-weight: bold;">CONTIDOS EM CPEX E <span style="color: red;"> NÃO CONTIDOS </span> EM EFETIVO</span><hr>
                        <textarea cols='61' rows='7' style='border: 0px;'  readonly>
                            <?php
                            echo "\n";
                            if (isset($exameCPEXNotInEfetivoList) && !is_null($exameCPEXNotInEfetivoList)) {
                                foreach ($exameCPEXNotInEfetivoList as $object):
                                    echo "$object\n";
                                endforeach;
                            }
                            ?>
                        </textarea>
                    </td>
                </tr>                     
            </table>        
        </div>          
        <hr>
        <div align="center">
            <input type="submit" class="btn btn-primary" value="Gerar"> 
            <input type="button" class="btn btn-danger" value="Zerar campos" onclick="document.location = 'SPPController.php?action=getAllList'">
        </div>
    </div>
</form>
<?php
require_once '../include/footer.php';
