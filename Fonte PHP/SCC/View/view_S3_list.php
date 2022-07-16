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
$hoje = new DateTime();

function formatValue($value) {
    echo "<span style='color:" . ($value <= 0 ? "red" : "green") . "'>$value</span>";
}
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
    <?php
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("S3")->getDataAtualizacaoOriginal()), $hoje);
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
    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("S3")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("S3")->getMensagem(); ?></h6>
    <div align="left">                        
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#combustivel">Editar mensagem</button>
    </div>        
    <br>    
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTableM');"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTableM');">        
        <span style="margin-left: 14px; font-weight: bold;">AGENDA S3</span>
    </div>
    <iframe src="https://docs.google.com/spreadsheets/d/1fdEb4_KlT3KfV3OkHMhH4AsdoHWwvMTtmIwbDiqSf9c/edit?usp=drivesdk" width="100%" height="1024px" style="border: 0px;"></iframe>
    <br>       
    <div class="modal fade" id="combustivel" tabindex="-1" role="dialog" aria-labelledby="combustivelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 800px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="combustivelLabel">Mensagem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                  
                    <?php
                    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("S3")->getDataAtualizacaoOriginal()), $hoje);
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
                    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("S3")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= empty($secaoDAO->getBySecao("S3")->getDataAtualizacao()) ? "" : $alert; ?></span></h6>
                    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("S3")->getMensagem(); ?></h6>                
                </div>
                <div class="modal-footer">                
                    <form accept-charset="UTF-8" id="formAgenda" action="../Controller/S3Controller.php?action=mensagem_update" method="post">                    
                        <?php if (isAdminLevel($EDITAR_S3)) { ?>                        
                            <textarea name="mensagem" cols="81" placeholder="Mensagem opcional para o Comandante" maxlength="700"><?= $secaoDAO->getBySecao("S3")->getMensagem(); ?></textarea><br>
                            <input type="submit" class="btn btn-primary" value="Atualizar">
                        <?php } ?>
                    </form>
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

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        if (getCookie("myTableM") === "1") {
            minimize("myTableM");
        }

        if (getCookie("myTableC1") === "1") {
            minimize("myTableC1");
            minimize("myTableC2");
        }

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
    