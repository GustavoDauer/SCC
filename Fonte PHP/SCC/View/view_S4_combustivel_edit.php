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
<div class="container">  
    <h2>Editar saldo de combsutível</h2>
    <a href="#" onclick="history.back(-1);">Voltar</a>
    <br>
    <?php
    if (is_array($objectList)) {
        foreach ($objectList as $object) {
            ?>
            <form accept-charset="UTF-8" action="../Controller/S4Controller.php?action=combustivel_update" class="needs-validation" novalidate method="post">
                <table class="table table-bordered">
                    <thead>
                        <tr>    
                            <th colspan="6" style="text-align: center; background-color: #fffdd7;">SALDO DE COMBUSTÍVEL - COTA 02</th>                                         
                        </tr>         
                        <tr style="text-align: center">    
                            <th colspan="3" style="width: 50%;">CTC 01</th>                                          
                            <th colspan="3">CTC 04</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr style="text-align: center; font-weight: bold;">
                            <td><input class="form-control" type="text" name="ctc01celula1" value="<?= $object->getCtc01celula1() ?>" maxlength="70"></td>
                            <td><input class="form-control" type="text" name="ctc01celula2" value="<?= $object->getCtc01celula2() ?>" maxlength="70"></td>
                            <td><input class="form-control" type="text" name="ctc01celula3" value="<?= $object->getCtc01celula3() ?>" maxlength="70"></td>
                            <td><input class="form-control" type="text" name="ctc04celula1" value="<?= $object->getCtc04celula1() ?>" maxlength="70"></td>
                            <td><input class="form-control" type="text" name="ctc04celula2" value="<?= $object->getCtc04celula2() ?>" maxlength="70"></td>
                            <td><input class="form-control" type="text" name="ctc04celula3" value="<?= $object->getCtc04celula3() ?>" maxlength="70"></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td><input class="form-control" type="text" name="ctc01celula1valor" value="<?= $object->getCtc01celula1valor() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>
                            <td><input class="form-control" type="text" name="ctc01celula2valor" value="<?= $object->getCtc01celula2valor() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>
                            <td><input class="form-control" type="text" name="ctc01celula3valor" value="<?= $object->getCtc01celula3valor() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>
                            <td><input class="form-control" type="text" name="ctc04celula1valor" value="<?= $object->getCtc04celula1valor() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>
                            <td><input class="form-control" type="text" name="ctc04celula2valor" value="<?= $object->getCtc04celula2valor() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>
                            <td><input class="form-control" type="text" name="ctc04celula3valor" value="<?= $object->getCtc04celula3valor() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>    
                            <th colspan="2" style="text-align: center; background-color: #fffdd7;">SALDO TOTAL DOS TANQUES (PCA)</th>                                         
                        </tr>         
                        <tr style="text-align: center">    
                            <th style="width: 50%;">DIESEL</th>                                          
                            <th>GASOLINA</th>
                        </tr>
                    </thead>
                    <tbody id="myTable"> 
                        <tr style="text-align: center">
                            <td style="width: 50%;"><input class="form-control" type="text" name="diesel" value="<?= $object->getDiesel() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>
                            <td><input class="form-control" type="text" name="gasolina" value="<?= $object->getGasolina() ?>" onchange="check(this);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44 || event.charCode === 45;" onblur="finalCheck(this);" maxlength="10"></td>         
                        </tr>
                    </tbody>
                </table>
                <div align="center">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
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

    function check(object) {
        if (object.value === "") {
            object.value = "0.0";
        } else if (object.value.includes(",")) {
            var count = (object.value.match(/,/g) || []).length;
            if (count > 1) {
                object.value = object.value.replace(",", "");
            }
            if (object.value.indexOf(",") === 0) {
                object.value = "0" + object.value;
            }
        } else if (!object.value.includes(",")) {
            object.value = object.value + ",0";
        }
        object.value = object.value.replace(".", ",");
    }

    function finalCheck(object) {
        if (object.value.indexOf(",") === object.value.length - 1) {
            object.value = object.value + "0";
        }
    }
</script>
<?php
require_once '../include/footer.php';
