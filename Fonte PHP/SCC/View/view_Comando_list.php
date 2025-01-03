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
$resolvido = filter_input(INPUT_GET, "resolvido", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tipo = filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$hoje = new DateTime();
?>
<script type="text/javascript" src="../include/js/common.js"></script>
<div class="conteudo">   
    <form accept-charset="UTF-8" id="filtro" action="../Controller/ComandoController.php?action=getAllList" method="get">
        <input type="hidden" name="action" value="getAllList">            
        <div class="form-row" style="border: 1px dashed lightskyblue; padding: 7px;">  
            <div class="col-4" align="left">                  
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('diexTable');minimize('diexTableFiltro');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('diexTable');maximize('diexTableFiltro');">        
                <span style="margin-left: 14px; font-weight: bold;">DOCUMENTOS</span>                           
            </div>
<!--            <div class="col" align="left" style="padding-top: 7px;" id="diexTableFiltro">   
                <input type="radio" id="resolvidoTodos" name="resolvido" value="todos" onchange="update();" <?= $resolvido == "todos" ? " checked" : "" ?>> Exibir todos 
                <input type="radio" id="resolvidos" name="resolvido" value="1" onchange="update();" <?= $resolvido == "1" ? " checked" : "" ?>> Resolvidos  
                <input type="radio" id="emAndamento" name="resolvido" value="0" onchange="update();" <?= $resolvido == "0" ? " checked" : "" ?>> Em andamento 
            </div>-->
            <div class="col" align="left" style="padding-top: 7px;" id="diexTableDocumentoFiltro">   
                <input type="radio" id="tipoTodos" name="tipo" value="todos" onchange="update();" <?= $tipo == "todos" ? " checked" : "" ?>> Exibir todos 
                <input type="radio" id="documento" name="tipo" value="Documento" onchange="update();" <?= $tipo == "Documento" ? " checked" : "" ?>> Documentos  
                <input type="radio" id="missao" name="tipo" value="Missao" onchange="update();" <?= $tipo == "Missao" ? " checked" : "" ?>> Missões
            </div>
        </div>                            
    </form>
    <table class="table table-bordered" id="diexTable">
        <thead>
            <tr>
                <th colspan="7">                    
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar...">
                    <div id="contador" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                </th>
            </tr>
            <tr>                
                <th>Título</th>
                <th>Prazo</th>
                <th>Responsável</th> 
                <!--<th>Data</th>-->
                <th>Situação</th>    
                <th>
                    <?php if (isAdminLevel($ADICIONAR_COMANDO)) { ?>
                        <a href="../Controller/ComandoController.php?action=sped_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTable">   
            <?php if (is_array($objectList) && isAdminLevel($LISTAR_COMANDO)) { ?> 
                <?php foreach ($objectList as $object): ?>
                    <tr>
                        <td width="50%"><?= $object->getTitulo() ?></td>
                        <td><?= dateFormat($object->getPrazo()) ?></td>                        
                        <td><?= $object->getResponsavel() ?></td>
                        <!--<td><?= dateFormat($object->getData()) ?></td>-->
                        <td>
                            <?php
                            $class = "dark";
                            $alert = "<strong>Resolvido</strong>";
                            $dateDif = date_diff(new DateTime($object->getPrazo()), $hoje);
                            $dias = $dateDif->format('%a');
                            if ($object->getResolvido() != 1) {
                                if ($dias == 0) {
                                    $class = "warning";
                                    $alert = "<strong>Vencendo</strong>";
                                } else if ($dateDif->format('%R') == "+") {
                                    $class = "danger";
                                    $alert = "<strong>" . $dateDif->format('%a') . " dia(s) atrasada</strong>";
                                } else if ($dateDif->format('%R') == "-" && $dias > 0) {
                                    $class = "success";
                                    $alert = "<strong> $dias dia(s) restantes</strong>";
                                }
                            }
                            ?>    
                            <span class="alert alert-<?= $class ?>" role="alert">
                                <?= $alert ?>
                            </span>
                        </td>
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_COMANDO)) { ?>
                                <a href="../Controller/ComandoController.php?action=sped_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_COMANDO)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do documento?') ? document.location = '../Controller/ComandoController.php?action=sped_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>
                    </tr>                    
                <?php endforeach; ?>    
            <?php } ?>
        </tbody>
    </table>    
</div>
<script>
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                countRows();
            });
        });
    });

    function countRows() {
        let rowCount = $('#myTable tr:visible').length;
        var message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
        document.getElementById("contador").innerHTML = message;
    }

    countRows();
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
