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
    <form accept-charset="UTF-8" action="../Controller/S4Controller.php?action=material_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Material | <a class="feedback" href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>    
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">        
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Classe</span>
                        <select class="form-control" id="idClasse" name="idClasse" required>                            
                            <?php
                            $classeList = $classeDAO->getAllList();
                            if (null != $classeList) {
                                foreach ($classeList as $classe) {
                                    ?>
                                    <option value="<?= $classe->getId() ?>" <?= $object->getIdClasse() == $classe->getId() ? "selected" : "" ?>><?= $classe->getClasse() ?></option>
                                    <?php
                                }
                            }
                            ?>                            

                        </select>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>    
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Item</span>
                        <input type="text" class="form-control" id="item" placeholder="Título resumido do material/equipamento" name="item" value="<?= $object->getItem() ?>" oninput="this.value = this.value.toUpperCase()" required maxlength="250">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Situação</span>
                        <select class="form-control" id="idSituacao" name="idSituacao" onchange="check(this.id);" required>                            
                            <?php
                            $situacaoList = $situacaoDAO->getAllList();
                            if (null != $situacaoList) {
                                foreach ($situacaoList as $situacao) {
                                    ?>
                                    <option value="<?= $situacao->getId() ?>" <?= $object->getIdSituacao() == $situacao->getId() ? "selected" : "" ?>><?= $situacao->getSituacao() ?></option>
                                    <?php
                                }
                            }
                            ?>                            

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
                        <input type="text" class="form-control" id="marca" placeholder="Digite a marca do item.." name="marca" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getMarca() ?>" maxlength="70">                        
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>   
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Modelo</span>
                        <input type="text" class="form-control" id="modelo" placeholder="Digite o modelo do item.." name="modelo" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getModelo() ?>" maxlength="70">           
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Ano</span>
                        <input type="text" class="form-control" id="ano" name="ano" maxlength="4" placeholder="Exemplo: 1988" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getAno() ?>">
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
                        <span class="input-group-text">Local</span>
                        <input type="text" class="form-control" id="local" name="local" value="<?= $object->getLocal() ?>" maxlength="125">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>                                  
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Seção Responsável</span>
                        <select class="form-control" id="secaoResponsavel" name="secaoResponsavel">
                            <option value="escalao">Escalão</option>
                            <option value="peleq">Pelotão de Equipamentos</option>
                        </select> 
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">                                      
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Motivo</span>
                        <input type="text" class="form-control" id="motivo" name="motivo" placeholder="Motivo da indisponibilidade.." value="<?= $object->getMotivo() ?>" maxlength="70">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Necessidades</span>
                        <input type="text" class="form-control" id="motivoDetalhado" name="motivoDetalhado" placeholder="Motivo da indisponibilidade.." value="<?= $object->getMotivoDetalhado() ?>" maxlength="700">
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
                        <span class="input-group-text">Seção Responsável</span>
                        <input type="text" class="form-control" id="secaoResponsavel" name="secaoResponsavel" placeholder="Seção Responsável.." value="<?= $object->getSecaoResponsavel() ?>" maxlength="25">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
    <?php if ($object->getId() > 0) { ?>
        <hr>
        <div style="border: 1px dashed lightskyblue; padding: 7px;">                
            <span style="margin-left: 14px; font-weight: bold;">PROVIDÊNCIAS</span>        
        </div>
        <?php if (isAdminLevel($ADICIONAR_S4)) { ?>            
            <form accept-charset="UTF-8" action="../Controller/S4Controller.php?action=providencia_insert" class="needs-validation" novalidate method="post">
                <input type="hidden" name="idMaterial" value="<?= $object->getId() ?>">
                <div style="padding-top: 7px;">
                    <div class="form-row">
                        <div class="col-10">
                            <textarea class="form-control" name="providencia" rows="1"></textarea>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>    
                </div>
            </form>
        <?php } ?>
        <hr>
        <table class="table table-bordered" id="myTableM">
            <thead>            
                <tr>    
                    <th>Data</th>
                    <th>Providência</th>
                </tr>
            </thead>
            <tbody id="myTable">   
                <?php if (is_array($providenciaList)) { ?> 
                    <?php foreach ($providenciaList as $object): ?>
                        <tr>
                            <td><?= $object->getData() ?></td>
                            <td><?= $object->getProvidencia() ?></td>                                
                            <td style="white-space: nowrap">
                                <?php //if (isAdminLevel($EDITAR_S4)) { ?>
            <!--                                    <a href="../Controller/S4Controller.php?action=providencia_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>-->
                                <?php //} ?>
                                <?php if (isAdminLevel($EXCLUIR_S4)) { ?>
                                    <a href="#" onclick="confirm('Confirma a remoção do item?') ? document.location = '../Controller/S4Controller.php?action=providencia_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php } ?>
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

    function check(id) {
        var object = document.getElementById(id);
        var motivo = document.getElementById("motivo");
        var motivoDetalhado = document.getElementById("motivoDetalhado");
        var result = object.value === "1";
        motivo.disabled = result;
        motivoDetalhado.disabled = result;
    }

    check("idSituacao");
</script>
<?php
require_once '../include/footer.php';
