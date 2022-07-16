<?php

class Item {

    private $id,
            $numeroItem,
            $descricao,
            $quantidade,
            $valor,
            $idRequisicao;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->numeroItem = $idOrRow["numeroItem"];
            $this->descricao = $idOrRow["descricao"];
            $this->quantidade = $idOrRow["quantidade"];
            $this->valor = $idOrRow["valor"]; //
            $this->idRequisicao = $idOrRow["idRequisicao"]; //           
        }
    }

    function getId() {
        return $this->id;
    }

    function getNumeroItem() {
        return $this->numeroItem;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getValor() {
        return $this->valor;
    }

    function getIdRequisicao() {
        return $this->idRequisicao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumeroItem($numeroItem) {
        $this->numeroItem = $numeroItem;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setIdRequisicao($idRequisicao) {
        $this->idRequisicao = $idRequisicao;
    }

}
