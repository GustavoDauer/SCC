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
<script type="text/javascript">
    function showInformacoesAdicionais() {
        var x = document.getElementById("informacoesAdicionais");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
<div class="container mt-3">
    <hr>    
    <?php if (isset($e)) { ?>
        <div class="alert alert-danger">
            <strong>ERRO</strong><hr> <?= $e->getMessage() ?> <br><br>
            <a href="#" onclick="showInformacoesAdicionais()">Informações técnicas</a>
            <div id="informacoesAdicionais" style="display: none;">
                <i>Informações adicionais da versão de desenvolvimento sobre o erro:</i><br> 
                <textarea style="width: 100%; height: 70px;">Arquivo: <?= $e->getFile() . "\n" ?>Linha: <?= $e->getLine() . "\n" ?>Stack Trace: <?= $e->getTraceAsString() ?></textarea>
            </div>
        </div>
    <?php } ?>
    <a href="#" onclick="history.back(-1);">Retornar a página anterior</a>
</div>
<?php
require_once '../include/footer.php';
