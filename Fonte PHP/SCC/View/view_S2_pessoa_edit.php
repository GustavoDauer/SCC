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
    <form accept-charset="UTF-8" action="../Controller/S2Controller.php?action=pessoa_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Pessoa | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">   
        <div class="form-group">
            <div class="form-row">
                <?php if ($object->getId() > 0) { ?>
                    <div class="col">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Foto</span>
                            <img src='<?= $object->getUploadedPhoto(); ?>' id="foto" style='margin-left: 50px; width: 400px; height: 400px'> 
                        </div>
                        <br>                    
                    </div>
                <?php } ?>
                <div class="col">  
                    <?php if (!$object->getId() > 0) { ?>
                        <div class="input-group-prepend">
                            <span class="input-group-text">Foto</span>
                        <?php } ?>
                        <input class="form-control" type="file" id="arquivoFoto" name="arquivoFoto">
                        <?php if (!$object->getId() > 0) { ?>
                        </div>
                    <?php } ?>
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nome completo</span>                                                
                        <input type="text" class="form-control" id="nome" placeholder="Nome completo da pessoa" name="nome" oninput="this.value = this.value.toUpperCase()" maxlength="125" value="<?= $object->getNome() ?>">
                    </div>
                    <br>                                                           
                    <div class="input-group-prepend">
                        <span class="input-group-text">Posto/Graduação</span>                                                
                        <select name="idPosto" class="form-control">                            
                            <?php foreach ($postoList as $posto): ?>                                
                                <option value="<?= $posto->getId() ?>" <?= $object->getIdPosto() == $posto->getId() ? "selected" : "" ?>><?= $posto->getPosto() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> 
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nome de guerra</span>                                                
                        <input type="text" class="form-control" id="nomeGuerra" placeholder="Nome de guerra da pessoa" name="nomeGuerra" oninput="this.value = this.value.toUpperCase()" maxlength="125" value="<?= $object->getNomeGuerra() ?>">
                    </div>                    
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">CPF</span>                                                
                        <input type="text" class="form-control" id="cpf" placeholder="000.000.000-00" name="cpf" maxlength="11" value="<?= $object->getCpf() ?>">
                    </div>  
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Identidade Militar</span>                                                
                        <input type="text" class="form-control" id="identidadeMilitar" placeholder="000000000-0" name="identidadeMilitar" maxlength="10" value="<?= $object->getIdentidadeMilitar() ?>">
                    </div>
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">PREC-CP</span>                                                
                        <input type="text" class="form-control" id="preccp" placeholder="000000000-00" name="preccp" maxlength="11" value="<?= $object->getPreccp() ?>">
                    </div>
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Vínculo</span>                                                
                        <select name="idVinculo" class="form-control">                            
                            <?php foreach ($vinculoList as $vinculo): ?>                                
                                <option value="<?= $vinculo->getId() ?>" <?= $object->getIdVinculo() == $vinculo->getId() ? "selected" : "" ?>><?= $vinculo->getVinculo() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data Expiração</span>                                                
                        <input type="date" class="form-control" id="dataExpiracao" name="dataExpiracao" value="<?= $object->getDataExpiracao() ?>">
                    </div> 
                    <br>                    
                </div>                
            </div>
        </div>        
        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<script>
    function update() {
        document.getElementById("filtro").submit();
    }

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
        $('[name=cpf]').mask('000.000.000-00');
        $('[name=identidadeMilitar]').mask('000000000-0');
        $('[name=preccp]').mask('000000000-00');
    });
</script>
<?php
require_once '../include/footer.php';
