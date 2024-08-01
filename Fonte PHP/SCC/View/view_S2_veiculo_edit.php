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
$hoje = date('Y-m-d');
?>
<script src="../include/js/jquery-3.4.1.slim.min.js"></script>
<script src="../include/js/popper.min.js"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<div class="container">  
    <form accept-charset="UTF-8" action="../Controller/S2Controller.php?action=veiculo_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Veículo | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">   
        <div class="form-group">
            <div class="form-row">  
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Proprietário</span>
                        <select name="idPessoa" class="form-control">
                            <option disabled selected>Selecione uma pessoa como proprietário</option>                            
                            <?php foreach ($pessoaList as $pessoa): ?>                                
                                <option value="<?= $pessoa->getId() ?>" <?= $object->getIdPessoa() == $pessoa->getId() ? "selected" : "" ?>><?= $pessoa->getNome() ?></option>
                            <?php endforeach; ?>                           
                        </select>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tipo</span>
                        <select name="tipo" class="form-control">
                            <option>Carro</option>
                            <option>Moto</option>
                            <option>Van</option>
                            <option>Ônibus/Caminhão</option>
                        </select>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">  
                <div class="col">                      
                    <div class="input-group-prepend">
                        <span class="input-group-text">Marca</span>                                                
                        <input type="text" class="form-control" id="marca" placeholder="Exemplo: Ford, Chevrolet, Fiat, Jeep, Toyota" name="marca" oninput="this.value = this.value.toUpperCase()" maxlength="25" value="<?= $object->getMarca() ?>">
                    </div>
                </div> 
                <div class="col">                      
                    <div class="input-group-prepend">
                        <span class="input-group-text">Modelo</span>                                                
                        <input type="text" class="form-control" id="modelo" placeholder="Exemplo: Ka, Agile, Renagade, Hilux, Ranger" name="modelo" oninput="this.value = this.value.toUpperCase()" maxlength="25" value="<?= $object->getModelo() ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">                 
                <div class="col">                      
                    <div class="input-group-prepend">
                        <span class="input-group-text">Ano Fabricação</span>                                                
                        <input type="number" class="form-control" id="anoFabricacao" name="anoFabricacao" maxlength="4" value="<?= $object->getAnoFabricacao() ?>" min="1956" max="<?= date('Y') ?>">
                    </div>
                </div> 
                <div class="col">                      
                    <div class="input-group-prepend">
                        <span class="input-group-text">Ano Modelo</span>                                                
                        <input type="number" class="form-control" id="anoModelo" name="anoModelo" maxlength="4" value="<?= $object->getAnoModelo() ?>" min="1956" max="<?= date('Y') ?>">
                    </div>
                </div>             
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Cor</span>
                        <input type="color" class="form-control" id="cor" name="cor" value="<?= $object->getCor() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Placa</span>
                        <input type="text" class="form-control" id="placa" name="placa" maxlength="8" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getPlaca() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>                
            </div>
        </div>                           
        <div class="form-group">
            <div class="form-row"> 
                <div class="col-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">EB</span>
                        <input type="text" class="form-control" id="placaEB" name="placaEB" maxlength="25" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getPlacaEB() ?>"> 
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">
                    <span style="color: blue; font-size: 12px;">* Veículos Militares</span>                
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
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
        $('[name=placaEB]').mask('EB0000000000');
    });
</script>
<?php
require_once '../include/footer.php';
