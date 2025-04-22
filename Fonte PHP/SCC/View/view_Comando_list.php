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
$saudacao = "";
if (date('H') >= 4 && date('H') < 12) {
    $saudacao = "Bom dia, ";
} else if (date('H') >= 12 && date('H') < 18) {
    $saudacao = "Boa tarde, ";
} else {
    $saudacao = "Boa noite, ";
}
$mensagemGeral = urlencode("*ATENÇÃO - Mensagem diária de documentos/compromissos pendentes*\n____________________\n");
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
            <div class="col" align="left" style="padding-top: 7px;" id="diexTableFiltro">                    
                <input type="radio" id="resolvidos" name="resolvido" value="1" onchange="update();" <?= $resolvido == "1" ? " checked" : "" ?>> Resolvidos  
                <input type="radio" id="emAndamento" name="resolvido" value="0" onchange="update();" <?= $resolvido == "0" || $resolvido == "" ? " checked" : "" ?>> Em andamento 
            </div>
            <div class="col" align="left" style="padding-top: 7px;" id="diexTableDocumentoFiltro">   
                <input type="radio" id="tipoTodos" name="tipo" value="todos" onchange="update();" <?= $tipo == "todos" || $tipo == "" ? " checked" : "" ?>> Exibir todos 
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
                <th><sup>PDF</sup> Título <sub>Assunto</sub></th>
                <th>Prazo</th>
                <th>Responsável</th> 
                <!--<th>Data</th>-->
                <th>Situação</th>    
                <th>
                    <?php if (isAdminLevel($ADICIONAR_COMANDO)) { ?>
                        <a href="../Controller/ComandoController.php?action=sped_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                        <span id="mensagemGeral"></span>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTable">   
            <?php if (is_array($objectList) && isAdminLevel($LISTAR_COMANDO)) { ?> 
                <?php foreach ($objectList as $object): ?>    
                    <?php
                    $pessoa = null;
                    $posto = "";
                    $nomeGuerra = "";
                    if ($object->getIdResponsavel() > 0) {
                        $pessoa = $pessoaDAO->getById($object->getIdResponsavel());
                        $nomeGuerra = $pessoa->getNomeGuerra();
                        $telefone = trim(str_replace(' ', '', $pessoa->getTelefone()));
                    }
                    if ($pessoa != null) {
                        $posto = $pessoa->getIdPosto() > 0 ? $postoDAO->getById($pessoa->getIdPosto())->getPosto() : "";
                    }
                    ?>            
                    <tr>
                        <td width="50%">
                            <?php if (!str_contains($arquivoDAO->getArquivo($object->getId()), "semarquivo")) { ?>
                                <a href="../include/arquivos/<?= $object->getId(); ?>.pdf" target="_blank"><img src="../include/imagens/pdf.jpg" width="34"></a>
                            <?php } ?>
                                <?= $object->getTitulo() ?><br>
                            <i><?= $object->getAssunto() ?></i></td>
                        <td style="text-align: center;"><b><?= dateFormat($object->getPrazo()) ?></b></td>                        
                        <td><?= $posto . " " . $nomeGuerra ?></td>
                        <!--<td><?= dateFormat($object->getData()) ?></td>-->
                        <td style="white-space: nowrap;">
                            <?php
                            $class = "dark";
                            $alert = "Resolvido";
                            $htmlAlert = "<strong>$alert</strong>";
                            $dateDif = date_diff(new DateTime($object->getPrazo()), $hoje);
                            $dias = $dateDif->format('%a');
                            if ($object->getResolvido() != 1) {
                                if ($dias == 0) {
                                    $class = "warning";
                                    $alert = "Vencendo";
                                    $htmlAlert = "<strong>$alert</strong>";
                                } else if ($dateDif->format('%R') == "+") {
                                    $class = "danger";
                                    $alert = $dateDif->format('%a') . " dia(s) atrasada";
                                    $htmlAlert = "<strong>$alert dia(s) atrasada</strong>";
                                } else if ($dateDif->format('%R') == "-" && $dias > 0) {
                                    $class = "success";
                                    $alert = "$dias dia(s) restantes";
                                    $htmlAlert = "<strong> $alert</strong>";
                                }
                            }
                            ?>    
                            <span class="alert alert-<?= $class ?>" role="alert">
                                <?= $htmlAlert ?>
                            </span>
                        </td>
                        <?php
                        $situacao = urldecode(html_entity_decode($alert, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                        $mensagem = urlencode($saudacao . " " . html_entity_decode($object->getTitulo(), ENT_QUOTES | ENT_HTML5, 'UTF-8') . " com prazo " . dateFormat($object->getPrazo()) . ". Qual andamento?");
                        $mensagemGeral .= html_entity_decode($posto . " " . $nomeGuerra, ENT_QUOTES | ENT_HTML5, 'UTF-8') .
                                urlencode("\n") .
                                urlencode(html_entity_decode($object->getTitulo(), ENT_QUOTES | ENT_HTML5, 'UTF-8') . "\n*Prazo " .
                                        dateFormat($object->getPrazo()) . " (" . $situacao . ")*\n");
                        $mensagemGeral .= !str_contains($arquivoDAO->getArquivo($object->getId()), "semarquivo") ?
                                urlencode("Anexo: http://intranet.2becmb.eb.mil.br/sistemas/SCC/include/arquivos/" . $object->getId() . ".pdf\n\n") :
                                urlencode("\n");
                        ?>
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_COMANDO)) { ?>
                                <a href="../Controller/ComandoController.php?action=sped_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_COMANDO)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do documento?') ? document.location = '../Controller/ComandoController.php?action=sped_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                            <a href="https://wa.me/<?= $telefone ?>?text=<?= $mensagem ?>" target="whatsapp"><img src="../include/imagens/whatsapp.png" width="34"></a>
                        </td>
                    </tr>                      
                <?php endforeach; ?>    
            <?php } ?>
        </tbody>
    </table>    
</div>
<div id="mensagemOculta" style="visibility: hidden;">
    <a href="https://wa.me/?text=<?= $mensagemGeral ?>" target="whatsapp"><img src="../include/imagens/whatsapp.png" width="34"></a>
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
    document.getElementById("mensagemGeral").innerHTML = document.getElementById("mensagemOculta").innerHTML;
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
