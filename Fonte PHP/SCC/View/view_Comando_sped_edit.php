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
if ($action === "sped_update" || $action === "sped_insert") {
    $button = '<button type="submit" class="btn btn-primary">Salvar</button>';
} else {
    $button = "<button type='button' class='btn btn-primary' onclick='document.location = history.back();'>Voltar</button>";
}
$pessoaList = $pessoaDAO->getAllList();
?>
<div class="container">     
    <form accept-charset="UTF-8" action="../Controller/ComandoController.php?action=sped_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post" onsubmit="dataListSwitch();" enctype="multipart/form-data">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Documento | <a href="#" onclick="history.back(-1);">Voltar</a> | <?= $button ?></h2>    
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>"> 
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tipo</span>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                &nbsp;<input type="radio" class="form-check-input" id="tipoDocumento" name="tipo" value="Documento" <?= $object->getTipo() == "Documento" || empty($object->getTipo()) ? "checked" : "" ?>>Documento
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="tipoMissao" name="tipo" value="Missao" <?= $object->getTipo() == "Missao" ? "checked" : "" ?>>Missão
                            </label>
                        </div>                        
                    </div>                    
                </div>   
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Título</span>
                        <input type="text" class="form-control" id="titulo" placeholder="Exemplo: DIEx nº 01-Comando/2º BE Cmb ou Ofício nº 01-Comando/2º BE Cmb" name="titulo" required value="<?= $object->getTitulo() ?>" maxlength="1150">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar título.</div>
                    </div>                    
                </div>   
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Assunto</span>
                        <input type="text" class="form-control" id="assunto" name="assunto" value="<?= $object->getAssunto() ?>" maxlength="1150">
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
                        <span class="input-group-text">Prazo</span>
                        <input type="date" class="form-control" id="prazo" name="prazo" required value="<?= $object->getPrazo() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Responsável</span>  
                        <?php
                        $pessoa = "";
                        $posto = "";
                        $nomeGuerra = "";
                        if ($object->getIdResponsavel() > 0) {
                            $pessoa = $pessoaDAO->getById($object->getIdResponsavel());
                            $posto = $postoDAO->getById($pessoa->getIdPosto())->getPosto();
                            $nomeGuerra = $pessoa->getNomeGuerra();
                        }
                        ?>
                        <input class="form-control" list="idResponsavel" name="idResponsavel" id="responsavelInput" value="<?= $posto . " " . $nomeGuerra ?>">                        
                        <datalist id="idResponsavel">
                            <?php
                            if (is_array($pessoaList)) {
                                foreach ($pessoaList as $pessoa):
                                    ?>
                                    <option data-id="<?= $pessoa->getId(); ?>" value="<?= $postoDAO->getById($pessoa->getIdPosto())->getPosto() . " " . $pessoa->getNomeGuerra(); ?>"><?= $postoDAO->getById($pessoa->getIdPosto())->getPosto() . " " . $pessoa->getNomeGuerra(); ?>                
                                        <?php
                                    endforeach;
                                }
                                ?>
                        </datalist>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar responsável.</div>
                    </div>                    
                </div>
            </div>
        </div>  
        <div class="form-group">
            <div class="form-row">                                            
                <div class="col">  
                    <div class="input-group-prepend">
                        <span class="input-group-text">Arquivo</span>
                        <div class="custom-control custom-switch">
                            <?php if (!str_contains($arquivoDAO->getArquivo($object->getId()), "semarquivo")) { ?>
                            <a href="../include/arquivos/<?= $object->getId(); ?>.pdf" target="_blank"><img src="../include/imagens/pdf.jpg" width="70"> <?=$object->getTitulo();?></a>
                            <?php } ?>
                            <input type="file" class="form-control" id="arquivo" name="arquivo">                        
                        </div>                    
                    </div>                
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="form-row">                                            
                    <div class="col">                    
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="resolvido" name="resolvido" <?= $object->getResolvido() == 1 ? "checked" : "" ?> value="1" onclick="labelResolvido();">
                            <label class="custom-control-label" for="resolvido" id="labelResolvido"><span style="color: red;font-weight: bold;">Não resolvido</span></label>
                        </div>                    
                    </div>                
                </div>
            </div>   
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

    function labelResolvido() {
        var resolvido = document.getElementById('resolvido').checked;
        if (resolvido === true) {
            document.getElementById('labelResolvido').innerHTML = "<span style='color: green;font-weight: bold;'>Resolvido</span>";
            resolvido = 1;
        } else {
            document.getElementById('labelResolvido').innerHTML = "<span style='color: red;font-weight: bold;'>Não resolvido</span>";
            resolvido = 0;
        }
    }

    function dataListSwitch() {
        const datalist = document.getElementById("idResponsavel");
        const value = document.getElementById("responsavelInput").value;
        const options = datalist.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].value === value) {
                document.getElementById("responsavelInput").value = options[i].dataset.id;
            }
        }
    }

    labelResolvido();
</script>
<?php
require_once '../include/footer.php';
