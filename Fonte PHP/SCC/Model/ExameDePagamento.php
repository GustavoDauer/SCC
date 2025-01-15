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
class Identidade {

    private $linha, $id1, $id2, $id3, $id4;

    function __construct($linha = "") {
        $this->linha = $linha;
    }

    function getLinha() {
        return $this->linha;
    }

    function setLinha($linha) {
        $this->linha = $linha;
    }

    public function getId1() {
        return $this->id1;
    }

    public function getId2() {
        return $this->id2;
    }

    public function getId3() {
        return $this->id3;
    }

    public function getId4() {
        return $this->id4;
    }

    public function setId1($id1) {
        $this->id1 = $id1;
    }

    public function setId2($id2) {
        $this->id2 = $id2;
    }

    public function setId3($id3) {
        $this->id3 = $id3;
    }

    public function setId4($id4) {
        $this->id4 = $id4;
    }

    function validate() {
        return $this->linha != null && !empty($this->linha);
    }
}
