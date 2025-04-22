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
<script type="text/javascript" src="../include/js/common.js"></script>
<div class="conteudo">       
    <div align="center">                
    </div>       
    <?php
    $dataHoje = date('Y-m-d');
    $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
    $inicio = !empty(filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataHoje;
    $fim = !empty(filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataAmanha;
    $hoje = new DateTime();
    $alert = "";
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("S2")->getDataAtualizacaoOriginal()), $hoje);
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
    $dataExpiracao = filter_input(INPUT_GET, "dataExpiracao", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
    ?>    
    <h6 style="font-size: 16px;margin: 0;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("S2")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <div style="text-align: center;">
        <span style="font-size: 10px; font-family: sans-serif;">                                                    
            <img src="../include/imagens/gerenciar_usuarios.png" width="25" height="25" hspace="2" vspace="2"> Cadastros | 
            <a href="../Controller/S2Controller.php?action=auditoriaList">                            
                <img src="../include/imagens/s2.png" width="25" height="25" hspace="2" vspace="2"> Auditorias
            </a> |                        
        </span>
        <!--<hr style="margin: 0px;">-->
    </div>
    <div align="center">
        <form action="../Controller/S2Controller.php" method="get" id="filtro">        
            <input type="hidden" name="action" value="getAllList">
            <input type="radio" id="dataExpiracao" name="dataExpiracao" value="todos" onchange="update();" <?= $dataExpiracao == "todos" ? " checked" : "" ?>> Exibir todos <input type="radio" id="dataExpiracao" name="dataExpiracao" value="ativos" onchange="update();" <?= $dataExpiracao == "ativos" || empty($dataExpiracao) ? " checked" : "" ?>> Ativos  <input type="radio" id="dataExpiracao" name="dataExpiracao" value="expirados" onchange="update();" <?= $dataExpiracao == "expirados" ? " checked" : "" ?>> Expirados 
        </form> 
    </div>
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <form action="../Controller/S2Controller.php" method="post" id="importar" enctype="multipart/form-data">
            <input type="hidden" name="action" value="import">
            <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTablePessoa');"> 
            <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTablePessoa');">  
            <span style="margin-left: 14px; font-weight: bold;">CADASTRO DE PESSOAS</span> 
            <input type="file" name="planilhaPessoas" accept=".csv" onchange="importar();"> <a href="../View/view_S2_servico_pessoa.php" target="_blank">Módulo Serviço</a>
        </form>
    </div>
    <br>    
    <table class="table table-bordered">
        <thead>                        
            <tr>
                <th colspan="25">                       
                    <span id="contadorPessoa" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></span>       
                </th>
            </tr>
            <tr>                
                <th>P/G - Nome</th>                
                <th>Vínculo</th>                         
                <th>Documentos</th>     
                <th>Expiração</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_S2)) { ?>
                        <a href="../Controller/S2Controller.php?action=pessoa_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTablePessoa">   
            <?php if (is_array($pessoaList) && isAdminLevel($LISTAR_S2)) { ?> 
                <?php
                foreach ($pessoaList as $pessoa):
                    $alert = "";
                    $colorClass = "";
                    $dateDif = date_diff(new DateTime($pessoa->getDataExpiracao()), $hoje);
                    if ($dateDif->format('%R') == "-" && $dateDif->format('%a') >= 30) {
                        $colorClass = "success";
                        $alert = $dateDif->format('%a') . " dia(s) restantes";
                    } else if ($dateDif->format('%R') == "-" && $dateDif->format('%a') >= 10 && $dateDif->format('%a') < 30) {
                        $colorClass = "warning";
                        $alert = $dateDif->format('%a') . " dia(s) restantes";
                    } else if ($dateDif->format('%R') == "-" && $dateDif->format('%a') >= 0 && $dateDif->format('%a') < 10) {
                        $colorClass = "danger";
                        $alert = $dateDif->format('%a') . " dia(s) restantes";
                    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') == 0) {
                        $colorClass = "danger";
                        $alert = "Expirando hoje";
                    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') > 0) {
                        $colorClass = "secondary";
                        $alert = "Expirado há " . $dateDif->format('%a') . " dia(s)";
                    }
                    ?>
                    <tr>                                           
                        <td style="text-align: center;">
                            <img src="<?= $pessoa->getUploadedPhoto() ?>" width="70" height="70" vspace="7">
                            <?= $postoDAO->getById($pessoa->getIdPosto())->getPosto(); ?> <?= $pessoa->getNomeGuerra() ?> <sup><?= $pessoa->getNome() ?></sup>
                        </td>
                        <td>
                            <?= $vinculoDAO->getById($pessoa->getIdVinculo())->getVinculo(); ?> 
                        </td>         
                        <td>
                            CPF: <?= $pessoa->getCpf() ?><br>
                            Identidade Militar: <?= $pessoa->getIdentidadeMilitar() ?>
                            <!--PREC-CP: <?= $pessoa->getPreccp() ?><br>-->
                        </td>
                        <td style="padding: 25px; white-space: nowrap;">
                            <span class="alert alert-<?= $colorClass ?>" style="font-weight: bold;">
                                <?= (new DateTime($pessoa->getDataExpiracao()))->format("d/m/Y"); ?>
                                <?= $alert ?>                                
                            </span>                            
                        </td>
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_S2)) { ?>
                                <a href="../Controller/S2Controller.php?action=pessoa_update&id=<?= $pessoa->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_S2)) { ?>
                                <a href="#" onclick="confirm('A data de expiração do militar será configurada para o ano anterior.') ? document.location = '../Controller/S2Controller.php?action=pessoa_delete&id=<?= $pessoa->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>
                    </tr>                    
                <?php endforeach; ?>    
            <?php } ?>
        </tbody>
    </table>
    <!------------------------------------------------------->
    <!-- VEÍCULOS -->
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTableVeiculo');"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTableVeiculo');">        
        <span style="margin-left: 14px; font-weight: bold;">CADASTRO DE VEÍCULOS</span> <a href="../View/view_S2_servico_veiculo.php" target="_blank">Módulo Serviço</a>
    </div>
    <br>    
    <table class="table table-bordered">
        <thead>                     
            <tr>
                <th colspan="25">                    
                    <div id="contadorVeiculo" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                </th>
            </tr>
            <tr>                
                <th>Marca/Modelo/Ano</th>                
                <th>Placa</th>                         
                <th>Tipo</th>
                <th>Proprietário</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_S2)) { ?>
                        <a href="../Controller/S2Controller.php?action=veiculo_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTableVeiculo">   
            <?php if (is_array($veiculoList) && isAdminLevel($LISTAR_S2)) { ?> 
                <?php
                foreach ($veiculoList as $object):
                    $idPosto = $pessoaDAO->getById($object->getIdPessoa())->getIdPosto();
                    ?>
                    <tr>                                           
                        <td style="text-align: center;">
                            <?= $object->getMarca() ?> <?= $object->getModelo() ?> <?= $object->getAnoFabricacao() ?> / <?= $object->getAnoModelo() ?> <input type="color" value="<?= $object->getCor() ?>" disabled>
                        </td>
                        <td>
                            <?= $object->getPlaca() ?> 
                        </td>         
                        <td><?= $object->getTipo() ?></td>
                        <td><?= $postoDAO->getById($idPosto)->getPosto(); ?> <?= ($object->getIdPessoa() > 0 ? $pessoaDAO->getById($object->getIdPessoa())->getNome() : ""); ?></td>                        
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_S2)) { ?>
                                <a href="../Controller/S2Controller.php?action=veiculo_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_S2)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do item?') ? document.location = '../Controller/S2Controller.php?action=veiculo_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
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
                <h5 class="modal-title" id="mensagemLabel">Relatório do processo de importação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                  
                <span style='font-size: 14px;'><?= $importLog ?></span><hr><b>Fim</b>
            </div>
            <div class="modal-footer">                                
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#myInputVeiculo").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTableVeiculo tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                countRows();
            });
        });
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function countRows() {
        let rowCount = $('#myTableVeiculo tr:visible').length;
        var message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
        document.getElementById("contadorVeiculo").innerHTML = message;
        rowCount = $('#myTablePessoa tr:visible').length;
        message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
        document.getElementById("contadorPessoa").innerHTML = message;
    }

    countRows();

    if (getCookie("myTableVeiculo") === "1") {
        minimize("myTableVeiculo");
    }

    if (getCookie("myTablePessoa") === "1") {
        minimize("myTablePessoa");
    }

    function importar() {
        document.getElementById("importar").submit();
    }

<?php
if (isset($importLog)) {
    ?>
        $("#editarMensagem").modal();
    <?php
}
?>

</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
