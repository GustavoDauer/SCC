<?php

class Requisicao {

    private $id,
            $dataRequisicao,
            $idNotaCredito,
            $om,
            $idSecao,
            $descricao,
            $pe,
            $ug,
            $ompe,
            $empresa,
            $cnpj,
            $contato,
            $ne,
            $observacaoAquisicoes,
            $dataEnvioNE,
            $valorNE,
            $dataAprovacao,
            $observacaoConformidade,
            $parecer,
            $dataEntregaMaterial,
            $numeroDiex,
            $processoAdministrativo,
            $numeroOficio,
            $boletim,
            $dataUltimaLiquidacao,
            $valorLiquidar,
            $itemList,
            $dataRequisicaoFormatada,
            $dataEnvioNEFormatada,
            $dataNE,
            $observacaoAlmox,
            $dataPrazoEntrega,
            $idCategoria,
            $dataNEFormatada;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->dataRequisicao = $idOrRow["dataRequisicao"];
            $this->idNotaCredito = $idOrRow["idNotaCredito"];
            $this->om = $idOrRow["om"];
            $this->idSecao = $idOrRow["idSecao"];
            $this->descricao = $idOrRow["descricao"]; //            
            $this->pe = $idOrRow["pe"];
            $this->ug = $idOrRow["ug"];
            $this->ompe = $idOrRow["ompe"];
            $this->empresa = $idOrRow["empresa"]; //
            $this->cnpj = $idOrRow["cnpj"];
            $this->contato = $idOrRow["contato"];
            $this->ne = $idOrRow["ne"];
            $this->observacaoAquisicoes = $idOrRow["observacaoAquisicoes"];
            $this->dataEnvioNE = $idOrRow["dataEnvioNE"];
            $this->valorNE = $idOrRow["valorNE"];
            $this->dataAprovacao = $idOrRow["dataAprovacao"];
            $this->observacaoConformidade = $idOrRow["observacaoConformidade"];
            $this->parecer = $idOrRow["parecer"];
            $this->dataEntregaMaterial = $idOrRow["dataEntregaMaterial"];
            $this->numeroDiex = $idOrRow["numeroDiex"];
            $this->processoAdministrativo = $idOrRow["processoAdministrativo"];
            $this->numeroOficio = $idOrRow["numeroOficio"];
            $this->boletim = $idOrRow["boletim"];
            $this->dataUltimaLiquidacao = $idOrRow["dataUltimaLiquidacao"];
            $this->valorLiquidar = $idOrRow["valorLiquidar"];
            $this->itemList = $idOrRow["itemList"];
            $this->dataRequisicaoFormatada = $idOrRow["dataRequisicaoFormatada"];
            $this->dataEnvioNEFormatada = $idOrRow["dataEnvioNEFormatada"];
            $this->dataNE = $idOrRow["dataNE"];
            $this->observacaoAlmox = $idOrRow["observacaoAlmox"];
            $this->dataPrazoEntrega = $idOrRow["dataPrazoEntrega"];
            $this->idCategoria = $idOrRow["idCategoria"];
            $this->dataNEFormatada = $idOrRow["dataNEFormatada"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getDataRequisicao() {
        return $this->dataRequisicao;
    }

    public function getIdNotaCredito() {
        return $this->idNotaCredito;
    }

    public function getOm() {
        return $this->om;
    }

    public function getIdSecao() {
        return $this->idSecao;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getPe() {
        return $this->pe;
    }

    public function getUg() {
        return $this->ug;
    }

    public function getOmpe() {
        return $this->ompe;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getContato() {
        return $this->contato;
    }

    public function getNe() {
        return $this->ne;
    }

    public function getObservacaoAquisicoes() {
        return $this->observacaoAquisicoes;
    }

    public function getDataEnvioNE() {
        return $this->dataEnvioNE;
    }

    public function getValorNE() {
        return $this->valorNE;
    }

    public function getDataAprovacao() {
        return $this->dataAprovacao;
    }

    public function getObservacaoConformidade() {
        return $this->observacaoConformidade;
    }

    public function getParecer() {
        return $this->parecer;
    }

    public function getDataEntregaMaterial() {
        return $this->dataEntregaMaterial;
    }

    public function getNumeroDiex() {
        return $this->numeroDiex;
    }

    public function getProcessoAdministrativo() {
        return $this->processoAdministrativo;
    }

    public function getNumeroOficio() {
        return $this->numeroOficio;
    }

    public function getBoletim() {
        return $this->boletim;
    }

    public function getDataUltimaLiquidacao() {
        return $this->dataUltimaLiquidacao;
    }

    public function getValorLiquidar() {
        return $this->valorLiquidar;
    }

    public function getItemList() {
        return $this->itemList;
    }

    public function getDataRequisicaoFormatada() {
        return $this->dataRequisicaoFormatada;
    }

    public function getDataEnvioNEFormatada() {
        return $this->dataEnvioNEFormatada;
    }

    public function getDataNE() {
        return $this->dataNE;
    }

    public function getObservacaoAlmox() {
        return $this->observacaoAlmox;
    }

    public function getDataPrazoEntrega() {
        return $this->dataPrazoEntrega;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDataRequisicao($dataRequisicao) {
        $this->dataRequisicao = $dataRequisicao;
    }

    public function setIdNotaCredito($idNotaCredito) {
        $this->idNotaCredito = $idNotaCredito;
    }

    public function setOm($om) {
        $this->om = $om;
    }

    public function setIdSecao($idSecao) {
        $this->idSecao = $idSecao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setPe($pe) {
        $this->pe = $pe;
    }

    public function setUg($ug) {
        $this->ug = $ug;
    }

    public function setOmpe($ompe) {
        $this->ompe = $ompe;
    }

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function setContato($contato) {
        $this->contato = $contato;
    }

    public function setNe($ne) {
        $this->ne = $ne;
    }

    public function setObservacaoAquisicoes($observacaoAquisicoes) {
        $this->observacaoAquisicoes = $observacaoAquisicoes;
    }

    public function setDataEnvioNE($dataEnvioNE) {
        $this->dataEnvioNE = $dataEnvioNE;
    }

    public function setValorNE($valorNE) {
        $this->valorNE = $valorNE;
    }

    public function setDataAprovacao($dataAprovacao) {
        $this->dataAprovacao = $dataAprovacao;
    }

    public function setObservacaoConformidade($observacaoConformidade) {
        $this->observacaoConformidade = $observacaoConformidade;
    }

    public function setParecer($parecer) {
        $this->parecer = $parecer;
    }

    public function setDataEntregaMaterial($dataEntregaMaterial) {
        $this->dataEntregaMaterial = $dataEntregaMaterial;
    }

    public function setNumeroDiex($numeroDiex) {
        $this->numeroDiex = $numeroDiex;
    }

    public function setProcessoAdministrativo($processoAdministrativo) {
        $this->processoAdministrativo = $processoAdministrativo;
    }

    public function setNumeroOficio($numeroOficio) {
        $this->numeroOficio = $numeroOficio;
    }

    public function setBoletim($boletim) {
        $this->boletim = $boletim;
    }

    public function setDataUltimaLiquidacao($dataUltimaLiquidacao) {
        $this->dataUltimaLiquidacao = $dataUltimaLiquidacao;
    }

    public function setValorLiquidar($valorLiquidar) {
        $this->valorLiquidar = $valorLiquidar;
    }

    public function setItemList($itemList) {
        $this->itemList = $itemList;
    }

    public function setDataRequisicaoFormatada($dataRequisicaoFormatada) {
        $this->dataRequisicaoFormatada = $dataRequisicaoFormatada;
    }

    public function setDataEnvioNEFormatada($dataEnvioNEFormatada) {
        $this->dataEnvioNEFormatada = $dataEnvioNEFormatada;
    }

    public function setDataNE($dataNE) {
        $this->dataNE = $dataNE;
    }

    public function setObservacaoAlmox($observacaoAlmox) {
        $this->observacaoAlmox = $observacaoAlmox;
    }

    public function setDataPrazoEntrega($dataPrazoEntrega) {
        $this->dataPrazoEntrega = $dataPrazoEntrega;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function getDataNEFormatada() {
        return $this->dataNEFormatada;
    }

    public function setDataNEFormatada($dataNEFormatada) {
        $this->dataNEFormatada = $dataNEFormatada;
    }

}
