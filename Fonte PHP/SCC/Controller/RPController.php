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
require_once '../include/global.php';
require_once '../include/comum.php';
require_once '../DAO/VisitanteDAO.php';
require_once '../DAO/SecaoDAO.php';
require_once '../DAO/FotoDAO.php';
require_once '../DAO/PessoaDAO.php';
require_once '../DAO/PostoDAO.php';

class RPController {

    private $visitanteInstance, // Model instance to be used by Controller and DAO
            $visitanteDAO, // DAO instance for database operations                        
            $foto;
    private $mes;
    private $importLog;
    private $datasheet;             // Datasheet import from SiCaPEx    
    private $filtro;                // Array of filters to be used by DAO object

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $dataHoje = date('Y-m-d');
        $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
        $inicio = !empty(filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataHoje;
        $fim = !empty(filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataAmanha;
        $this->filtro = array(
            "inicio" => $inicio,
            "fim" => $fim
        );
        $this->visitanteInstance = new Visitante();
        $this->visitanteInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->visitanteInstance->setNome(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setCpf(filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setDestino(filter_input(INPUT_POST, "destino", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setTelefone(filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setDataEntrada(filter_input(INPUT_POST, "dataEntrada", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setDataSaida(filter_input(INPUT_POST, "dataSaida", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setHoraEntrada(filter_input(INPUT_POST, "horaEntrada", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setHoraSaida(filter_input(INPUT_POST, "horaSaida", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setCracha(filter_input(INPUT_POST, "cracha", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->visitanteInstance->setTemporario(filter_input(INPUT_POST, "temporario", FILTER_VALIDATE_INT));
        $this->foto = isset($_FILES["arquivoFoto"]) ? $_FILES["arquivoFoto"] : "";
        $this->visitanteInstance->setFoto($this->visitanteInstance->getId() . ".jpg");
        $this->visitanteInstance->setArquivoFoto($this->foto);
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
        $this->datasheet = isset($_FILES["planilhaPessoas"]) ? $_FILES["planilhaPessoas"] : "";
        $this->mes = !empty(filter_input(INPUT_GET, "mes", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES)) ? filter_input(INPUT_GET, "mes", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES) : "";
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters            
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            $pessoaDAO = new PessoaDAO();
            $postoDAO = new PostoDAO();
            $importLog = $this->importLog;
            $objectList = $this->visitanteDAO->getAllList($this->filtro);
            require_once '../View/view_RP_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function aniversariantesList($importLog = "") {
        try {
            $this->getFormData(); // Used to get filters            
            $pessoaDAO = new PessoaDAO();
            $postoDAO = new PostoDAO();
            $mes = $this->mes;
            $mes = empty($mes) ? date('m') : format($mes);
            $mesAnterior = anterior($mes);
            $mesPosterior = posterior($mes);
            $hoje = new DateTime();
            $pessoaList = $pessoaDAO->getByMesList($mes);
            require_once '../View/view_RP_aniversariantes_iframe.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function visitanteInsert() {
        try {
            $this->getFormData();
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            if ($this->visitanteInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->visitanteDAO->insert($this->visitanteInstance)) {
                    $secaoDAO->updateDataAtualizacao("RP");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->visitanteInstance;
                require_once '../View/view_RP_visitante_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function visitanteUpdate() {
        try {
            $this->getFormData();
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            if ($this->visitanteInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->visitanteDAO->update($this->visitanteInstance)) {
                    $secaoDAO->updateDataAtualizacao("RP");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!<br>O tamanho do arquivo deve ser de no máximo 40 KB e a extensão deve ser .jpg ou .png.");
                }
            } else { // Require the view of the form   
                $this->visitanteInstance = $this->visitanteInstance->getId() > 0 ? $this->visitanteDAO->getById($this->visitanteInstance->getId()) : null;
                $object = $this->visitanteInstance;
                require_once '../View/view_RP_visitante_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function visitanteDelete() {
        try {
            $this->getFormData();
            $this->visitanteDAO = new VisitanteDAO();
            $secaoDAO = new SecaoDAO();
            $fotoDAO = new FotoDAO();
            if ($this->visitanteInstance->getId() != null) {
                if ($this->visitanteDAO->delete($this->visitanteInstance)) {
                    $secaoDAO->updateDataAtualizacao("RP");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database
     */
    public function mensagemUpdate() {
        try {
            $this->getFormData();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->mensagem)) {
                $secaoDAO->updateDataAtualizacao("RP", $this->mensagem);
            }
            header("Location: RPController.php?action=getAllList");
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function import() {
        try {
            $this->importLog = $this->importDataSheet();
            $this->getAllList();
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Import SiCaPEx datasheet to database
     */
    function importDataSheet() {
        $this->getFormData();
        $result = "";
        $planilha = $this->datasheet;
        $pessoaDAO = new PessoaDAO();
        $postoDAO = new PostoDAO();
        $secaoDAO = new SecaoDAO();
        $secaoDAO->updateDataAtualizacao("RP");
        $row = 1;
        if (($handle = fopen($planilha['tmp_name'], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($row <= 2) {
                    $row++;
                    continue;
                } else if ($row === 3) {
                    $ordCol = isset($data[0]) ? $data[0] : null;
                    $identidadeCol = isset($data[1]) ? $data[1] : null;
                    $pgradCol = isset($data[2]) ? $data[2] : null;
                    $nomeCol = isset($data[3]) ? $data[3] : null;
                    $nomeGuerraCol = isset($data[4]) ? $data[4] : null;
                    $dataNascimentoCol = isset($data[5]) ? $data[5] : null;
                    $cpfCol = isset($data[6]) ? $data[6] : null;
                    $preccpCol = isset($data[7]) ? $data[7] : null;
                    if (
                            $ordCol === "ORD" &&
                            $identidadeCol === "IDENTIDADE" &&
                            $pgradCol === "PGRAD" &&
                            $nomeCol === "NOME" &&
                            $nomeGuerraCol === "NOME_GUERRA" &&
                            $cpfCol === "CPF" &&
                            $preccpCol === "PREC_CP" &&
                            $dataNascimentoCol === "DT_NASCIMENTO"
                    ) {
                        $row++;
                        $pessoaDAO->expireAll(); // Caso as colunas estejam corretas, expira todos registros do banco para novos cadastros atualizados
                        continue;
                    } else {
                        $result .= '<div class="alert alert-danger">
                <b>Atenção! </b> O arquivo deve seguir o seguinte padrão conforme imagens abaixo:    
            </div>
            <div class="form-row">
                <div class="col">
                    <div class="alert alert-primary">Ao abrir em uma suíte Office</div>            
                    <img src="../include/imagens/exemplo.png" width="500">
                </div>
                <div class="col">
                    <div class="alert alert-primary">Ao abrir em um bloco de notas</div>            
                    <img src="../include/imagens/exemplo2.png" width="500">
                </div>
            </div>'
                                . "<span style='color: red;font-weight: bold;'>Erro ao importar os dados.</span>";
                        break;
                    }
                }
                $num = count($data);
                $row++;
                $identidade = $data[1];
                if (strlen($identidade) === 9) {
                    $identidade = "0" . $data[1];
                }
                $identidade = substr_replace($identidade, "-", 9, 0);
                $result .= $identidade . " ";
                $pessoa = $pessoaDAO->getByIdentidadeMilitar($identidade);
                if (!is_null($pessoa)) { // Já existe no sistema                    
                    $pessoa->setDataExpiracao(date('Y') + 1 . "-03-01"); // Renovar data de expiração para 1 ano a frente
                    $idPosto = 1;
                    $posto = $postoDAO->getByPosto($data[2]); // Tenta identificar o posto do militar pelo nome do posto
                    if (!is_null($posto)) {
                        $idPosto = $posto->getId();
                    } else {
                        $idPosto = $data[2] === "Ten Cel" ? 13 : 1; // Verifica se é o posto de Ten Cel, se não for, assume que é um recruta (Sd Recr), pois até a presente data, esses são os únicos postos divergentes dos cadastros desse sistema
                    }
                    $pessoa->setIdPosto($idPosto);
                    $dataNascimento = explode("/", $data[5]); // Atualiza a data de nascimento, pois nas versões antigas desse sistema, esse campo estará vazio
                    $dataNascimentoFormatted = $dataNascimento[2] . "-" . $dataNascimento[1] . "-" . $dataNascimento[0];
                    $pessoa->setDataNascimento($dataNascimentoFormatted);
                    $pessoaDAO->update($pessoa);
                    $result .= $pessoa->getNome();
                    $result .= " <b><span style='color: darkgreen';'>Encontrado</span> - atualizando cadastro no BD - </b>";
                } else {
                    $result .= "<b><span style='color: red';'>Não encontrado</span> - preparando novo cadastro no BD - </b>";
                    $idPosto = 1;
                    $posto = $postoDAO->getByPosto($data[2]);
                    $expiracao = (date('Y') + 1) . '-03-01';
                    if (!is_null($posto)) {
                        $idPosto = $posto->getId();
                    } else {
                        $idPosto = $data[2] === "Ten Cel" ? 13 : 1;
                    }
                    $pessoa = new Pessoa();
                    $pessoa->setCpf($data[6]);
                    $pessoa->setDataExpiracao($expiracao);
                    //$pessoa->setFoto("S2-Pessoa-365.jpg");
                    $pessoa->setIdPosto($idPosto);
                    $pessoa->setIdVinculo(1); // ATIVA
                    $pessoa->setIdentidadeMilitar($identidade);
                    $pessoa->setNome($data[3]);
                    $pessoa->setNomeGuerra($data[4]);
                    $pessoa->setPreccp($data[7]);
                    $dataNascimento = explode("/", $data[5]);
                    $dataNascimentoFormatted = $dataNascimento[2] . "-" . $dataNascimento[1] . "-" . $dataNascimento[0];
                    $pessoa->setDataNascimento($dataNascimentoFormatted);
                    $result .= $pessoaDAO->insert($pessoa) ? "<span style='color: darkgreen; font-weight: bold;'>Cadastro efetuado com sucesso!</span>" : "<span style='color: red; font-weight: bold;'>Erro ao efetuar o cadastro!</span>";
                }
                $result .= "<br>";
            }
            fclose($handle);
        }
        return $result;
    }
}

// POSSIBLE ACTIONS
$action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "";
$controller = new RPController();
switch ($action) {
    case "getAllList":
        !isAdminLevel($LISTAR_RP) ? redirectToLogin() : $controller->getAllList();
        break;
    case "visitante_insert":
        !isAdminLevel($ADICIONAR_RP) ? redirectToLogin() : $controller->visitanteInsert();
        break;
    case "visitante_update":
        !isAdminLevel($EDITAR_RP) ? redirectToLogin() : $controller->visitanteUpdate();
        break;
    case "visitante_delete":
        !isAdminLevel($EXCLUIR_RP) ? redirectToLogin() : $controller->visitanteDelete();
        break;
    case "mensagem_update":
        !isAdminLevel($EDITAR_RP) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    case "import":
        !isAdminLevel($EDITAR_RP) ? redirectToLogin() : $controller->import();
        break;
    case "aniversariantes":
        $controller->aniversariantesList();
        break;
    default:
        !isAdminLevel($LISTAR_RP) ? redirectToLogin() : $controller->getAllList();
        break;
}
?>