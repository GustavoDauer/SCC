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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>
<script type="text/javascript">
    function excluir(id, idRequisicao) {
        if (confirm('Tem certeza que deseja excluir esse item?\n\nAo prosseguir, os dados editados nesse formulário não serão salvos. A página irá recarregar com a exclusão do item, exibindo os últimos dados salvos ao clicar no botão Salvar. Atentar para correção de valores que deve ser feita manualmente após a exclusão do item.')) {
            document.location = 'FiscalizacaoController.php?action=delete_item&idItem=' + id + "&id=" + idRequisicao;
        }
        return false;
    }    

    function minimizeByDefault() {
        minimize('requisitante');
        minimize('salc');
        minimize('conformidade');
        minimize('almoxarifado');
        minimize('tesouraria');
    }

    function maximizeByDefault() {
        maximize('requisitante');
        maximize('salc');
        maximize('conformidade');
        maximize('almoxarifado');
        minimize('tesouraria');
    }
</script>
<style type="text/css">
    .subtitulo {
        font-weight: bold;
    }

    .timeline {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style-type: none;
    }

    .timestamp {
        margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #ffcccc;
        font-size: 14px;
    }

    .timestampCompleted {
        margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #00cc00;
        font-size: 14px;
    }

    .timestampYellow {
        margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #cccc00;
        font-size: 14px;
    }
    
    .timestampNext {
        margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: red;
        font-size: 14px;
    }

    .status {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border-top: 2px solid;
        border-right: 2px solid;
        border-bottom: 2px solid;
        border-radius: 70px;
        border-color: #ffcccc;
        height: 115px;
        /*background-color: #ffcccc;*/
    }

    .statusCompleted {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border: 2px solid;
        /*        border-left: 2px solid; 
                border-right: 2px solid; */
        border-radius: 70px;
        border-color: #00cc00;
        height: 115px;
        background-color: #ccffcc;
    }
    
    .statusYellow {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border-top: 2px solid;
        border-right: 2px solid;
        border-bottom: 2px solid;
        border-radius: 70px;
        border-color: #cccc00;
        height: 115px;
        /*background-color: #ffcccc;*/
    }

    .statusNext {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border-top: 2px solid;
        border-right: 2px solid;
        border-bottom: 2px solid;
        border-radius: 70px;
        border-color: red;
        height: 115px;
        /*background-color: #ffcccc;*/
    }

    .status h4 {
        color: white;
        font-weight: bold;
        font-size: 12px;
        margin-top: 7px;
    }

    .statusCompleted h4 {
        color: #00cc00;
        font-weight: bold;
        font-size: 12px;
        margin-top: 7px;
    }
    
    .statusYellow h4 {
        color: #cccc00;
        font-weight: bold;
        font-size: 12px;
        margin-top: 7px;
    }

    .statusNext h4 {
        color: red;
        font-weight: bold;
        font-size: 12px;
        margin-top: 7px;
    }

    .explanation {
        font-size: 12px;
        color: red;
    }

    .itensTable th, td {
        border: 1px dotted lightblue;
    }
</style>
<div class="conteudo">  
    <form accept-charset="UTF-8" action="../Controller/FiscalizacaoController.php?action=<?= $object->getId() > 0 ? 'update' : 'insert' ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post" name="requisicao" id="requisicao">
        <h2><?= $object->getId() > 0 ? "Editar" : "Cadastrar" ?> Requisição | <a href="#" onclick="document.location = 'FiscalizacaoController.php?action=getAllList';">Voltar</a> | <button type="submit" class="btn btn-success">Salvar</button></h2>    
        <hr> 
        <?php

        function checkPrazo($dataPrazo) {
            $hoje = new DateTime();
            $dateDif = date_diff($hoje, new DateTime($dataPrazo));
            $situacao = "";
            if(empty($dataPrazo)) {
                $situacao = "<span class='alert alert-danger'><b>Prazo não estipulado</b></span>";
            } else if ($dateDif->format('%a') > 0 && $dateDif->format('%R') === "-") {
                $situacao = "<span class='alert alert-danger'><b>" . dateFormat($dataPrazo) . "</b> Prazo vencido há " . $dateDif->format('%a') . " dia(s)</span>";
            } else if ($dateDif->format('%a') >= 0 && $dateDif->format('%a') < 7 && $dateDif->format('%R') === "+") {
                $situacao = "<span class='alert alert-warning'><b>" . dateFormat($dataPrazo) . "</b> Prazo vencendo em " . $dateDif->format('%a') . " dia(s)</span>";
            } else if ($dateDif->format('%a') >= 7 && $dateDif->format('%R') === "+") {
                $situacao = "<span class='alert alert-success'><b>" . dateFormat($dataPrazo) . "</b> Prazo vencendo em " . $dateDif->format('%a') . " dia(s)</span>";
            }

            return $situacao;
        }

        $button = "<div class='form-group' align='center'><button type='submit' class='btn btn-success'>Salvar</button></div>";
        $timeline = new Timeline($object);
        $object->setTimeline($timeline);
        $requisitante = $timeline->getRequisitante();
        $salc1 = $timeline->getSalc1();
        $conformidade = $timeline->getConformidade();
        $salc2 = $timeline->getSalc2();
        $almox = $timeline->getAlmox();
        $tesouraria = $timeline->getTesouraria();                
        ?>
        <div>
            <ul class="timeline">
                <li>
                    <div class="timestamp<?= $requisitante[0]; ?>" id="requisitanteTimestamp">
                        REQUISITANTE 
                    </div>
                    <div class="status<?= $requisitante[0]; ?>" id="requisitanteStatus">
                        <h4><?= $requisitante[1]; ?></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp<?= $salc1[0]; ?>" id="salc1Timestamp">
                        SALC
                    </div>
                    <div class="status<?= $salc1[0]; ?>" id="salc1Status">
                        <h4><?= $salc1[1]; ?></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp<?= $conformidade[0]; ?>" id="conformidadeTimestamp">
                        CONFORMIDADE
                    </div>
                    <div class="status<?= $conformidade[0]; ?>" id="conformidadeStatus">
                        <h4><?= $conformidade[1]; ?></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp<?= $salc2[0]; ?>" id="salc2Timestamp">
                        SALC
                    </div>
                    <div class="status<?= $salc2[0]; ?>" id="salc2Status">
                        <h4><?= $salc2[1]; ?></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp<?= $almox[0]; ?>" id="almoxarifadoTimestamp">
                        <?= $object->getResponsavel() === "Aprovisionamento" ? "APROVISIONAMENTO" : "ALMOXARIFADO" ?>
                    </div>
                    <div class="status<?= $almox[0]; ?>" id="almoxarifadoStatus">
                        <h4><?= $almox[1]; ?></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp<?= $tesouraria[0]; ?>" id="tesourariaTimestamp">
                        TESOURARIA
                    </div>
                    <div class="status<?= $tesouraria[0]; ?>" id="tesourariaStatus">
                        <h4><?= $tesouraria[1]; ?></h4>
                    </div>
                </li>
            </ul>
        </div>  
        <?php
        $readonly = true;
        if ($object->getIdSecao() > 0) { // Verifica se há seção definida no objeto
            $secao = $secaoDAO->getById($object->getIdSecao());
            $isOwner = isAdminLevel(array($secao->getSecao())); // Verifica se o usuário é dono da requisição
        } else {
            $isOwner = true; // Como não há seção definida no objeto, trata-se de uma adição, logo o usuário é dono da requisição
        }
        if (isAdminLevel($REQUISITANTES) && $isOwner) { // Verifica se é requisitante e se é o dono
            $readonly = false;
        }                
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">            
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('requisitante');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('requisitante');"> 
                REQUISITANTE
            </h2>
            <div id="requisitante">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data Requisição</span>
                                <input type="date" class="form-control" id="dataRequisicao" name="dataRequisicao" value="<?= empty($object->getDataRequisicao()) ? date('Y-m-d') : $object->getDataRequisicao(); ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data em que a requisição foi feita pela Seção Requisitante.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">OM</span>                        
                                <select class="form-control" name="om" <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="2becmb" <?= $object->getOm() === "2becmb" ? "selected" : "" ?>>2º BE Cmb</option>
                                    <option value="11cia" <?= $object->getOm() === "11cia" ? "selected" : "" ?>>11ª Cia E Cmb L</option>
                                    <option value="12cia" <?= $object->getOm() === "12cia" ? "selected" : "" ?>>12ª Cia E Cmb L</option>
                                </select>
                            </div>                    
                        </div>   
                        <div class="col">
                            <span class="explanation">Organização Militar responsável pelo empenho.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Seção</span>                        
                                <select class="form-control" name="idSecao" <?= !$readonly ? "" : "disabled" ?>>
                                    <?php
                                    if (!empty($secaoList) && $secaoList != null) {
                                        foreach ($secaoList as $secao) {
                                            if ($object->getIdSecao() > 0) {
                                                ?>
                                                <option value="<?= $secao->getId() ?>" <?= $secao->getId() == $object->getIdSecao() ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                                <?php
                                            } else { // First section that the user belongs will be used by default
                                                if (!isset($_SESSION["sccsecoes"][0])) {
                                                    throw new Exception("Seção indefinida!");
                                                }
                                                ?>
                                                <option value="<?= $secao->getId() ?>" <?= $secao->getSecao() == $_SESSION["sccsecoes"][0]->getSecao() ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div> 
                        <div class="col">
                            <span class="explanation">Seção responsável pela requisição.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nota de Crédito</span>
                                <select class="form-control" name="idNotaCredito" <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled <?= $object->getIdNotaCredito() > 0 ? "" : " selected"; ?>>Selecione uma nota de crédito</option>
                                    <?php
                                    $notaCreditoList = $notaCreditoDAO->getAllList();
                                    if (!empty($notaCreditoList) && $notaCreditoList != null) {
                                        foreach ($notaCreditoList as $notaCredito) {
                                            ?>
                                            <option value="<?= $notaCredito->getId() ?>" <?= $notaCredito->getId() == $object->getIdNotaCredito() ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                            <?php
                                        }
                                    } else if ($object->getIdNotaCredito() > 0) {
                                        $notaCredito = $notaCreditoDAO->getById($object->getIdNotaCredito());
                                        ?>
                                        <option value="<?= $notaCredito->getId() ?>" <?= $notaCredito->getId() == $object->getIdNotaCredito() ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                        <?php
                                    } else {
                                        $notaCreditoList = $notaCreditoDAO->getAllList(array("notaCreditoAtivas" => 0));
                                        if (!empty($notaCreditoList) && $notaCreditoList != null) {
                                            foreach ($notaCreditoList as $notaCredito) {
                                                ?>
                                                <option value="<?= $notaCredito->getId() ?>" <?= $notaCredito->getId() === $object->getIdNotaCredito() ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Nota de crédito cadastrada pela SALC.</span>
                        </div>
                    </div>
                </div>                
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Categoria</span>
                                <select class="form-control" name="idCategoria" <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled <?= $object->getIdCategoria() > 0 ? "" : " selected" ?>>Escolha uma categoria para requisição</option>
                                    <?php
                                    if (!empty($categoriaList) && $categoriaList != null) {
                                        foreach ($categoriaList as $categoria) {
                                            ?>
                                            <option value="<?= $categoria->getId() ?>" <?= $categoria->getId() == $object->getIdCategoria() ? " selected" : "" ?>><?= $categoria->getCategoria() ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Categoria a que se refere o empenho, cadastrada pelo Almoxarifado.</span>
                        </div>
                    </div>
                </div>        
                <h2 class="subtitulo">Dados da modalidade de compra</h2>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Modalidade</span>
                                <select name="modalidade" class="form-control" <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled <?= !empty($object->getModalidade()) ? "" : " selected" ?>>Escolha uma modalidade para requisição</option>
                                    <option value="pe" <?= $object->getModalidade() === "pe" ? "selected" : "" ?>>Pregão Eletrônico</option>
                                    <option value="ce" <?= $object->getModalidade() === "ce" ? "selected" : "" ?>>Cotação Eletrônica</option>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Modalidade da compra usada para empenho.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Identificador da modalidade</span>
                                <input type="text" class="form-control" id="numeroModalidade" placeholder="Exemplo: 01  (Cotação Eletrônica nº 01)" name="numeroModalidade" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getNumeroModalidade() ?>"  <?= !$readonly ? "" : "disabled" ?> onchange="checkZeroFillFields(this);" />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Número do pregão, cotação eletrônica ou outra modalidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row"> 
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Código UG</span>
                                <input type="text" class="form-control" id="ug" placeholder="Exemplo: 160477" name="ug" maxlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getUg() ?>" <?= !$readonly ? "" : "disabled" ?> onchange="checkZeroFillFields(this);" />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">UASG da unidade Gestora da modalidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row"> 
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">UG</span>
                                <input type="text" class="form-control" id="omModalidade" placeholder="Exemplo: 2º BE Cmb" name="omModalidade" maxlength="125" value="<?= $object->getOmModalidade() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                             
                        </div>
                        <div class="col">
                            <span class="explanation">Organização Militar responsável pela modalidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Empresa</span>
                                <input type="text" class="form-control" id="empresa" placeholder="Nome da Empresa responsável" name="empresa" maxlength="250" value="<?= $object->getEmpresa() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Nome da empresa responsável pelos materiais.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row"> 
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">CNPJ</span>
                                <input type="text" class="form-control" id="cnpj" placeholder="CNPJ da Empresa responsável" name="cnpj" maxlength="18"  onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getCnpj() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">CNPJ da empresa responsável pelos materiais.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Contato</span>
                                <textarea class="form-control" name="contato" placeholder="Informações de contato da Empresa responsável" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getContato() ?></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Informações de contato da empresa responsável pelos materiais.</span>
                        </div>
                    </div>
                </div>  
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data Protocolo na SALC</span>
                                <input type="date" class="form-control" id="dataProtocoloSalc1" name="dataProtocoloSalc1" value="<?= $object->getDataProtocoloSalc1() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data em que a requisição foi protocolada na SALC.</span>
                        </div>
                    </div>
                </div>
                <?= $button ?>
            </div>
        </div>        
        <br>        
        <?php
        $readonly = true;
        if (isAdminLevel($SALC)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">                  
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('salc');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('salc');"> 
                SALC
            </h2>
            <div id="salc">
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data NE</span>
                                <input type="date" class="form-control" id="dataNE" name="dataNE" value="<?= $object->getDataNE() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data da Nota de Empenho pela SALC.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tipo da Nota de Empenho</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="tipoNE" name="tipoNE" value="ordinario" <?= $object->getTipoNE() == "ordinario" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Ordinário</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="tipoNE" name="tipoNE" value="global" <?= $object->getTipoNE() == "global" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Global/Estimativa</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Tipo da Nota de Empenho.</span>
                        </div>
                    </div>
                </div>  
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tipo da Nota Fiscal</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="tipoNF" name="tipoNF" value="material" <?= $object->getTipoNF() == "material" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Material</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="tipoNF" name="tipoNF" value="servico" <?= $object->getTipoNF() == "servico" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Serviço</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Tipo da Nota Fiscal.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Responsável pelo recebimento</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="responsavel" name="responsavel" value="Almoxarifado" <?= $object->getResponsavel() == "Almoxarifado" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Almoxarifado</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="responsavel" name="responsavel" value="Aprovisionamento" <?= $object->getResponsavel() == "Aprovisionamento" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Aprovisionamento</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Responsável pela verificação dos produtos/serviços.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">NE</span>
                                <input type="text" class="form-control" id="ne" placeholder="Nota de Empenho" name="ne" maxlength="12" onkeypress="return event.charCode === 78 || event.charCode === 69 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getNe() ?>" <?= !$readonly ? "" : "disabled" ?>/>
                            </div>  
                        </div>
                        <div class="col">
                            <span class="explanation">Número da Nota de Empenho.</span>
                        </div>
                    </div> 
                </div>
                <h2 class="subtitulo">Itens</h2>
                <div id="itensInseridos" style="margin: 7px;">                    
                    <table border="0" cellpadding="7" cellspacing="0" width="100%" class="itensTable">
                        <tr>
                            <th width="10%">Número do item</th>
                            <th width="60%">Descrição</th>
                            <th width="10%">Quantidade</th>
                            <th width="10%">Valor Unitário</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                        <?php
                        $totalValue = 0.0;
                        if (isset($itemList) && is_array($itemList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                            $i = 0;
                            foreach ($itemList as $item) {
                                $totalValue += (float) str_replace(",", ".", $item->getValor()) * (int) $item->getQuantidade();
                                ?> 
                                <tr style="background-color: <?= $i % 2 == 0 ? "#fffef3" : "white" ?>;">
                                    <td><?= $item->getNumeroItem() ?></td>
                                    <td><?= $item->getDescricao() ?></td>
                                    <td><?= $item->getQuantidade() ?></td>
                                    <td>R$ <?= $item->getValor() ?></td>
                                    <td><input type="button" class="btn btn-danger" value="Excluir" onclick="excluir(<?= $item->getId() . ", " . $object->getId() ?>);" <?= !$readonly ? "" : "disabled" ?>></td> 
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><b>R$ <?= number_format($totalValue, 2, ",", ".") ?></b></td>
                            <td>&nbsp;</td>
                    </table>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-row">                
                            <div class="col">                    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Número do item</span>
                                    <input type="number" class="form-control" id="numeroItem" name="numeroItem" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" <?= !$readonly ? "" : "disabled" ?> />
                                </div>                          
                            </div>                       
                            <div class="col">                    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Descrição</span>
                                    <input type="text" class="form-control" id="descricao" name="descricaoItem" maxlength="500" <?= !$readonly ? "" : "disabled" ?> />
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Valor Unitário</span>
                                    <input type="text" class="form-control" id="valor" name="valor" maxlength="25" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" onchange="fillValor();" <?= !$readonly ? "" : "disabled" ?> />
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Quantidade</span>
                                    <input type="number" class="form-control" id="quantidade" name="quantidade" maxlength="25" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onchange="fillValor();" <?= !$readonly ? "" : "disabled" ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="itens">
                </div>
                <script type="text/javascript">
                    var total = 0;
                    function adicionarItens() {
                        total++;
                        var itens = document.getElementById("itens");
                        var novoItem = "";
                        novoItem += "<hr><div class = 'form-group'><div class = 'form-row'><div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Número do item</span>";
                        novoItem += "<input type='hidden' id='idItem' name='idItem" + total + "' value=''/><input type = 'number' class = 'form-control' id = 'numeroItem" + total + "' name = 'numeroItem" + total + "' maxlength = '7'/>";
                        novoItem += "</div></div>"
                        novoItem += "<div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Descrição</span><input type = 'text' class = 'form-control' id = 'descricaoItem" + total + "' name = 'descricaoItem" + total + "' maxlength = '500' /></div></div></div></div>";
                        novoItem += "<div class = 'form-group'><div class = 'form-row'><div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Valor Unitário</span><input type = 'text' class = 'form-control' id = 'valor" + total + "' name = 'valor" + total + "' maxlength = '25' onkeypress='return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);' onchange='fillValor();' /></div></div>";
                        novoItem += "<div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Quantidade</span><input type = 'number' class = 'form-control' id = 'quantidade" + total + "' name = 'quantidade" + total + "' maxlength = '25' onkeypress='return event.charCode >= 48 && event.charCode <= 57;' onchange='fillValor();' /></div></div></div></div>";
                        itens.innerHTML = itens.innerHTML + novoItem;
                    }

                    function fillValor() {
                        var valor = parseFloat(document.getElementById("valor").value.replace(",", "."));
                        var quantidade = parseInt(document.getElementById("quantidade").value.replace(",", "."));
                        var totalValue = <?= $totalValue ?> + (valor * quantidade);
                        //alert(totalValue);
                        for (var i = 1; i <= total; i++) {
                            valor = parseFloat(document.getElementById("valor" + i).value.replace(",", "."));
                            //alert(valor);
                            quantidade = parseInt(document.getElementById("quantidade" + i).value.replace(",", "."));
                            //alert(quantidade);
                            totalValue = eval(parseFloat(totalValue) + (valor * quantidade));
                            //alert(totalValue);
                        }
                        document.getElementById("valorNE").value = !isNaN(totalValue) ? parseFloat(totalValue).toFixed(2).toString().replace(".", ",") : 0;
                    }
                </script>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">  
                            <a onclick="adicionarItens();
                               " style="color: blue;
                               text-decoration: underline;
                               " <?= !$readonly ? "" : "disabled" ?>>Adicionar mais itens</a>
                        </div>                                             
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Valor Total R$</span>
                                <input type="text" class="form-control" id="valorNE" name="valorNE" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorNE(); ?>" placeholder="Valor empenhado da nota de empenho" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>  
                        <div class="col">
                            <span class="explanation">Valor empenhado pela SALC até o momento.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Observação</span>
                                <textarea class="form-control" id="observacaoSALC" name="observacaoSALC" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoSALC(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Observações relativas aos procedimentos da SALC.</span>
                        </div>
                    </div>                    
                </div> 
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data Protocolo na Conformidade</span>
                                <input type="date" class="form-control" id="dataProtocoloConformidade" name="dataProtocoloConformidade" value="<?= $object->getDataProtocoloConformidade() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data em que a requisição foi protocolada na Conformidade.</span>
                        </div>
                    </div>
                </div>
                <?= $button ?>
            </div>
        </div>
        <br>        
        <?php
        $readonly = true;
        if (isAdminLevel($CONFORMIDADE)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('conformidade');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('conformidade');"> 
                CONFORMIDADE
            </h2>
            <div id="conformidade">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data</span> 
                                <input type="date" class="form-control" name="dataParecer" value="<?= $object->getDataParecer() ?>" <?= !$readonly ? "" : "disabled" ?>>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Data do parecer da Conformidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Parecer</span>
                                &nbsp;
                                <input type="radio" id="parecer" name="parecer" value="1" <?= $object->getParecer() == 1 ? " checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> Aprovado &nbsp;
                                <input type="radio" id="parecer" name="parecer" value="0" <?= $object->getParecer() == 0 ? " checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> Desaprovado
                            </div>                    
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Observação</span>
                                <textarea class="form-control" id="observacaoConformidade" name="observacaoConformidade" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoConformidade(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Observações da Seção de Conformidade e Gestão.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data da assinatura do OD</span> 
                                <input type="date" class="form-control" name="dataAssinatura" value="<?= $object->getDataAssinatura() ?>" <?= !$readonly ? "" : "disabled" ?>>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Data da assinatura do Ordernador de Despesas.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data Protocolo na SALC</span>
                                <input type="date" class="form-control" id="dataProtocoloSalc2" name="dataProtocoloSalc2" value="<?= $object->getDataProtocoloSalc2() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data em que a requisição foi protocolada na SALC pela CONFORMIDADE.</span>
                        </div>
                    </div>
                </div>
                <?= $button ?>
            </div>
        </div>
        <br> 
        <?php
        $readonly = true;
        if (isAdminLevel($SALC)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">                  
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('salc2');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('salc2');"> 
                SALC
            </h2>
            <div id="salc2">                                                                                   
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de Envio NE</span>
                                <input type="date" class="form-control" id="dataEnvioNE" name="dataEnvioNE" value="<?= $object->getDataEnvioNE() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data de envio da Nota de Empenho pela SALC ao Almoxarifado/Aprovisionamento.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Houve anulação de valores?</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="anulou" name="anulou" value="1" <?= !empty($object->getValorAnulado()) && $object->getValorAnulado() > 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?> onclick="checkVA(this.value);" /> 
                                <label class="form-check-label">Sim</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="anulou" name="anulou" value="0" <?= empty($object->getValorAnulado()) || $object->getValorAnulado() == 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>  onclick="checkVA(this.value);" /> 
                                <label class="form-check-label">Não</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="valorAnuladoField" style="display: <?= !empty($object->getValorAnulado()) && $object->getValorAnulado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Valor anulado</span>
                                <input type="text" class="form-control" id="valorAnulado" name="valorAnulado" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorAnulado(); ?>" placeholder="Valor anulado da nota de empenho" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>  
                        <div class="col">
                            <span class="explanation">Valor anulado pela SALC até o momento.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="justificativaField" style="display: <?= !empty($object->getValorAnulado()) && $object->getValorAnulado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Justificativa</span>
                                <textarea class="form-control" id="justificativaAnulado" name="justificativaAnulado" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getJustificativaAnulado(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Justificativas relativas aos procedimentos de valores anulados pela SALC.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Houve reforço de valores?</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="reforcou" name="reforcou" value="1" <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?> onclick="checkRV(this.value);" /> 
                                <label class="form-check-label">Sim</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="reforcou" name="reforcou" value="0" <?= empty($object->getValorReforcado()) || $object->getValorReforcado() == 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>  onclick="checkRV(this.value);" /> 
                                <label class="form-check-label">Não</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="valorReforcoField" style="display: <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Valor reforçado</span>
                                <input type="text" class="form-control" id="valorReforcado" name="valorReforcado" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorReforcado(); ?>" placeholder="Valor reforçado" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>  
                        <div class="col">
                            <span class="explanation">Valor reforçado pela SALC até o momento.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="observacoesReforcoField" style="display: <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Observações</span>
                                <textarea class="form-control" id="observacaoReforco" name="observacaoReforco" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoReforco(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Observações relativas aos procedimentos de valores reforçados pela SALC.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group" id="idNotaCreditoField" style="display: <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nota de Crédito Reforço</span>
                                <select class="form-control" name="idNotaCreditoReforco" <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled <?= $object->getIdNotaCreditoReforco() > 0 ? "" : "selected"; ?>>Selecione uma nota de crédito</option>
                                    <?php
                                    $notaCreditoReforcoList = $notaCreditoDAO->getAllList();
                                    if (!empty($notaCreditoReforcoList) && $notaCreditoReforcoList != null) {
                                        foreach ($notaCreditoReforcoList as $notaCredito) {
                                            ?>
                                            <option value="<?= $notaCredito->getId() ?>" <?= $notaCredito->getId() == $object->getIdNotaCreditoReforco() ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Nota de crédito usada para o reforço.</span>
                        </div>
                    </div> 
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data Protocolo no Almoxarifado/Aprovisionamento</span>
                                <input type="date" class="form-control" id="dataProtocoloAlmox" name="dataProtocoloAlmox" value="<?= $object->getDataProtocoloAlmox() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data em que a requisição foi protocolada no Almoxarifado/Aprovisionamento.</span>
                        </div>
                    </div>
                </div>
                <?= $button ?>
            </div>
        </div>
        <br>
        <?php
        $readonly = true;
        if (isAdminLevel($ALMOXARIFADO) || isAdminLevel($TESOURARIA)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('almoxarifado');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('almoxarifado');"> 
                <?= $object->getResponsavel() === "Aprovisionamento" ? "APROVISIONAMENTO" : "ALMOXARIFADO" ?>
            </h2>   
            <div id="almoxarifado">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de envio NE à empresa</span>
                                <input type="date" class="form-control" id="dataEnvioNEEmpresa" name="dataEnvioNEEmpresa" value="<?= $object->getDataEnvioNEEmpresa(); ?>" onchange="checkDataPrazoEntrega(this.value);"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data de envio da Nota de Empenho à empresa</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Prazo para entrega do material/serviço</span>
                                <?php
                                $dataPrazoEntrega = $object->getDataEnvioNEEmpresa(); // ToDo            
                                $dataPrazoEntrega = strval($dataPrazoEntrega);
                                $novaData = new DateTime("$dataPrazoEntrega");
                                $novaData->add(new DateInterval('P30D'));
                                $dataPrazoEntrega = $novaData->format('Y-m-d');
                                $dataPrazoEntrega = empty($object->getDataPrazoEntrega()) ? $dataPrazoEntrega : $object->getDataPrazoEntrega();
                                // Caso sejam empenhos não ordinários, o prazo de entrega pode se estender por muito mais de 30 dias
                                ?>
                                <input type="date" class="form-control" id="dataPrazoEntrega" name="dataPrazoEntrega" value="<?= $dataPrazoEntrega ?>" />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Prazo para entrega do material/serviço.</span>
                        </div>
                    </div>
                </div>            
                <div class="form-group">
                    <div class="form-row">                                    
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data do 1º Ofício de notificação à empresa</span>
                                <input type="date" class="form-control" id="dataOficio" name="dataOficio" value="<?= $object->getDataOficio(); ?>"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data do 1º Ofício de Notificação à empresa.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Houve abertura de Processo Administrativo?</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="abriuPA" name="abriuPA" value="1" <?= !empty($object->getDiex()) ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?> onclick="checkPA(this.value);" /> 
                                <label class="form-check-label">Sim</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="abriuPA" name="abriuPA" value="0" <?= empty($object->getDiex()) ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>  onclick="checkPA(this.value);" /> 
                                <label class="form-check-label">Não</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="diexField" style="display: <?= !empty($object->getDiex()) ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">DIEx solicitando abertura de PA</span>
                                <input type="text" class="form-control" id="diex" name="diex" maxlength="125" value="<?= $object->getDiex(); ?>"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Número DIEx solicitando abertura de Processo Administrativo.</span>
                        </div>                                               
                    </div>
                </div>
                <div class="form-group" id="dataDiexField" style="display: <?= !empty($object->getDiex()) ? "" : "none;" ?>">
                    <div class="form-row">                                    
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data do DIEx solicitando abertura de PA</span>
                                <input type="date" class="form-control" id="dataDiex" name="dataDiex" value="<?= $object->getDataDiex(); ?>"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data do DIEx solicitando abertura de Processo Administrativo.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="idProcessoField" style="display: <?= !empty($object->getDiex()) ? "" : "none;" ?>">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Processo Administrativo</span>
                                <select name="idProcesso" class="form-control">
                                    <option>Selecione o processo administrativo</option>
                                    <?php
                                    if (!empty($processoList) && $processoList != null) {
                                        foreach ($processoList as $processo) {
                                            ?>
                                            <option value="<?= $processo->getId() ?>" <?= $processo->getId() == $object->getIdProcesso() ? "selected" : "" ?>><?= $processo->getPortaria() ?> - <?= $processo->getTipo() ?> ( <?= $processo->getAssunto() ?>) - <?= $processo->getResponsavel() ?></option>                             
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Processo Administrativo aberto para apuração.</span>
                        </div>                                                
                    </div>
                </div>  
                <?= $button ?>
            </div>
            <a name="notasFiscais">&nbsp;</a>                
            <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
                <h2 class="alert alert-info">
                    <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('tesouraria');"> 
                    <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('tesouraria');"> 
                    <?= $object->getResponsavel() === "Aprovisionamento" ? "APROVISIONAMENTO" : "ALMOXARIFADO" ?> / TESOURARIA
                </h2>
                <div id="tesouraria"> 
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">                    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Observação</span>
                                    <textarea class="form-control" id="observacaoAlmox" name="observacaoAlmox" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoAlmox(); ?></textarea>
                                </div>                    
                            </div>
                            <div class="col">
                                <span class="explanation">Observações relativas ao Almoxarifado/Aprovisionamento e/ou Tesouraria.</span>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="notasCredito">
                        <thead>                            
                            <tr>
                                <?php if ($object->getTipoNE() !== "ordinario") { ?>
                                    <th>Data Pedido</th>  
                                <?php } ?>
                                <th>NF<?= $object->getTipoNF() === "servico" ? "S" : "" ?></th>
                                <th>Valor NF<?= $object->getTipoNF() === "servico" ? "S" : "" ?></th>
                                <?php if ($object->getTipoNE() !== "ordinario") { ?>
                                    <th>Data Prazo</th>
                                <?php } ?>
                                <th>Data Entrega</th>
                                <th>Data Remessa Tesouraria</th>                             
                                <th>Data Liquidação</th>                                
                                <th>
                                    <?php if (isAdminLevel($ADICIONAR_FISCALIZACAO)) { ?>
                                        <a href="../Controller/FiscalizacaoController.php?action=insert_nf&idRequisicao=<?= $object->getId(); ?>"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                                    <?php } ?>
                                </th>                
                            </tr>
                        </thead>        
                        <tbody>
                            <?php
                            if (isset($notaFiscalList) && is_array($notaFiscalList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                                foreach ($notaFiscalList as $NFobject) {
                                    ?> 
                                    <tr>
                                        <?php if ($object->getTipoNE() !== "ordinario") { ?>
                                            <td><?= dateFormat($NFobject->getDataPedido()) ?></td>
                                        <?php } ?>
                                        <td><?= $NFobject->getNf() ?></td>
                                        <td>R$ <?= $NFobject->getValorNF() ?></td>
                                        <?php if ($object->getTipoNE() !== "ordinario") { ?>
                                            <td>                                                    
                                                <?= empty($NFobject->getDataLiquidacao()) ? checkPrazo($NFobject->getDataPrazoEntrega()) : "<span class='alert alert-success'><b>Liquidado</b></span>" ?>                                            
                                            </td>
                                        <?php } ?>
                                        <td><?= dateFormat($NFobject->getDataEntrega()) ?></td>
                                        <td><?= dateFormat($NFobject->getDataRemessaTesouraria()) ?></td>
                                        <td><input type="hidden" name="dataLiquidacao" value="<?= $NFobject->getDataLiquidacao() ?>"><?= $NFobject->getDataLiquidacao() ?></td>                               
                                        <td>
                                            <?php if (isAdminLevel($EDITAR_FISCALIZACAO)) { ?>
                                                <a href="../Controller/FiscalizacaoController.php?action=update_nf&id=<?= $NFobject->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                                            <?php } ?>
                                            <?php if (isAdminLevel($EXCLUIR_FISCALIZACAO)) { ?>
                                                <a href="../Controller/FiscalizacaoController.php?action=delete_nf&id=<?= $NFobject->getId() ?>"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                                            <?php } ?>
                                        </td>               
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
        <br>             
        <div class="form-group" align="center">
            <input type="submit" class="btn btn-success" value="Salvar"/>
            <input type="button" class="btn btn-danger" value="Fechar" onclick="document.location = 'FiscalizacaoController.php?action=getAllList';"/>
        </div>
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
        $('[name=cnpj]').mask('00.000.000/0000-00');
        $('[name=ne]').mask('0000NE000000');
    });

    var secoes = ["requisitante", "salc", "conformidade", "salc2", "almoxarifado", "tesouraria"];
    for (i = 0; i < secoes.length; i++) {
        if (getCookie(secoes[i]) === "1") {
            minimize(secoes[i]);
        }
    }

    //    function setTimelineStatus(cell, status) {
    //        var cellNameStatus = cell + "Status";
    //        document.getElementById(cellNameStatus).innerHTML = "<h4>" + status + "</h4>";
    //    }

    //    function completeTimeline(cell) {
    //        var timeline = ["requisitante", "salc1", "conformidade", "salc2", "almoxarifado", "tesouraria"];
    //        var cellNameTimestamp, cellNameStatus, timestamp, status;
    //        cellNameTimestamp = cell + "Timestamp";
    //        cellNameStatus = cell + "Status";
    //        timestamp = document.getElementById(cellNameTimestamp);
    //        status = document.getElementById(cellNameStatus);
    //        timestamp.className = "timestampCompleted";
    //        status.className = "statusCompleted";
    //        cellIndex = timeline.indexOf(cell);
    //        if (cellIndex < timeline.length - 1) {
    //            cell = timeline[++cellIndex];
    //            cellNameTimestamp = cell + "Timestamp";
    //            cellNameStatus = cell + "Status";
    //            timestamp = document.getElementById(cellNameTimestamp);
    //            status = document.getElementById(cellNameStatus);
    //            timestamp.className = "timestampNext";
    //            status.className = "statusNext";
    //            setTimelineStatus(cell, "Aguardando...");
    //        }
    //    }

    //    function checkIfReady(fields) {
    //        var ready = true;
    //        for (i = 0; i < fields.length; i++) {
    //            var needle = document.forms["requisicao"][fields[i]].value;
    //            if (needle === "") {
    //                ready = false;
    //            }
    //        }
    //        return ready;
    //    }

    //    function fillTimeline() {
    //        var requisitanteFields = ["dataRequisicao", "om", "idSecao", "idNotaCredito", "idCategoria", "modalidade", "ug", "omModalidade", "empresa", "cnpj", "contato"];
    //        var salc1Fields = ["dataNE", "ne", "tipoNE", "valorNE"];
    //        var conformidadeFields = ["dataParecer", "parecer"];
    //        var salc2Fields = ["dataEnvioNE"];
    //        var almoxarifadoFields = ["dataEnvioNEEmpresa"];
    //        var tesourariaFields = ["dataLiquidacao"];
    //        if (checkIfReady(requisitanteFields)) {
    //            completeTimeline("requisitante");
    //            setTimelineStatus("requisitante", "Requisição feita");
    //        }
    //        if (checkIfReady(salc1Fields)) {
    //            completeTimeline("salc1");
    //            setTimelineStatus("salc1", "Empenhado");
    //        }
    //        if (checkIfReady(conformidadeFields)) {
    //            completeTimeline("conformidade");
    //            setTimelineStatus("conformidade", "Conformidade OK");
    //        }
    //        if (checkIfReady(salc2Fields)) {
    //            completeTimeline("salc2");
    //            setTimelineStatus("salc2", "Enviado ao Almoxarifado");
    //        }
    //        if (checkIfReady(almoxarifadoFields) /*&& NFSemEntrega === false*/) {
    //            completeTimeline("almoxarifado");
    //            setTimelineStatus("almoxarifado", "Enviado à Empresa");
    //        }
    //        if (checkIfReady(tesourariaFields)) {
    //            completeTimeline("tesouraria");
    //            setTimelineStatus("tesouraria", "NFs Liquidadas");
    //        }
    //    }

    //fillTimeline();

    function checkPA(abriuPA) {
        var diex = document.getElementById("diexField");
        var dataDiex = document.getElementById("dataDiexField");
        var idProcesso = document.getElementById("idProcessoField");
        if (abriuPA === "1") {
            diex.style.display = "";
            dataDiex.style.display = "";
            idProcesso.style.display = "";
        } else if (abriuPA === "0") {
            diex.style.display = "none";
            dataDiex.style.display = "none";
            idProcesso.style.display = "none";
        } else {
            diex.style.display = "none";
            dataDiex.style.display = "none";
            idProcesso.style.display = "none";
        }
    }

    function checkVA(anulou) {
        var valorAnulado = document.getElementById("valorAnuladoField");
        var justificativa = document.getElementById("justificativaField");
        if (anulou === "1") {
            valorAnulado.style.display = "";
            justificativa.style.display = "";
        } else if (anulou === "0") {
            valorAnulado.style.display = "none";
            justificativa.style.display = "none";
        } else {
            valorAnulado.style.display = "none";
            justificativa.style.display = "none";
        }
    }

    function checkRV(reforcou) {
        var valorReforco = document.getElementById("valorReforcoField");
        var observacoes = document.getElementById("observacoesReforcoField");
        var idNotaCredito = document.getElementById("idNotaCreditoField");
        if (reforcou === "1") {
            valorReforco.style.display = "";
            observacoes.style.display = "";
            idNotaCredito.style.display = "";
        } else if (reforcou === "0") {
            valorReforco.style.display = "none";
            observacoes.style.display = "none";
            idNotaCredito.style.display = "none";
        } else {
            valorReforco.style.display = "none";
            observacoes.style.display = "none";
            idNotaCredito.style.display = "none";
        }
    }

    function checkDataPrazoEntrega(dataEnvioNEEmpresa) {
        var date = new Date(dataEnvioNEEmpresa);
        date.setDate(date.getDate() + 30);
        document.getElementById("dataPrazoEntrega").value = date.toISOString().slice(0, 10);
    }

    function checkZeroFillFields(field) {
        if (field.value === "0") {
            field.value = "";
        }
    }

    checkZeroFillFields(document.getElementById("ug"));
    checkZeroFillFields(document.getElementById("numeroModalidade"));
</script>
<?php
require_once '../include/footer.php';
