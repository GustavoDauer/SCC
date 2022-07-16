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
<div class="container">  
    <form accept-charset="UTF-8" action="../Controller/FiscalizacaoController.php?action=<?= $object->getId() > 0 ? 'update_nc' : 'insert_nc' ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Cadastrar" ?> Nota de crédito | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>    
        <hr>            
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data NC</span>
                        <input type="date" class="form-control" id="dataNc" placeholder="Data NC" name="dataNc" value="<?= $object->getDataNc() ?>" />
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nota de Crédito</span>
                        <input type="text" class="form-control" id="nc" placeholder="Nota de crédito" name="nc" maxlength="25" value="<?= $object->getNc() ?>" />
                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">PI</span>                        
                        <input type="text" class="form-control" id="pi" placeholder="PI" name="pi" maxlength="25" value="<?= $object->getPi() ?>" />
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Valor</span>                        
                        <input type="text" class="form-control" id="valor" placeholder="Valor da nota de crédito" name="valor" maxlength="14" value="<?= $object->getValor() ?>" />
                    </div>                    
                </div>                
            </div>
        </div>        
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">UGR</span> <!-- Gestor NC -->
                        <input type="text" class="form-control" id="gestorNc" placeholder="Gestor da nota de crédito" name="gestorNc" maxlength="70" value="<?= $object->getGestorNc() ?>"/>
                    </div>                    
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">UG</span>
<!--                        <input type="text" class="form-control" id="ug" placeholder="Unidade Gestora" name="ug" maxlength="7" value="<?= $object->getUg() ?>" />-->
                        <select class="form-control" name="ug" id="ug">
                            <option disabled <?= empty($object->getUg()) ? "selected" : "" ?>>Escolha uma UG para NC</option>
                            <option <?= $object->getUg() == "160477" ? "selected" : "" ?>>160477</option>
                            <option <?= $object->getUg() == "167477" ? "selected" : "" ?>>167477</option>
                        </select>
                    </div>                    
                </div>               
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">PTRes</span>
                        <input type="text" class="form-control" id="ptres" placeholder="PTRes" name="ptres" maxlength="25" value="<?= $object->getPtres() ?>" />
                    </div>                    
                </div>  
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Fonte</span>
                        <input type="text" class="form-control" id="fonte" placeholder="Fonte" name="fonte" maxlength="25" value="<?= $object->getFonte() ?>" />
                    </div>                    
                </div>

            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Valor recolhido</span>
                        <input type="text" class="form-control" id="valorRecolhido" placeholder="Valor recolhido" name="valorRecolhido" maxlength="11" value="<?= $object->getValorRecolhido() ?>" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" />
                    </div>                    
                </div>  
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Salvar"/>
    </form>
</div>
<?php
require_once '../include/footer.php';
