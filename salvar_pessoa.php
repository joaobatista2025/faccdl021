<?php
/**
 * ==========================================================
 * PROCESSA O CADASTRO DE PESSOA (salvar_pessoa.php)
 * ==========================================================
 */

require_once 'conexao.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome           = trim($_POST['nome']);
    $cpf            = trim($_POST['cpf']);
    $nascimento     = $_POST['nascimento'];
    $telefone       = trim($_POST['telefone']);
    $pessoa_tipo_id = (int)$_POST['pessoa_tipo_id'];
    $atualizado_por = 1;
    $atualizado_em  = date('Y-m-d');

    // Validação de Regra de Negócio: data de nascimento no futuro
    if ($nascimento > date('Y-m-d')) {
        echo "<div class='card formulario-box'>
                <div class='alerta alerta-erro'>
                    <h3>❌ Data Inválida!</h3>
                    <p>A data de nascimento não pode ser no futuro.</p>
                </div>
                <a href='cadastro_pessoa.php' class='btn btn-cinza'>Voltar e Corrigir</a>
              </div>";
    } elseif (empty($nome) || empty($cpf) || empty($pessoa_tipo_id)) {
        echo "<div class='card formulario-box'>
                <div class='alerta alerta-erro'>
                    <h3>❌ Campos Obrigatórios!</h3>
                    <p>Por favor, preencha todos os campos do formulário.</p>
                </div>
                <a href='cadastro_pessoa.php' class='btn btn-cinza'>Voltar e Corrigir</a>
              </div>";
    } else {
        try {
            $sql = $pdo->prepare("INSERT INTO tbPessoas (nome, cpf, nascimento, telefone, pessoa_tipo_id, atualizado_por, atualizado_em) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sql->execute([$nome, $cpf, $nascimento, $telefone, $pessoa_tipo_id, $atualizado_por, $atualizado_em]);

            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-sucesso'>
                        <h3>✅ Sucesso!</h3>
                        <p>A pessoa <strong>" . htmlspecialchars($nome) . "</strong> foi cadastrada com sucesso.</p>
                    </div>
                    <div style='display:flex; gap:10px;'>
                        <a href='cadastro_pessoa.php' class='btn btn-laranja'>+ Cadastrar Outra</a>
                        <a href='listar_pessoas.php' class='btn btn-cinza'>Ver Lista de Pessoas</a>
                        <a href='index.php' class='btn btn-cinza'>Início</a>
                    </div>
                  </div>";

        } catch (PDOException $erro) {
            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-erro'>
                        <h3>❌ Erro ao cadastrar!</h3>
                        <p>" . $erro->getMessage() . "</p>
                    </div>
                    <a href='cadastro_pessoa.php' class='btn btn-cinza'>Tentar Novamente</a>
                  </div>";
        }
    }
} else {
    header('Location: listar_pessoas.php');
    exit;
}

require_once 'footer.php';
?>