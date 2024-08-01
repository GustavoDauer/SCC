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
class Veiculo {

    private $id,
            $marca,
            $modelo,
            $anoFabricacao,
            $anoModelo,
            $cor,
            $placa,
            $placaEB,
            $tipo,
            $idPessoa;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->marca = $idOrRow["marca"];
            $this->modelo = $idOrRow["modelo"];
            $this->anoFabricacao = $idOrRow["anoFabricacao"];
            $this->anoModelo = $idOrRow["anoModelo"];
            $this->cor = $idOrRow["cor"];
            $this->placa = $idOrRow["placa"];
            $this->placaEB = $idOrRow["placaEB"];
            $this->tipo = $idOrRow["tipo"];
            $this->idPessoa = $idOrRow["idPessoa"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getAnoFabricacao() {
        return $this->anoFabricacao;
    }

    public function getAnoModelo() {
        return $this->anoModelo;
    }

    public function getCor() {
        return $this->cor;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function getPlacaEB() {
        return $this->placaEB;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setAnoFabricacao($anoFabricacao) {
        $this->anoFabricacao = $anoFabricacao;
    }

    public function setAnoModelo($anoModelo) {
        $this->anoModelo = $anoModelo;
    }

    public function setCor($cor) {
        $this->cor = $cor;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function setPlacaEB($placaEB) {
        $this->placaEB = $placaEB;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function validate() {
        return $this->tipo != null && !empty($this->tipo);
    }
}
