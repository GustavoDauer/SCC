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
$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
if ($action === "processo_update" || $action === "processo_insert") {
    $button = '<button type="submit" class="btn btn-primary">Salvar</button>';
} else {
    $button = "<button type='button' class='btn btn-primary' onclick='document.location = history.back();'>Voltar</button>";
}
?>
<div class="container">     
    <form accept-charset="UTF-8" action="../Controller/S1Controller.php?action=processo_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Processo | <a href="#" onclick="history.back(-1);">Voltar</a> | <?= $button ?></h2>    
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">        
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Responsável</span>
                        <input type="text" class="form-control" id="responsavel" placeholder="Digite o nome de guerra do responsável.." name="responsavel" oninput="this.value = this.value.toUpperCase();" onkeyup="manager();" required value="<?= $object->getResponsavel() ?>" maxlength="70">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar responsável.</div>
                    </div>                    
                </div>    
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tipo</span>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option disabled selected>Escolha o tipo do processo</option>
                            <option value="Processo Administrativo" <?= $object->getTipo() == "Processo Administrativo" ? "selected" : "" ?>>Processo Administrativo</option>
                            <option value="Sindicancia" <?= $object->getTipo() == "Sindicancia" ? "selected" : "" ?>>Sindicância</option>
                            <option value="IPM" <?= $object->getTipo() == "IPM" ? "selected" : "" ?>>IPM</option>
                            <option value="Processo de averiguacao" <?= $object->getTipo() == "Processo de averiguacao" ? "selected" : "" ?>>Processo de averiguação</option>
                            <option value="TCA ADM" <?= $object->getTipo() == "TCA ADM" ? "selected" : "" ?>>TCA ADM</option>
                            <option value="PAS" <?= $object->getTipo() == "PAS" ? "selected" : "" ?>>PAS</option>
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
                        <span class="input-group-text">Portaria</span>
                        <input type="text" class="form-control" id="portaria" placeholder="Portaria de abertura do processo.." name="portaria" required value="<?= $object->getPortaria() ?>" maxlength="250">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar portaria de abertura.</div>
                    </div>                    
                </div>    
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Assunto</span>
                        <input type="text" class="form-control" id="assunto" placeholder="Digite o assunto do processo.." name="assunto" required value="<?= $object->getAssunto() ?>" maxlength="70">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar assunto.</div>
                    </div>                    
                </div>
            </div>
        </div>                               
        <div class="form-group">
            <div class="form-row">                                            
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Início</span>
                        <input type="date" class="form-control" id="dataInicio" name="dataInicio" required value="<?= $object->getDataInicio() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar data de início.</div>
                    </div>
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Prazo</span>
                        <input type="date" class="form-control" id="dataPrazo" name="dataPrazo" required value="<?= $object->getDataPrazo() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>

            </div>
        </div>                     
        <hr>
        <h6>Conclusão do processo</h6>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Solução</span>
                        <input type="text" class="form-control" id="solucao" placeholder="Boletim de publicação da solução.." name="solucao" value="<?= $object->getSolucao() ?>" onkeyup="check();" maxlength="250">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data do protocolo</span>
                        <input type="date" class="form-control" id="dataFim" name="dataFim" value="<?= $object->getDataFim() ?>" onkeyup="check();" title="Disponível após preencher solução">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
            </div>                    
        </div>
        <hr>
        <h6>Última Prorrogação</h6>
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Prorrogação</span>
                        <input type="text" class="form-control" id="prorrogacao" placeholder="Documento de prorrogação do processo.." name="prorrogacao" value="<?= $object->getProrrogacao() ?>" onkeyup="check();" maxlength="125">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>   
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Prazo</span>
                        <input type="date" class="form-control" id="prorrogacaoPrazo" name="prorrogacaoPrazo" value="<?= $object->getProrrogacaoPrazo() ?>" onkeyup="check();">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>                
            </div>
        </div>
        <hr>
        <?= $button; ?>        
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

    function check() {
        var solucao = document.getElementById("solucao");
        var dataFim = document.getElementById("dataFim");
//        var result = solucao.value === "";
//        dataFim.disabled = result;
//        if (solucao.value != "") {
//            dataFim.required = true;
//        } else {
//            dataFim.required = false;
//        }
//        if (dataFim.value != "") {
//            solucao.required = true;
//        } else {
//            solucao.required = false;
//        }
        var prorrogacao = document.getElementById('prorrogacao');
        var prorrogacaoPrazo = document.getElementById('prorrogacaoPrazo');
        var result = prorrogacao.value === "";
        prorrogacaoPrazo.disabled = result;
        if (prorrogacao.value != "") {
            prorrogacaoPrazo.required = true;
        } else {
            prorrogacaoPrazo.required = false;
        }
//        if (prorrogacaoPrazo.value != "") {
//            prorrogacao.required = true;
//        } else {
//            prorrogacao.required = false;
//        }       
    }
    check();
</script>
<?php
require_once '../include/footer.php';
