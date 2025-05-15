<link rel="stylesheet" href="../include/css/estilos.css">
<div align="center" class="titulo"><h2>Aniversariantes do mês de <?= mesPorExtenso($mes); ?></h2></div>            
<div class="subtitulo"><?= is_array($pessoaList) ? count($pessoaList) : "0" ?> aniversariantes</div>
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="botao"><a href="../Controller/RPController.php?action=aniversariantes&mes=<?= $mesAnterior ?>" class="botaoLink"><</a></td>
        <td style="width: 100%;">
<?php if (is_array($pessoaList)) { ?> 
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <div align="center">
                                <ul class="painel">
                                    <?php
                                    foreach ($pessoaList as $pessoa):
                                        $dateDif = date_diff($hoje, new DateTime(equalizeYear($pessoa->getDataNascimento())));
                                        if ($dateDif->format('%a') == 0) {
                                            $bolo = "bolo_aniversario";
                                            $color = "black;";
                                        } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') == 1) {
                                            $bolo = "bolo_aceso";
                                            $color = "black;";
                                        } else if ($dateDif->format('%R') == "-") {
                                            $bolo = "bolo_apagado";
                                            $color = "gray;";
                                        } else {
                                            $bolo = "bolo";
                                            $color = "black;";
                                        }                                        
                                        ?>
                                        <li class="linhaPainel" style="color: <?= $color ?>;">
                                            <img src="../include/imagens/<?= $bolo ?>.png" width="50" vspace="7"><br>
                                            <?= $postoDAO->getById($pessoa->getIdPosto())->getPosto(); ?><br>
                                            <b><?= strtoupper(html_entity_decode($pessoa->getNomeGuerra(), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?></b><br>
                                        <?= date_format(new DateTime($pessoa->getDataNascimento()), "d/m") ?><br>  
                                        </li>
    <?php endforeach; ?>    
                                </ul>
                            </div>
                        </td>            
                    </tr>
                </table>
<?php } ?>
        </td>
        <td class="botao"><a href="../Controller/RPController.php?action=aniversariantes&mes=<?= $mesPosterior ?>" class="botaoLink">></a></td>
    </tr>
</table>