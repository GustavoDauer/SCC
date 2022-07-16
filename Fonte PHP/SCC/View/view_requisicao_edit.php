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
<div class="container">  
    <form accept-charset="UTF-8" action="../Controller/FiscalizacaoController.php?action=<?= $object->getId() > 0 ? 'update' : 'insert' ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Cadastrar" ?> Requisição | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>    
        <hr>    
        <h2 class="alert alert-danger">SEÇÃO REQUISITANTE</h2>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data Requisição</span>
                        <input type="date" class="form-control" id="dataRequisicao" placeholder="Data Requisição" name="dataRequisicao" value="<?= $object->getDataRequisicao() ?>" />
                    </div>                    
                </div>
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
            </div>
        </div>
        <!--        <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Descrição</span>
                                <textarea class="form-control" name="descricao" placeholder="Descrição da necessidade" maxlength="500"><?= $object->getDescricao() ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>-->
        <h2 class="subtitulo">Dados do pregão</h2>
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">PE</span>
                        <input type="text" class="form-control" id="pe" placeholder="Pregão Eletronico" name="pe" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getPe() ?>"/>
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">UG</span>
                        <input type="text" class="form-control" id="ug" placeholder="Unidade Gestora" name="ug" maxlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getUg() ?>" />
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">OM do pregão</span>
                        <input type="text" class="form-control" id="ompe" placeholder="Órgão Militar" name="ompe" maxlength="45" value="<?= $object->getOmpe() ?>" />
                    </div>                    
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
                    <div class="input-group-prepend">
                        <span class="input-group-text">CNPJ</span>
                        <input type="text" class="form-control" id="cnpj" placeholder="CNPJ" name="cnpj" maxlength="18"  onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getCnpj() ?>" />
                    </div>                    
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
            </div>
        </div>
        <h2 class="subtitulo">Itens do pregão</h2>
        <div id="itensInseridos" style="margin: 7px;">
            <?php
            if (is_array($itemList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                foreach ($itemList as $item) {
                    ?> 
                    <span style="margin: 2px;"><?php echo $item->getNumeroItem() . " " . $item->getDescricao() . " " . $item->getQuantidade() . " " . $item->getValor() . " " ?></span> <input type="button" class="btn btn-danger" value="Excluir" onclick="excluir(<?= $item->getId() . ", " . $object->getId() ?>);"><hr> <!-- submit form e excluir item -->
                    <?php
                }
            }
            ?>
        </div>
        <div>
<!--            <input type="hidden" id="numeroItem" name="idItem" value=""/>-->
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
        <div class="form-group">
            <div class="form-row">
                <div class="col">      
                    <h2 class="alert alert-info">SEÇÃO SALC</h2>
                    <input type="hidden" name="dataNE" value="<?= $object->getDataNE() ?>">
                    <div class="input-group-prepend">
                        <span class="input-group-text">NE</span>
                        <input type="text" class="form-control" id="ne" placeholder="Nota de Empenho" name="ne" maxlength="12" onkeypress="return event.charCode === 78 || event.charCode === 69 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getNe() ?>"/>
                    </div>                    
                </div>
                <div class="col">      
                    <h2 class="alert alert-warning">SEÇÃO CONFORMIDADE</h2>
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Data do Parecer</span> <!-- Data de Aprovação -->
                            <input type="date" class="form-control" name="dataAprovacao" value="<?= $object->getDataAprovacao() ?>">
                        </div>                    
                    </div>                    
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
                    <div class="input-group-prepend">
                        <span class="input-group-text">Observação</span>
                        <textarea class="form-control" id="observacaoConformidade" name="observacaoConformidade"><?= $object->getObservacaoConformidade(); ?></textarea>
                    </div>                    
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
                        <span class="input-group-text">Valor</span>
                        <input type="text" class="form-control" id="valorNE" name="valorNE" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorNE(); ?>" placeholder="Ao preencher este campo com 0 (zero), a NE será considerada nula" />
                    </div>                    
                </div>  
                <div class="col">
                    &nbsp;
                </div>
            </div>
        </div>
        <h2 class="alert alert-primary">SEÇÃO ALMOXARIFADO</h2>  
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
                        <span class="input-group-text">Número Diex</span>
                        <input type="text" class="form-control" id="numeroDiex" placeholder="numeroDiex" name="numeroDiex" maxlength="100" value="<?= $object->getNumeroDiex() ?>"/>
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Número Oficio</span>
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
