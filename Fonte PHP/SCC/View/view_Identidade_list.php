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
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<div class="container">  <!--../Controller/IdentidadeController.php?action=gerar-->
    <form accept-charset="UTF-8" action="../Controller/IdentidadeController.php?action=gerar" target="_blank" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
        <h2>Gerar Identidade | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Gerar</button></h2>
        <hr>   
        <div class="alert alert-warning">
            <strong>ATENÇÃO: </strong>
            Devem ser respeitadas as colunas da planilha auxiliar conforme seguinte modelo:<br>
            <blockquote style="font-size: 10px;">
                <i>
                    coluna_em_branco	om1	nr_idt_mil1	dt_validade1	NOME DE GUERRA	nome_completo1	p_grad1	qm1	nome_pai1	nome_mae1	cidade_nasc1	uf_nasc1	pais_nasc1	dt_nasc1	idt_civil1	org_emissor1	cpf1	cidade_expedicao1	uf_exped1	data_impressao1	enc_pessoal1	SEPARADOR<br>
                    om2	nr_idt_mil2	dt_validade2	NOME DE GUERRA	nome_completo2	p_grad2	qm2	nome_pai2	nome_mae2	cidade_nasc2	uf_nasc2	pais_nasc2	dt_nasc2	idt_civil2	org_emissor2	cpf2	cidade_expedicao2	uf_exped2	data_impressao2	enc_pessoal2	SEPARADOR<br>
                    om3	nr_idt_mil3	dt_validade3	NOME DE GUERRA	nome_completo3	p_grad3	qm3	nome_pai3	nome_mae3	cidade_nasc3	uf_nasc3	pais_nasc3	dt_nasc3	idt_civil3	org_emissor3	cpf3	cidade_expedicao3	uf_exped3	data_impressao3	enc_pessoal3	SEPARADOR<br>
                    om4	nr_idt_mil4	dt_validade4	NOME DE GUERRA	nome_completo4	p_grad4	qm4	nome_pai4	nome_mae4	cidade_nasc4	uf_nasc4	pais_nasc4	dt_nasc4	idt_civil4	org_emissor4	cpf4	cidade_expedicao4	uf_exped4	data_impressao4	enc_pessoal4	dt_validade4
                </i>
                <br><br>
                <strong>Todos os campos devem estar na mesma linha!</strong>
            </blockquote>
        </div>
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">          
        <div class="form-group">
            <div class="form-row"> 
                <div class="col">  
                    <div class="input-group-prepend">
                        <span class="input-group-text">Linha</span>
                        <input type="text" class="form-control" id="linha" placeholder="Cole a linha do excel" name="linha" required>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Obrigatório</div>
                    </div>                    
                </div>                                
            </div>
        </div>            
        <hr>
        <button type="submit" class="btn btn-primary">Gerar</button>
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
</script>
<?php
require_once '../include/footer.php';
