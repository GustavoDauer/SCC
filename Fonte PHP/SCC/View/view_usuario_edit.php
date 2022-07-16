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
    <form accept-charset="UTF-8" action="../Controller/UsuarioController.php?action=<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Usuário | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>
        <a href="#" onclick="history.back(-1);">Voltar</a>
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">
        <div class="form-group">
            <div class="form-row">                                            
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Posto</span>
                        <select name="idPosto" class="form-control" required>
                            <?php foreach ($postoList as $posto): ?>                                
                                <option value="<?= $posto->getId() ?>" <?= $posto->getId() == $object->getIdPosto() ? "selected" : "" ?>><?= $posto->getPosto() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>               
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nome</span>
                        <input type="text" class="form-control" id="nome" placeholder="Digite o nome.." name="nome" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getNome() ?>" maxlength="70">
                        <div class="valid-feedback">&nbsp;Válido.</div>
                        <div class="invalid-feedback">&nbsp;Inválido</div>
                    </div>                    
                </div>                
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Login</span>
                        <input type="text" class="form-control" id="login" placeholder="Digite o login.." name="login" value="<?= $object->getLogin() ?>" required maxlength="70">
                        <div class="valid-feedback">&nbsp;Válido.</div>
                        <div class="invalid-feedback">&nbsp;Inválido</div>
                    </div>                    
                </div>                
            </div>
        </div>                       
        <div class="form-group">
            <div class="form-row">                                            
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Senha</span>
                        <input type="password" class="form-control" id="senha" placeholder="Digite uma senha para inserir ou alterar a senha.." name="senha" maxlength="70">
                        <div class="valid-feedback">&nbsp;Válido.</div>
                        <div class="invalid-feedback">&nbsp;Inválido.</div>
                    </div>
                </div>               
            </div>
        </div>           
        <div class="form-group">
            <div class="form-row">                                            
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                        &nbsp;<input type="checkbox" id="status" name="status" value="1"  <?= $object->getStatus() || $object->getId() == 0 ? "checked" : "" ?>> Ativo            
                    </div>
                </div>               
            </div>
        </div>
        <?php if ($object->getId() > 0) { ?>
            <div class="form-group">
                <div class="form-row">                                            
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Seções</span>
                            <select class="form-control" name="idSecoes[]" size="5" multiple>
                                <?php

                                function hasSecao($secaoCandidata, $secoes) {
                                    foreach ($secoes as $secao) {
                                        if ($secao->getId() == $secaoCandidata->getId()) {
                                            return true;
                                        }
                                    }
                                    return false;
                                }

                                if (!empty($secaoDAO->getAllList()) && $secaoDAO->getAllList() != null) {
                                    $secoes = $secaoDAO->getSecoes($object->getId());
                                    foreach ($secaoDAO->getAllList() as $secao) {
                                        ?>
                                        <option value="<?= $secao->getId() ?>" <?= hasSecao($secao, $secoes) ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>               
                </div>
            </div>
        <?php } ?>
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
