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
$solucao = filter_input(INPUT_GET, "solucao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$hoje = new DateTime();
$dateDif = date_diff(new DateTime($secaoDAO->getBySecao("SecInfo")->getDataAtualizacaoOriginal()), $hoje);
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
<div class="conteudo">       
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalPopUp">Editar mensagem</button>    
    <h6 style="margin-top: 14px; font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("SecInfo")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <hr>
    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("SecInfo")->getMensagem(); ?></h6>
</div>                
<div class="modal fade" id="modalPopUp" tabindex="-1" role="dialog" aria-labelledby="modalPopUpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPopUpLabel">Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                                   
                <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("SecInfo")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= empty($secaoDAO->getBySecao("SecInfo")->getDataAtualizacao()) ? "" : $alert; ?></span></h6>
                <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("SecInfo")->getMensagem(); ?></h6>                
            </div>
            <div class="modal-footer">                
                <form accept-charset="UTF-8" id="formModalPopUp" action="../Controller/SecInfoController.php?action=mensagem_update" method="post">
                    <textarea name="mensagem" cols="81" placeholder="Mensagem opcional para o Comandante" maxlength="700"><?= $secaoDAO->getBySecao("SecInfo")->getMensagem(); ?></textarea><br>
                    <input type="submit" class="btn btn-primary" value="Atualizar">
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
            });
        });
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
