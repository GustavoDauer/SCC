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
<style type="text/css">
    .subtitulo {
        font-weight: bold;
    }
</style>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<script type="text/javascript">
    function excluir(id, idRequisicao) {
        if (confirm('Tem certeza que deseja excluir esse item?\n\nAo prosseguir, os dados editados nesse formulário não serão salvos. A página irá recarregar com a exclusão do item, exibindo os últimos dados salvos ao clicar no botão Salvar.')) {
            document.location = 'FiscalizacaoController.php?action=delete_item&idItem=' + id + "&id=" + idRequisicao;
        }
        return false;
    }
</script>
<style type="text/css">
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
        height: 80px;
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
        height: 80px;
        background-color: #ccffcc;
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
        height: 80px;
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
</style>
<div class="conteudo">  
    <form accept-charset="UTF-8" action="../Controller/FiscalizacaoController.php?action=<?= $object->getId() > 0 ? 'update' : 'insert' ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Cadastrar" ?> Requisição | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>    
        <hr> 
        <div>
            <ul class="timeline">
                <li>
                    <div class="timestampCompleted">
                        REQUISITANTE
                    </div>
                    <div class="statusCompleted">
                        <h4>Requisição feita</h4>
                    </div>
                </li>
                <li>
                    <div class="timestampCompleted">
                        SALC
                    </div>
                    <div class="statusCompleted">
                        <h4> Empenho feito </h4>
                    </div>
                </li>
                <li>
                    <div class="timestampNext">
                        CONFORMIDADE
                    </div>
                    <div class="statusNext">
                        <h4> Aguardando... </h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp">
                        SALC
                    </div>
                    <div class="status">
                        <h4> Envios NE e Almox feitos </h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp">
                        ALMOXARIFADO
                    </div>
                    <div class="status">
                        <h4> Monitorando entrega </h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp">
                        TESOURARIA
                    </div>
                    <div class="status">
                        <h4> Liquidação feita </h4>
                    </div>
                </li>
            </ul>
        </div>  
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
                                <input type="date" class="form-control" id="dataRequisicao" placeholder="Data Requisição" name="dataRequisicao" value="<?= $object->getDataRequisicao() ?>" />
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
                                <select class="form-control" name="om">
                                    <option>2º BE Cmb</option>
                                    <option>11ª Cia E Cmb L</option>
                                    <option>12ª Cia E Cmb L</option>
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
                                <select class="form-control" name="idSecao">
                                    <?php
                                    if (!empty($secaoList) && $secaoList != null) {
                                        foreach ($secaoList as $secao) {
                                            ?>
                                            <option value="<?= $secao->getId() ?>" <?= $secao->getId() == $object->getIdSecao() ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                            <?php
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
                                <select class="form-control" name="idNotaCredito">
                                    <option value="" disabled required <?= $object->getIdNotaCredito() > 0 ? "" : "selected"; ?>>Selecione uma nota de crédito</option>
                                    <?php
                                    $notaCreditoList = $notaCreditoDAO->getAllList();
                                    if (!empty($notaCreditoList) && $notaCreditoList != null) {
                                        foreach ($notaCreditoList as $notaCredito) {
                                            ?>
                                            <option value="<?= $notaCredito->getId() ?>" <?= $notaCredito->getId() == $object->getIdNotaCredito() ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                            <?php
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
                                <select class="form-control" name="idCategoria">
                                    <option disabled <?= $object->getIdCategoria() > 0 ? "" : "selected" ?>>Escolha uma categoria para requisição</option>
                                    <?php
                                    if (!empty($categoriaList) && $categoriaList != null) {
                                        foreach ($categoriaList as $categoria) {
                                            ?>
                                            <option value="<?= $categoria->getId() ?>" <?= $categoria->getId() == $object->getIdCategoria() ? "selected" : "" ?>><?= $categoria->getCategoria() ?></option>
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
                                <select name="modalidade" class="form-control">
                                    <option value="pe">Pregão Eletrônico</option>
                                    <option value="ce">Cotação Eletrônica</option>
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
                                <input type="text" class="form-control" id="pe" placeholder="Pregão Eletronico" name="pe" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getPe() ?>"/>
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
                                <span class="input-group-text">Unidade Gestora</span>
                                <input type="text" class="form-control" id="ug" placeholder="Unidade Gestora" name="ug" maxlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getUg() ?>" />
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
                                <span class="input-group-text">Organização Militar da modalidade</span>
                                <input type="text" class="form-control" id="ompe" placeholder="Órgão Militar" name="ompe" maxlength="45" value="<?= $object->getOmpe() ?>" />
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
                                <input type="text" class="form-control" id="empresa" placeholder="Nome da Empresa" name="empresa" maxlength="500" value="<?= $object->getEmpresa() ?>" />
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
                                <input type="text" class="form-control" id="cnpj" placeholder="CNPJ" name="cnpj" maxlength="18"  onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getCnpj() ?>" />
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
                                <textarea class="form-control" name="contato" placeholder="Informações de contato com a empresa" maxlength="520"><?= $object->getContato() ?></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Informações de contato da empresa responsável pelos materiais.</span>
                        </div>
                    </div>
                </div>
                <h2 class="subtitulo">Itens</h2>
                <div id="itensInseridos" style="margin: 7px;">
                    <?php
                    if (is_array($itemList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                        foreach ($itemList as $item) {
                            ?> 
                            <span style="margin: 2px;"><?php echo $item->getNumeroItem() . " " . $item->getDescricao() . " " . $item->getQuantidade() . " " . $item->getValor() . " " ?></span> <input type="button" class="btn btn-danger" value="Excluir" onclick="excluir(<?= $item->getId() . ", " . $object->getId() ?>);"><hr>  submit form e excluir item 
                            <?php
                        }
                    }
                    ?>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-row">                
                            <div class="col">                    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Número do item</span>
                                    <input type="number" class="form-control" id="numeroItem" placeholder="Número do item" name="numeroItem" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" />
                                </div>                          
                            </div>                       
                            <div class="col">                    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Descrição</span>
                                    <input type="text" class="form-control" id="descricao" placeholder="Descrição do Item" name="descricaoItem" maxlength="500" />
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Valor</span>
                                    <input type="text" class="form-control" id="valor" placeholder="Valor do Item" name="valor" maxlength="25" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Quantidade</span>
                                    <input type="number" class="form-control" id="quantidade" placeholder="Quantidade" name="quantidade" maxlength="25" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" />
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
                        novoItem += "<input type='hidden' id='idItem' name='idItem" + total + "' value=''/><input type = 'number' class = 'form-control' id = 'numeroItem' placeholder = 'Número do item' name = 'numeroItem" + total + "' maxlength = '7'/>";
                        novoItem += "</div></div>"
                        novoItem += "<div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Descrição</span><input type = 'text' class = 'form-control' id = 'descricaoItem' placeholder = 'Descrição do Item' name = 'descricaoItem" + total + "' maxlength = '500' /></div></div></div></div>";
                        novoItem += "<div class = 'form-group'><div class = 'form-row'><div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Valor</span><input type = 'text' class = 'form-control' id = 'valor' placeholder = 'Valor do Item' name = 'valor" + total + "' maxlength = '25' onkeypress='return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);' /></div></div>";
                        novoItem += "<div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Quantidade</span><input type = 'number' class = 'form-control' id = 'quantidade' placeholder = 'Quantidade' name = 'quantidade" + total + "' maxlength = '25' onkeypress='return event.charCode >= 48 && event.charCode <= 57;' /></div></div></div></div>";
                        itens.innerHTML = itens.innerHTML + novoItem;
                    }
                </script>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">  
                            <a onclick="adicionarItens();
                               " style="color: blue;
                               text-decoration: underline;
                               ">Adicionar mais itens</a>
                        </div>                                             
                    </div>
                </div>
            </div>
        </div>        
        <br>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">                  
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('salc');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('salc');"> 
                SALC
            </h2>
            <input type="hidden" name="dataNE" value="<?= $object->getDataNE() ?>">
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">
                        <div class="input-group-prepend">
                            <span class="input-group-text">NE</span>
                            <input type="text" class="form-control" id="ne" placeholder="Nota de Empenho" name="ne" maxlength="12" onkeypress="return event.charCode === 78 || event.charCode === 69 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getNe() ?>"/>
                        </div>  
                    </div>
                    <div class="col">
                        <span class="explanation">Número da Nota de Empenho.</span>
                    </div>
                </div> 
            </div>
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Data da NE</span>
                            <input type="date" class="form-control" id="dataEnvioNE" name="dataEnvioNE" value="<?= $object->getDataEnvioNE() ?>" />
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
                        <div class="input-group-prepend">
                            <span class="input-group-text">Valor</span>
                            <input type="text" class="form-control" id="valorNE" name="valorNE" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorNE(); ?>" placeholder="Ao preencher este campo com 0 (zero), a NE será considerada nula" />
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
                            <textarea class="form-control" id="observacaoAquisicao" name="observacaoAquisicoes"><?= $object->getObservacaoAquisicoes(); ?></textarea>
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
                            <span class="input-group-text">Data de Envio NE</span>
                            <input type="date" class="form-control" id="dataEnvioNE" name="dataEnvioNE" value="<?= $object->getDataEnvioNE() ?>" />
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Data de envio da Nota de Empenho pela SALC ao Almoxarifado e à Empresa.</span>
                    </div>
                </div>                    
            </div>
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Valor anulado</span>
                            <input type="text" class="form-control" id="valorNE" name="valorNE" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorNE(); ?>" placeholder="Ao preencher este campo com 0 (zero), a NE será considerada nula" />
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
                            <span class="input-group-text">Justificativa</span>
                            <textarea class="form-control" id="observacaoAquisicao" name="observacaoAquisicoes"><?= $object->getObservacaoAquisicoes(); ?></textarea>
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
                            <span class="input-group-text">Valor reforçado</span>
                            <input type="text" class="form-control" id="valorNE" name="valorNE" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorNE(); ?>" placeholder="Ao preencher este campo com 0 (zero), a NE será considerada nula" />
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
                            <span class="input-group-text">Nota de Crédito</span>
                            <input type="text" class="form-control" id="nc" placeholder="Nota de crédito" name="nc" maxlength="25" value="" />
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Nota de crédito usada para o reforço.</span>
                    </div>
                </div> 
            </div>
        </div>
        <br>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('conformidade');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('conformidade');"> 
                CONFORMIDADE
            </h2>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Data</span> 
                            <input type="date" class="form-control" name="dataAprovacao" value="<?= $object->getDataAprovacao() ?>">
                        </div>
                    </div>
                    <div class="col">
                        <span class="explanation">Data do parecer do Ordernador de Despesas.</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Parecer</span>
                            &nbsp;
                            <input type="radio" id="parecer" name="parecer" value="1" <?= $object->getParecer() == 1 ? " checked" : "" ?>/> Aprovado &nbsp;
                            <input type="radio" id="parecer" name="parecer" value="0" <?= $object->getParecer() == 0 ? " checked" : "" ?>/> Desaprovado
                        </div>                    
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Observação</span>
                            <textarea class="form-control" id="observacaoConformidade" name="observacaoConformidade"><?= $object->getObservacaoConformidade(); ?></textarea>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Observações da Seção de Conformidade e Gestão.</span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('almoxarifado');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('almoxarifado');"> 
                ALMOXARIFADO
            </h2>
            <!-- Button to Open the Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Adicionar nova Nota Fiscal
            </button>

            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Adicionar nova Nota Fiscal</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            Revisar necessidades com Ten Caires! 

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Data Entrega do Material</span>
                                            <input type="date" class="form-control" id="dataEntregaMaterial" name="dataEntregaMaterial" value="<?= $object->getDataEntregaMaterial() ?>"/>
                                        </div>                    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">                
                                    <div class="col">                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Número DIEx</span>
                                            <input type="text" class="form-control" id="numeroDiex" placeholder="numeroDiex" name="numeroDiex" maxlength="100" value="<?= $object->getNumeroDiex() ?>"/>
                                        </div>                    
                                    </div>
                                    <div class="col">                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Número Ofício</span>
                                            <input type="text" class="form-control" id="numeroOficio" placeholder="numeroOficio" name="numeroOficio" maxlength="100" value="<?= $object->getNumeroOficio() ?>"/>
                                        </div>                    
                                    </div>                
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Processo Administrativo</span>
                                            <input type="text" class="form-control" id="processoAdministrativo" placeholder="Processo Administrativo" name="processoAdministrativo" maxlength="250" value="<?= $object->getProcessoAdministrativo() ?>"/>
                                        </div>                    
                                    </div>
                                    <div class="col">                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Boletim Solução do PA</span>
                                            <input type="text" class="form-control" id="boletim" placeholder="Boletim" name="boletim" maxlength="250" value="<?= $object->getBoletim() ?>"/>
                                        </div>                    
                                    </div>                
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">                
                                    <div class="col">                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Observação</span>
                                            <textarea class="form-control" id="observacaoAlmox" name="observacaoAlmox"><?= $object->getObservacaoAlmox(); ?></textarea>
                                        </div>                    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Data Prazo de Entrega Acordado</span>
                                            <input type="date" class="form-control" id="dataPrazoEntrega" name="dataPrazoEntrega" value="<?= $object->getDataPrazoEntrega() ?>"/>
                                        </div>                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Salvar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <br>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('tesouraria');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('tesouraria');"> 
                TESOURARIA
            </h2>
        </div>
        <br>               
        <h2 class="alert alert-primary">SEÇÃO ALMOXARIFADO</h2>  

        <!--        -->
        <h2 class="alert alert-success">SEÇÃO TESOURARIA</h2>
        <!--        <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data da última Liquidação</span>
                                <input type="date" class="form-control" id="dataUltimaLiquidacao" name="dataUltimaLiquidacao" value="<?= $object->getDataUltimaLiquidacao() ?>"/>
                            </div>                    
                        </div>                                
                    </div>           
                </div>-->
        <!--        <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Valor a Liquidar</span>
                                <input type="text" class="form-control" id="valorLiquidar" placeholder="Valor a Liquidar" name="valorLiquidar" maxlength="25" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorLiquidar() ?>"/>
                            </div>                    
                        </div>                                
                    </div>           
                </div>-->
        <input type="submit" class="btn btn-primary" value="Salvar"/>
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
</script>
<?php
require_once '../include/footer.php';
