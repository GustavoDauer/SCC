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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<div class="container">  <!--../Controller/IdentidadeController.php?action=gerar-->
    <form accept-charset="UTF-8" action="../View/view_Identidade_list.php" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
        <h2>Gerar Identidade | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Gerar</button></h2>
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">          
        <div class="form-group">
            <div class="form-row"> 
                <div class="col">  
                    <div class="input-group-prepend">
                        <span class="input-group-text">Linha</span>
                        <input type="text" class="form-control" id="linha" placeholder="Cole a linha do excel" name="linha" required>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Obrigatório</div>
                    </div>                    
                </div>                                
            </div>
        </div>            
        <hr>
        <button type="submit" class="btn btn-primary">Gerar</button>
    </form>
    <hr>
    Solução:
    <hr>
    <?php
    $linha = "";
    if (isset($_REQUEST["linha"])) {
        $linha = $_REQUEST["linha"];
        // SOLUCAO
        $resultado = explode("SEPARADOR", $linha);
        $id1 = $resultado[0];
        $id1 = explode("\t", $id1);
        echo var_dump($id1) . "<hr>";
        $id2 = $resultado[1];
        $id2 = explode("\t", $id2);
        echo var_dump($id2) . "<hr>";
        $id3 = $resultado[2];
        $id3 = explode("\t", $id3);
        echo var_dump($id3) . "<hr>";
        $id4 = $resultado[3];
        $id4 = explode("\t", $id4);
        echo var_dump($id4) . "<hr>";
        $dadosComuns = $resultado[4];
        $dadosComuns = explode("\t", $dadosComuns);
        echo var_dump($dadosComuns) . "<br>";

        if (count($resultado) != 80) {
            echo "Deu ruim: " . count($resultado) . " colunas";
        } else {
            ?>
            <table width="732" cellpadding="5" cellspacing="0" border="1">
                <col width="134"/>

                <col width="77"/>

                <col width="25"/>

                <col width="96"/>

                <col width="184"/>

                <col width="155"/>

                <tr>
                    <td colspan="4" width="363" height="22" valign="top" style="border: 1px solid; padding: 0cm"><p style="margin-bottom: 0cm">
                            <br/>

                        </p>
                        <p><br/>

                        </p>
                    </td>
                    <td colspan="2" width="349" valign="bottom" style="border: 1px solid; padding: 0cm"><h3 class="western" style="text-indent: 0cm">
                            <span style="background: #c0c0c0">FULANO DE TAL 2</span>
                            <font size="2" style="font-size: 11pt">e</font></h3>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="4" width="363" height="8" style="border: 1px solid; padding: 0cm"><p>
                            <br/>

                        </p>
                    </td>
                    <td colspan="2" width="349" style="border: 1px solid; padding: 0cm"><h3 class="western" style="text-indent: 0cm">
                            <span style="background: #c0c0c0">FULANO DE TAL</span></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" width="363" height="9" valign="top" style="border: 1px solid; padding: 0cm"><p>
                            <br/>

                        </p>
                    </td>
                    <td rowspan="2" colspan="2" width="349" valign="bottom" style="border: 1px solid; padding: 0cm"><p>
                            <span style="background: #c0c0c0">Pindamonhangaba</span> <font size="2" style="font-size: 11pt">-
                            <span style="background: #c0c0c0">SP</span> - <span style="background: #c0c0c0">BRASIL</span>
                            – <span style="background: #c0c0c0">15 JAN 2000</span></font></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" width="363" valign="top" style="border: 1px solid; padding: 0cm"><p>
                            <br/>

                        </p>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" colspan="2" width="221" height="17" style="border: 1px solid; padding: 0cm"><p align="center">
                            <span style="background: #c0c0c0">2° BE Cmb</span></p>
                    </td>
                    <td colspan="2" width="132" valign="top" style="border: 1px solid; padding: 0cm"><p>
                            <br/>

                        </p>
                    </td>
                    <td rowspan="2" width="184" style="border: 1px solid; padding: 0cm"><p style="text-indent: 1.13cm">
                            <span style="background: #c0c0c0">00.000.000-0</span> <font size="2" style="font-size: 11pt">-
                            <span style="background: #c0c0c0">SSP/SP</span></font></p>
                    </td>
                    <td rowspan="2" width="155" style="border: 1px solid; padding: 0cm"><p style="text-indent: 0.75cm">
                            <span style="background: #c0c0c0">000.000.000-00</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" width="132" valign="top" style="border: 1px solid; padding: 0cm"><p>
                            <br/>

                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="134" height="11" valign="top" style="border: 1px solid; padding: 0cm"><p align="center" style="background: #ffffff">
                            <span style="background: #c0c0c0">0000000000-0</span></p>
                    </td>
                    <td colspan="2" width="113" valign="top" style="border: 1px solid; padding: 0cm"><h5 class="western" style="text-indent: 0cm">
                        </h5>
                    </td>
                    <td width="96" valign="top" style="border: 1px solid; padding: 0cm"><h4 class="western" style="margin-right: -0.12cm">
                            <span style="background: #c0c0c0">29 FEV 2024</span></h4>
                    </td>
                    <td colspan="2" width="349" valign="bottom" style="border: 1px solid; padding: 0cm"><p style="text-indent: 1.13cm">
                            <span style="background: #c0c0c0">Pindamonhangaba</span> <font size="2" style="font-size: 11pt">-
                            <span style="background: #c0c0c0">SP</span> , <span style="background: #c0c0c0">17 de Maio de 2023</span>.</font></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" width="363" height="66" valign="top" style="border: 1px solid; padding: 0cm"><p align="center" style="margin-bottom: 0cm">
                            <span style="background: #c0c0c0">FULANO DE TAL</span></p>
                        <p align="center" style="margin-bottom: 0cm">      <span style="background: #c0c0c0">Posto</span>
                            <span style="background: #c0c0c0">QM 10-61</span></p>
                        <p align="center"><br/>

                        </p>
                    </td>
                    <td colspan="2" width="349" style="border: 1px solid; padding: 0cm"><p align="center" style="margin-bottom: 0cm">
                            <br/>

                        </p>
                        <p align="center" style="margin-bottom: 0cm"><span style="background: #c0c0c0"><?= $resultado[79] ?></span></p>
                        <p align="center">    <font size="1" style="font-size: 8pt">Encarregado
                            de Pessoal</font></p>
                    </td>
                </tr>


            </table>
            <?php
        }
    }
    ?>
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
</script>
<?php
require_once '../include/footer.php';
