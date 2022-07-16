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
<div class="conteudo">            
    <table class="table table-bordered">
        <thead>
            <tr>                
                <th>Categoria</th>                
                <th>
                    <?php if (isAdminLevel($ADICIONAR_CATEGORIA)) { ?>
                        <a href="../Controller/CategoriaController.php?action=insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTable">   
            <?php if (is_array($objectList)) { ?> 
                <?php foreach ($objectList as $object): ?>
                    <tr>
                        <td><a href="../Controller/CategoriaController.php?action=update&id=<?= $object->getId() ?>"><?php echo $object->getCategoria(); ?></a></td>                        
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_USUARIO)) { ?>
                                <a href="../Controller/CategoriaController.php?action=update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_USUARIO)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do item?') ? document.location = '../Controller/CategoriaController.php?action=delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
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
            });
        });
    });
</script>
<?php
require_once '../include/footer.php';
