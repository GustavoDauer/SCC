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
    ?>    
    <h6 style="font-size: 16px;margin: 0;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("S2")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <div style="text-align: center;">
        <span style="font-size: 10px; font-family: sans-serif;">   
            <a href="../Controller/S2Controller.php?action=getAllList">
                <img src="../include/imagens/gerenciar_usuarios.png" width="25" height="25" hspace="2" vspace="2"> Cadastros
            </a> |                   
            <img src="../include/imagens/s2.png" width="25" height="25" hspace="2" vspace="2"> Auditorias
            |
        </span>
        <!--<hr style="margin: 0px;">-->
    </div>
    <div align="center">
        <form action="../Controller/S2Controller.php" method="get" id="filtro">        
            <input type="hidden" name="action" value="auditoriaList">
            Entrada entre <input type="date" id="inicio" name="inicio" value="<?= $inicio ?>" onchange="update();"> 
            | <input type="date" id="fim" name="fim" value="<?= $fim ?>" onchange="update();">
        </form>
    </div>
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTablePessoa');"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTablePessoa');">        
        <span style="margin-left: 14px; font-weight: bold;">AUDITORIA DE PESSOAS</span> <a href="../View/view_S2_servico_pessoa.php" target="_blank">Módulo Serviço</a>
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
                <th>Usuário</th>                
                <th>Data</th>                         
                <th>Local</th>     
                <th>Autorização</th>
                <!--<th></th>                -->
            </tr>
        </thead>
        <tbody id="myTablePessoa">   
            <?php if (is_array($auditoriaPessoaList) && isAdminLevel($LISTAR_S2)) { ?> 
                <?php
                foreach ($auditoriaPessoaList as $auditoriaPessoa):
                    $pessoa = $auditoriaPessoa->getIdPessoa() > 0 ? $pessoaDAO->getById($auditoriaPessoa->getIdPessoa()) : new Pessoa();
                    ?>
                    <tr>                                           
                        <td style="text-align: center;">
                            <?php if ($auditoriaPessoa->getIdPessoa() > 0) { ?>
                                <img src="<?= $pessoa->getUploadedPhoto() ?>" width="70" height="70" vspace="7"><br>
                                <?= $postoDAO->getById($pessoa->getIdPosto())->getPosto(); ?> <?= $pessoa->getNomeGuerra() ?> - <?= $pessoa->getNome() ?><br>
                                <b>Vínculo:</b> <?= $vinculoDAO->getById($pessoa->getIdVinculo())->getVinculo(); ?> / <b>CPF:</b> <?= $pessoa->getCpf() ?><br>
                                <b>Identidade Militar:</b> <?= $pessoa->getIdentidadeMilitar() ?> / <b>PREC-CP:</b> <?= $pessoa->getPreccp() ?><br>
                            <?php } else { ?>
                                Desconhecido                                
                            <?php } ?>
                        </td>                                                         
                        <td style="padding: 25px;vertical-align: middle;">                            
                            <?= (new DateTime($auditoriaPessoa->getDataEntrada()))->format("d/m/Y"); ?>                                                             
                        </td>
                        <td>
                            <?= $auditoriaPessoa->getLocal() === "batalhao" ? "Portão Lateral do Batalhão" : "Vila Militar"; ?>                     
                        </td>
                        <td style="white-space: nowrap;vertical-align: middle;">
                            <?php
                            if ($auditoriaPessoa->getAutorizacao() == 1) {
                                ?>
                                <span class="alert alert-success"><strong>Autorizado</strong></span>                                                                
                                <?php
                            } else {
                                ?>
                                <span class="alert alert-danger"><strong>Não Autorizado</strong></span>
                                <?php
                            }
                            ?>
                        </td>
                        <!--<td style="white-space: nowrap">                            
                            <?php if (isAdminLevel($EXCLUIR_S2)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do item?') ? document.location = '../Controller/S2Controller.php?action=pessoa_auditoria_delete&id=<?= $pessoa->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>-->
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
        <span style="margin-left: 14px; font-weight: bold;">AUDITORIA DE VEÍCULOS</span> <a href="../View/view_S2_servico_veiculo.php" target="_blank">Módulo Serviço</a>
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
                <th>Usuário</th>                
                <th>Data</th>                         
                <th>Local</th>
                <th>Autorização</th>
                <!--<th></th>-->
            </tr>
        </thead>
        <tbody id="myTableVeiculo">   
            <?php if (is_array($auditoriaVeiculoList) && isAdminLevel($LISTAR_S2)) { ?> 
                <?php
                foreach ($auditoriaVeiculoList as $object):
                    $veiculo = $object->getIdVeiculo() > 0 ? $veiculoDAO->getById($object->getIdVeiculo()) : null;
                    ?>
                    <tr>                                           
                        <td style="text-align: center;">                                                        
                            <?php if (!is_null($veiculo)) { ?>
                                <?= $veiculo->getTipo() ?> 
                                <?= $veiculo->getMarca() ?> <?= $veiculo->getModelo() ?> <?= $veiculo->getAnoFabricacao() ?> / <?= $veiculo->getAnoModelo() ?> <input type="color" value="<?= $veiculo->getCor() ?>" disabled> <?= $veiculo->getPlaca() ?> - 
                                <?= ($veiculo->getIdPessoa() > 0 ? $pessoaDAO->getById($veiculo->getIdPessoa())->getNome() : ""); ?>     
                            <?php } ?>
                            <?= !empty($object->getPreccp()) ? "Nome: " . $object->getNome() . " PREC-CP: " . $object->getPreccp() . " - Placa: " . $object->getPlaca() : ""; ?>
                        </td>
                        <td><?= date_format(new DateTime($object->getDataEntrada()), "d/m/Y H:i:s"); ?></td>         
                        <td><?= $object->getLocal() === "batalhao" ? "Estacionamento Batalhão" : "Vila Militar"; ?></td>
                        <td style="white-space: nowrap;vertical-align: middle;">
                            <?php
                            if ($object->getAutorizacao() == 1 && !empty($object->getPreccp())) {
                                ?>
                                <span class="alert alert-warning"><strong>Visitante Autorizado</strong></span>                                
                                <?php
                            } else if ($object->getAutorizacao() == 1) {
                                ?>
                                <span class="alert alert-success"><strong>Autorizado</strong></span>
                                <?php
                            } else {
                                ?>
                                <span class="alert alert-danger"><strong>Não Autorizado</strong></span>
                                <?php
                            }
                            ?>
                        </td>
                        <!--<td style="white-space: nowrap">                            
                            <?php if (isAdminLevel($EXCLUIR_S2)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do item?') ? document.location = '../Controller/S2Controller.php?action=veiculo_auditoria_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>-->
                    </tr>                    
                <?php endforeach; ?>    
            <?php } ?>
        </tbody>
    </table>    
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
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
