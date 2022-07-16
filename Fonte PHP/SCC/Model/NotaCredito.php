<?php

class NotaCredito {

    private $id,
            $dataNc,
            $nc,
            $pi,
            $valor,
            $gestorNc,
            $ptres,
            $fonte,
            $ug,
            $valorRecolhido;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->dataNc = $idOrRow["dataNc"];
            $this->nc = $idOrRow["nc"];
            $this->pi = $idOrRow["pi"];
            $this->valor = $idOrRow["valor"]; //
            $this->gestorNc = $idOrRow["gestorNc"]; //
            $this->ptres = $idOrRow["ptres"];
            $this->fonte = $idOrRow["fonte"];
            $this->ug = $idOrRow["ug"];
            $this->valorRecolhido = $idOrRow["valorRecolhido"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getDataNc() {
        return $this->dataNc;
    }

    function getNc() {
        return $this->nc;
    }

    function getPi() {
        return $this->pi;
    }

    function getValor() {
        return $this->valor;
    }

    function getGestorNc() {
        return $this->gestorNc;
    }

    function getPtres() {
        return $this->ptres;
    }

    function getFonte() {
        return $this->fonte;
    }

    function getUg() {
        return $this->ug;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDataNc($dataNc) {
        $this->dataNc = $dataNc;
    }

    function setNc($nc) {
        $this->nc = $nc;
    }

    function setPi($pi) {
        $this->pi = $pi;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setGestorNc($gestorNc) {
        $this->gestorNc = $gestorNc;
    }

    function setPtres($ptres) {
        $this->ptres = $ptres;
    }

    function setFonte($fonte) {
        $this->fonte = $fonte;
    }

    function setUg($ug) {
        $this->ug = $ug;
    }

    public function getValorRecolhido() {
        return $this->valorRecolhido;
    }

    public function setValorRecolhido($valorRecolhido) {
        $this->valorRecolhido = $valorRecolhido;
    }

}
