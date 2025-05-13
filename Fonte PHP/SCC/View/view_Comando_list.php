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
$scmt = $pessoaDAO->getById(4);
$mensagem = "";
$mensagemClara = "";
$mensagemGeral = urlencode("*ATENÇÃO - Mensagem diária de documentos pendentes*\n____________________________________________\n");
$mensagemGeralClara = '*ATENÇÃO - Mensagem diária de documentos pendentes*\n____________________________________________\n';
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
                <th>Seção Responsável<br><sub><span style="background-color: lightgreen; padding: 5px;">Seções Envolvidas</span></sub></th>                 
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
                    $secao = $object->getIdSecao() > 0 ? $secaoDAO->getById($object->getIdSecao()) : null;
                    $secaoNome = !is_null($secao) ? $secao->getSecao() : "";
                    $telefoneScmt = !is_null($scmt) ? $scmt->getTelefone() : null;
                    $telefone = trim(str_replace(' ', '', !is_null($telefoneScmt) ? $telefoneScmt : ""));
                    ?>            
                    <tr>
                        <td width="40%">
                            <?php if (!str_contains($arquivoDAO->getArquivo($object->getId()), "semarquivo")) { ?>
                                <a href="../include/arquivos/<?= $object->getId(); ?>.pdf" target="_blank"><img src="../include/imagens/pdf.jpg" width="34"></a>
                            <?php } ?>
                                <?= $object->getTitulo() ?><br>
                            <i><?= $object->getAssunto() ?></i></td>
                        <td style="text-align: center;"><b><?= dateFormat($object->getPrazo()) ?></b></td>                        
                        <td>
                            <b><?= $secaoNome ?></b><br>
                            <sub>
                                <?php
                                $secoes = "";
                                $mensagemSecoes = "";
                                if (!is_null($object->getIdSecoes())) {
                                    foreach ($object->getIdSecoes() as $idSecao):
                                        $secoes .= "<span style='font-size: 10px; font-weight: bold; background-color: lightgreen;padding: 5px;'>" . $secaoDAO->getById($idSecao)->getSecao() . "</span> ";
                                        $mensagemSecoes .= (empty($mensagemSecoes) ? " " : ", ") . $secaoDAO->getById($idSecao)->getSecao();
                                    endforeach;
                                }
                                ?>
                                <?= $secoes ?>
                            </sub>
                        </td>                        
                        <td style="white-space: nowrap;">
                            <?php
                            $class = "dark";
                            $alert = "Resolvido";
                            $htmlAlert = "<strong>$alert</strong>";
                            $dateDif = date_diff(new DateTime($object->getPrazo()), $hoje);
                            $dias = $dateDif->format('%a');
                            if ($object->getResolvido() != 1) {
                                if ($dias == 0) {
                                    $class = !empty($object->getPrazo()) ? "warning" : "info";
                                    $alert = !empty($object->getPrazo()) ? "Vencendo" : "Sem prazo";
                                    $htmlAlert = "<strong>$alert</strong>";
                                } else if ($dateDif->format('%R') == "+") {
                                    $class = "danger";
                                    $alert = $dateDif->format('%a');
                                    $htmlAlert = "<strong>$alert dia" . ($dias > 1 ? "s" : "") . " atrasada</strong>";
                                } else if ($dateDif->format('%R') == "-" && $dias > 0) {
                                    $class = "success";
                                    $alert = "$dias dia" . ($alert > 1 ? "s" : "") . " restantes";
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

                        $mensagem = html_entity_decode(
                                $secaoNome . urlencode("\n") .
                                "Envolvidos: " . $mensagemSecoes . urlencode("\n") .
                                $object->getTitulo() .
                                urlencode("\n") . "*Prazo " . dateFormat($object->getPrazo()) . " (" . $situacao . ")*" . urlencode("\n") .
                                (
                                !str_contains($arquivoDAO->getArquivo($object->getId()), "semarquivo") ?
                                urlencode("Anexo: http://intranet.2becmb.eb.mil.br/sistemas/SCC/include/arquivos/" . $object->getId() . ".pdf\n\n") :
                                urlencode("\n")
                                )
                                , ENT_QUOTES | ENT_HTML5, 'UTF-8'
                        );
                        $mensagemClara = '*' . $secaoNome . '*\nEnvolvidos: ' . $mensagemSecoes . '\n*' . $object->getTitulo() . '*\n*Assunto:* ' . $object->getAssunto() . '\n*Prazo:* ' . dateFormat($object->getPrazo()) . ' (' . $situacao . ')\n';
                        $mensagemClara .= (!str_contains($arquivoDAO->getArquivo($object->getId()), "semarquivo")) ?
                                "Anexo: http://intranet.2becmb.eb.mil.br/sistemas/SCC/include/arquivos/" . $object->getId() . '.pdf\n\n' :
                                '\n';
                        $mensagemGeral .= $mensagem;
                        $mensagemGeralClara .= $mensagemClara;
                        $link = "https://wa.me/" . $telefone . "?text=" . $mensagem;
                        ?>
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_COMANDO)) { ?>
                                <a href="../Controller/ComandoController.php?action=sped_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_COMANDO)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do documento?') ? document.location = '../Controller/ComandoController.php?action=sped_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                            <a href="<?= $link ?>" target="whatsapp"><img src="../include/imagens/whatsapp.png" width="34"></a>
                            <a href="#" onclick="copiarParaClipboardMensagem('<?= $mensagemClara ?>');"><img src="../include/imagens/copiar.png" width="25"></a>
                        </td>
                    </tr>                      
                <?php endforeach; ?>    
            <?php } ?>
        </tbody>
    </table>    
</div>
<div id="mensagemOculta" style="visibility: hidden;">
    <?php $linkGeral = "https://wa.me/?text=" . $mensagemGeral; ?>    
    <a href="<?= $linkGeral ?>" target="whatsapp"><img src="../include/imagens/whatsapp.png" width="34"></a>
    <a href="#" onclick="copiarParaClipboardMensagem('<?= $mensagemGeralClara ?>');"><img src="../include/imagens/copiar.png" width="25"></a>
</div>
<div class="modal fade" id="mensagem" tabindex="-1" role="dialog" aria-labelledby="mensagemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mensagemLabel">Mensagem copiada!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>                    
        </div>
    </div>
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

    function copiarParaClipboardMensagem(mensagem) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(mensagem)
                    .then(() => {
                        $("#mensagem").modal();
                        setTimeout(() => {
                            $("#mensagem").modal('hide');
                        }, 1000);
                    })
                    .catch(err => {
                        console.error("Erro ao copiar texto: ", err);
                    });
        } else {
            console.warn("Clipboard API não está disponível neste navegador.");
        }
    }
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
