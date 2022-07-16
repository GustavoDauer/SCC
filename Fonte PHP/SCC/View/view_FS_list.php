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
$situacao = filter_input(INPUT_GET, "situacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$hoje = new DateTime();
?>
<script type="text/javascript">
    function update() {
        document.getElementById("filtro").submit();
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function minimize(id) {
        var object = document.getElementById(id);
        object.style.display = "none";
        document.cookie = id + "=1";
    }

    function maximize(id) {
        var object = document.getElementById(id);
        object.style.display = "";
        document.cookie = id + "=0";
    }
</script>
<div class="conteudo">       
    <div align="center">        
        <form accept-charset="UTF-8" id="filtro" action="../Controller/FSController.php?action=getAllList" method="get">
            <input type="hidden" name="action" value="getAllList">            
            <div class="form-row">                  
                <!--                <div class="col" align="center" style="padding-top: 7px;">   
                                    <input type="radio" id="solucao" name="solucao" value="todos" onchange="update();" <?= $solucao == "todos" ? " checked" : "" ?>> Exibir todos <input type="radio" id="solucao" name="solucao" value="concluido" onchange="update();" <?= $solucao == "concluido" ? " checked" : "" ?>>Concluídos  <input type="radio" id="solucao" name="solucao" value="emandamento" onchange="update();" <?= $solucao == "emandamento" ? " checked" : "" ?>> Em andamento 
                                </div>-->
            </div>                            
        </form>
    </div>   
    <br>
    <?php
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("FS")->getDataAtualizacaoOriginal()), $hoje);
    if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 7) {
        $color = "red";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') > 2 && $dateDif->format('%a') < 7) {
        $color = "darkorange";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') <= 2) {
        $color = "darkgreen";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    }
    ?>    
    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("FS")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("FS")->getMensagem(); ?></h6>
    <div align="left">                        
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarMensagem">Editar mensagem</button>
        <button type="button" class="btn btn-info" onclick="window.open('https://docs.google.com/spreadsheets/d/1R91O7jk4qqiK4PwiMA5am8o6IBzmTPnkT3QNo6oWDM0/edit');">Planilha de COVID</button>        
    </div>
    <br>
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTableB');"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTableB');">        
        <span style="margin-left: 14px; font-weight: bold;">RELATÓRIO DE BAIXADOS</span>
    </div>
    <br>    
    <table class="table table-bordered" id="myTableB">
        <thead>
            <tr>
                <th colspan="25">
                    <input class="form-control" id="myInputBaixado" type="text" placeholder="Buscar...">
                    <div id="contador" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                </th>
            </tr>
            <tr>                
                <th>Nome/Cia/Ano</th>                
                <th>Diagnóstico</th>
                <th>Situação</th>                   
                <th>BI / BAR</th>                
                <th>Parecer</th>
                <th>Observação</th>
                <th>Ações</th>
                <th>Atualização</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_FS)) { ?>
                        <a href="../Controller/FSController.php?action=baixado_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTableBaixado">   
            <?php if (is_array($objectList) && isAdminLevel($LISTAR_FS)) { ?> 
                <?php foreach ($objectList as $object): ?>
                    <tr>
                        <td><small><?= $postoDAO->getById($object->getIdPosto())->getPosto() ?> <?= $object->getNome() ?> / <?= $object->getCia() ?> / <?= $object->getTurma() ?></small></td>                        
                        <td><small><?= $object->getDiagnostico() ?></small></td>
                        <td><strong><?= $object->getSituacao() ?></strong></td>
                        <td><small><?= $object->getBi() ?> <?= $object->getBar() ?></small></td>                        
                        <td><small><?= $object->getDispensa() ?></small></td>
                        <td><small><?= $object->getAmparo() ?></small></td>
                        <td><small><?= $object->getAcao() ?></small></td>
                        <?php
                        $class = "info";
                        $alert = "<strong>Concluído</strong>";

                        if (!empty($object->getDataAtualizacao())) {
                            $class = $alert = "";
                            $dateDif = date_diff(new DateTime($object->getDataAtualizacaoOriginal()), $hoje);
                            $dias = $dateDif->format('%a');
                            $alert = "<strong>$dias dia(s) atrás</strong>";
                            if ($dias <= 30) {
                                $class = "success";
                            } else if ($dias > 30 && $dias <= 45) {
                                $class = "warning";
                            } else if ($dias > 45) {
                                $class = "danger";
                            }
                        }
                        ?>                                                                                                                     
                        <td style="white-space: nowrap">
                            <span class="alert alert-<?= $class ?>" role="alert">   
                                <!--<?= $object->getDataAtualizacao() ?>-->    
                                <?= $alert ?>   
                            </span>                                                        
                        </td>
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_FS)) { ?>
                                <a href="../Controller/FSController.php?action=baixado_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_FS)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do baixado?') ? document.location = '../Controller/FSController.php?action=baixado_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>
                    </tr>                    
                <?php endforeach; ?>    
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="editarMensagem" tabindex="-1" role="dialog" aria-labelledby="mensagemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mensagemLabel">Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                  
                <?php
                $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("FS")->getDataAtualizacaoOriginal()), $hoje);
                if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 7) {
                    $color = "red";
                    $alert = $dateDif->format('%a') . " dia(s) atrás";
                } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') > 2 && $dateDif->format('%a') < 7) {
                    $color = "darkorange";
                    $alert = $dateDif->format('%a') . " dia(s) atrás";
                } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') <= 2) {
                    $color = "darkgreen";
                    $alert = $dateDif->format('%a') . " dia(s) atrás";
                }
                ?>    
                <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("FS")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= empty($secaoDAO->getBySecao("FS")->getDataAtualizacao()) ? "" : $alert; ?></span></h6>
                <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("FS")->getMensagem(); ?></h6>
            </div>
            <div class="modal-footer">                
                <form accept-charset="UTF-8" id="formMapaDaForca" action="../Controller/FSController.php?action=mensagem_update" method="post">                    
                    <?php if (isAdminLevel($EDITAR_FS)) { ?>                        
                        <textarea name="mensagem" cols="81" placeholder="Mensagem opcional para o Comandante" maxlength="700"><?= $secaoDAO->getBySecao("FS")->getMensagem(); ?></textarea><br>
                        <input type="submit" class="btn btn-primary" value="Atualizar">
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#myInputBaixado").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTableBaixado tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                countRows();
            });
        });
    });

    $(document).ready(function () {
        $("#myInputCovid").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTableCovid tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                countRows();
            });
        });
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    if (getCookie("myTableB") === "1") {
        minimize("myTableB");
    }

    if (getCookie("myTableC") === "1") {
        minimize("myTableC");
    }

    function countRows() {
        let rowCount = $('#myTableBaixado tr:visible').length;
        var message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
        document.getElementById("contador").innerHTML = message;

        rowCount = $('#myTableCovid tr:visible').length;
        message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
        document.getElementById("contador2").innerHTML = message;
    }

    countRows();
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
