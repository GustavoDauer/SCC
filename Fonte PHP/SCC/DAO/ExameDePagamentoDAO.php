<?php

/* * *****************************************************************************
 * 
 * Copyright © 2025 Gustavo Henrique Mello Dauer - 1º Ten 
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
require_once '../include/comum.php';
require_once '../Model/ExameDePagamento.php';

class ExameDePagamentoDAO {

    private function validarTabela($tabela) {
        // Lista branca (whitelist) com nomes válidos de tabelas
        $tabelasValidas = ['CPEX', 'Efetivo'];
        if (!in_array($tabela, $tabelasValidas)) {
            throw new Exception("Nome de tabela inválido");
        }
        return "ExamePagamento" . $tabela;
    }

    public function getAllList($table) {
        try {
            $c = connect();
            $tabela = $this->validarTabela($table);
            $sql = "SELECT nome FROM $tabela";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $lista[] = $row["nome"];
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllListNotIn($table, $notInTable) {
        try {
            $c = connect();
            $tabela1 = $this->validarTabela($table);
            $tabela2 = $this->validarTabela($notInTable);
            $sql = "SELECT nome FROM $tabela1 WHERE nome NOT IN (
                        SELECT nome FROM $tabela2
                    )";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $lista[] = $row["nome"];
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function insert($nome, $table) {
        try {
            $c = connect();
            $tabela = $this->validarTabela($table);
            $sql = "INSERT INTO $tabela (nome) VALUES (?)";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("s", $nome);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function reset() {
        try {
            $c = connect();
            $stmt = $c->prepare("DELETE FROM ExamePagamentoCPEX;");
            $sqlOk = $stmt ? $stmt->execute() : false;
            if (!$sqlOk) {
                $c->close();
                return false;
            }
            $stmt = $c->prepare("DELETE FROM ExamePagamentoEfetivo;");
            $sqlOk = $stmt ? $stmt->execute() : false;
            $stmt->close();
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }
}
