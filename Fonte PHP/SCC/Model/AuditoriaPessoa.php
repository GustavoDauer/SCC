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
class AuditoriaPessoa {

    private $idPessoa,
            $dataEntrada,
            $dataSaida,
            $local,
            $autorizacao;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->idPessoa = $idOrRow["idPessoa"];
            $this->dataEntrada = $idOrRow["dataEntrada"];
            $this->dataSaida = $idOrRow["dataSaida"];
            $this->local = $idOrRow["local"];
            $this->autorizacao = $idOrRow["autorizacao"];
        }
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getDataEntrada() {
        return $this->dataEntrada;
    }

    public function getDataSaida() {
        return $this->dataSaida;
    }

    public function getLocal() {
        return $this->local;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setDataEntrada($dataEntrada) {
        $this->dataEntrada = $dataEntrada;
    }

    public function setDataSaida($dataSaida) {
        $this->dataSaida = $dataSaida;
    }

    public function setLocal($local) {
        $this->local = $local;
    }

    public function getAutorizacao() {
        return $this->autorizacao;
    }

    public function setAutorizacao($autorizacao) {
        $this->autorizacao = $autorizacao;
    }

    public function validate() {
        return $this->idPessoa != null && !empty($this->idPessoa) && $this->dataEntrada != null && !empty($this->dataEntrada);
    }
}
