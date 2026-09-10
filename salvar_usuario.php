<?php
/**
 * ==========================================================
 * PROCESSA O CADASTRO DE USUÁRIO (salvar_usuario.php)
 * ==========================================================
 */

require_once 'conexao.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $login = trim($_POST['login']);
    $senha = $_POST['senha'];
    $atualizado_por = 1;

    if (empty($nome) || empty($login) || empty($senha) || strlen($login) < 3) {
        echo "<div class='card formulario-box'>
                <div class='alerta alerta-erro'>
                    <h3>❌ Dados Inválidos!</h3>
                    <p>Preencha todos os campos. O login precisa ter no mínimo 3 caracteres.</p>
                </div>
                <a href='cadastro_usuario.php' class='btn btn-cinza'>Voltar e Corrigir</a>
              </div>";
    } else {
        try {
            $sql = $pdo->prepare("INSERT INTO tbUsuarios (nome, login, senha, atualizado_por) VALUES (?, ?, ?, ?)");
            $sql->execute([$nome, $login, $senha, $atualizado_por]);

            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-sucesso'>
                        <h3>✅ Usuário Cadastrado com Sucesso!</h3>
                        <p>O usuário <strong>" . htmlspecialchars($nome) . "</strong> (" . htmlspecialchars($login) . ") já pode acessar o sistema.</p>
                    </div>
                    <div style='display:flex; gap:10px;'>
                        <a href='cadastro_usuario.php' class='btn btn-azul'>+ Criar Outro</a>
                        <a href='listar_usuarios.php' class='btn btn-cinza'>Ver Lista de Usuários</a>
                        <a href='index.php' class='btn btn-cinza'>Início</a>
                    </div>
                  </div>";

        } catch (PDOException $erro) {
            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-erro'>
                        <h3>❌ Erro ao cadastrar usuário:</h3>
                        <p>Este login já está em uso ou ocorreu uma falha no banco de dados.</p>
                    </div>
                    <a href='cadastro_usuario.php' class='btn btn-cinza'>Tentar Novamente</a>
                  </div>";
        }
    }
} else {
    header('Location: listar_usuarios.php');
    exit;
}

require_once 'footer.php';
?>