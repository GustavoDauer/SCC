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
 * publicada pela Free Software Foundation (RPF); na versão 3 da
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
$hoje = date('Y-m-d');
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<div class="container">  
    <form accept-charset="UTF-8" action="../Controller/RPController.php?action=visitante_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Visitante | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">          
        <div class="form-group">
            <div class="form-row"> 
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Foto</span>
                        <img src='<?= $fotoDAO->getFoto($object->getId()); ?>' style='margin-left: 50px; width: 400px; height: 400px'> 
                    </div>
                    <br>                    
                </div>
                <div class="col">  
                    <input class="form-control" type="file" name="arquivoFoto">
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nome</span>
                        <input type="text" class="form-control" id="nome" placeholder="Qual o nome completo do visitante?" name="nome" oninput="this.value = this.value.toUpperCase()" required onchange="check();" maxlength="125" value="<?= $object->getNome() ?>" required>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Obrigatório</div>
                    </div>
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">CPF</span>
                        <input type="text" class="form-control" id="cpf" placeholder="Qual o CPF do visitante?" name="cpf"  maxlength="16" value="<?= $object->getCpf() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>  
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Telefone</span>
                        <input type="text" class="form-control" id="telefone" placeholder="Qual o telefone de contato do visitante?" name="telefone"  maxlength="14" value="<?= $object->getTelefone() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Destino</span>
                        <input type="text" class="form-control" id="bar" placeholder="Qual o destino do visitante?" name="destino"  maxlength="250" value="<?= $object->getDestino() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                    <br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Crachá</span>
                        <input type="text" class="form-control" id="cracha" name="cracha" placeholder="Qual o número do crachá?" value="<?= $object->getCracha(); ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>  
                    <br>
                    <input type="checkbox" style="margin: 14px;" id="temporario" name="temporario" value="1" <?= $object->getTemporario() == 1 ? "checked" : ""; ?>>Prestador de serviço autorizado temporariamente
                </div>                                
            </div>
        </div>            
        <?php
        try {
            $dataEntrada = explode(" ", $object->getDataEntrada());
            if (count($dataEntrada) < 2) {
                $dataEntrada[0] = "";
                $dataEntrada[1] = "";
            }
            $dataSaida = explode(" ", $object->getDataSaida());

            if (count($dataSaida) < 2) {
                $dataSaida[0] = "";
                $dataSaida[1] = "";
            }
        } catch (Exception $e) {
            echo "Ocorreu um problema na manipulação de datas, informe o Administrador do Sistema.";
        }
        ?>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data de Entrada</span> 
                        <input type="date" class="form-control" id="dataEntrada" name="dataEntrada"  value="<?= empty($dataEntrada[0]) ? $hoje : $dataEntrada[0] ?>" required>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">                                       
                    <input type="time" class="form-control" id="horaEntrada" name="horaEntrada"value="<?= $dataEntrada[1] ?>" required>                        
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data de saída</span>
                        <input type="date" class="form-control" id="dataSaida" name="dataSaida"value="<?= $dataSaida[0] ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">                                       
                    <input type="time" class="form-control" id="horaSaida" name="horaSaida"value="<?= $dataSaida[1] ?>">                        
                </div>                                    
            </div>
        </div>    
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                                     
                </div>                                               
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<script>
    // Disable form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Get the forms we want to add validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    String.prototype.reverse = function () {
        return this.split('').reverse().join('');
    };

    $(document).ready(function () {
        $('[name=telefone]').mask('(00)#0000-0000');
        $('[name=cpf]').mask('000.000.000-00');
    });
</script>
<?php
require_once '../include/footer.php';
