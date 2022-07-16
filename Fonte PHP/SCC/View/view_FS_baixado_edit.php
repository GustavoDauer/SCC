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
    <form accept-charset="UTF-8" action="../Controller/FSController.php?action=baixado_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Baixado | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">   
        <div class="form-group">
            <div class="form-row">                
                <div class="col-4">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Posto/Graduação e Nome</span>
                        <select name="idPosto" class="form-control">                            
                            <?php foreach ($postoList as $posto): ?>                                
                                <option value="<?= $posto->getId() ?>" <?= $object->getIdPosto() == $posto->getId() ? "selected" : "" ?>><?= $posto->getPosto() ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="nome" placeholder="Nome" name="nome" oninput="this.value = this.value.toUpperCase()" required onchange="check();" maxlength="125" value="<?= $object->getNome() ?>">
                    <div class="valid-feedback">&nbsp;</div>
                    <div class="invalid-feedback">&nbsp;</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Cia</span>
                        <select name="cia" class="form-control">
                            <option disabled selected>Escolha Cia</option>
                            <option <?= $object->getCia() == "CCAp" ? "selected" : "" ?>>CCAp</option>
                            <option <?= $object->getCia() == "CEC" ? "selected" : "" ?>>CEC</option>                 
                            <option <?= $object->getCia() == "CEP" ? "selected" : "" ?>>CEP</option>
                        </select>
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Ano</span>
                        <input type="text" class="form-control" id="turma" placeholder="Digite o ano de turma do baixado.." name="turma" onkeypress="return (event.charCode >= 48 && event.charCode <= 57);" maxlength="4" value="<?= $object->getTurma() ?>">
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
                        <span class="input-group-text">Diag. Médico</span>
                        <input type="text" class="form-control" id="diagnostico" placeholder="Digite o diagnóstico do baixado.." name="diagnostico"  maxlength="70" value="<?= $object->getDiagnostico() ?>">
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
                        <span class="input-group-text">Situação</span>
                        <select class="form-control" id="situacao" name="situacao" required>
                            <option disabled selected>Escolha a situação do baixado</option>                        
                            <option <?= $object->getSituacao() == "Ativa com Restrição Médica" ? "selected" : "" ?>>Ativa com Restrição Médica</option>
                            <option <?= $object->getSituacao() == "Encostado" ? "selected" : "" ?>>Encostado</option>
                            <option <?= $object->getSituacao() == "Agregado" ? "selected" : "" ?>>Agregado</option>
                            <option <?= $object->getSituacao() == "Adido" ? "selected" : "" ?>>Adido</option>
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
                        <span class="input-group-text">BI</span>
                        <input type="text" class="form-control" id="bi" placeholder="Digite o Boletim Interno ou Nota de publicação.." name="bi"  maxlength="520" value="<?= $object->getBi() ?>">
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
                        <span class="input-group-text">BAR</span>
                        <input type="text" class="form-control" id="bar" placeholder="Digite o Boletim de Acesso Restrito ou Nota de publicação.." name="bar"  maxlength="520" value="<?= $object->getBar() ?>">
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
                        <span class="input-group-text">Parecer</span> <!-- Dispensa -->
                        <input type="text" class="form-control" id="dispensa" placeholder="Parecer" name="dispensa"  maxlength="700" value="<?= $object->getDispensa() ?>">
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
                        <span class="input-group-text">Observação/Amparo</span>
                        <input type="text" class="form-control" id="amparo" placeholder="Observações.." name="amparo"  maxlength="700" value="<?= $object->getAmparo() ?>">
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
                        <span class="input-group-text">Ações</span>
                        <input type="text" class="form-control" id="acao" placeholder="Ações.." name="acao"  maxlength="700" value="<?= $object->getAcao() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
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
</script>
<?php
require_once '../include/footer.php';
