<?php
/**
 * ==========================================================
 * PROCESSA O CADASTRO DE EQUIPE (salvar_equipe.php)
 * ==========================================================
 */

require_once 'conexao.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_equipe = trim($_POST['nome']);
    $atualizado_por = 1;

    if (empty($nome_equipe) || strlen($nome_equipe) < 3) {
        echo "<div class='card formulario-box'>
                <div class='alerta alerta-erro'>
                    <h3>❌ Nome Inválido!</h3>
                    <p>O nome da equipe precisa ter pelo menos 3 caracteres.</p>
                </div>
                <a href='cadastro_equipe.php' class='btn btn-cinza'>Voltar e Corrigir</a>
              </div>";
    } else {
        try {
            $sql = $pdo->prepare("INSERT INTO tbEquipe (nome, atualizado_por) VALUES (?, ?)");
            $sql->execute([$nome_equipe, $atualizado_por]);

            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-sucesso'>
                        <h3>✅ Equipe Criada com Sucesso!</h3>
                        <p>A equipe <strong>" . htmlspecialchars($nome_equipe) . "</strong> já está ativa no sistema.</p>
                    </div>
                    <div style='display:flex; gap:10px;'>
                        <a href='cadastro_equipe.php' class='btn btn-verde'>+ Criar Outra</a>
                        <a href='listar_equipes.php' class='btn btn-cinza'>Ver Lista de Equipes</a>
                        <a href='index.php' class='btn btn-cinza'>Início</a>
                    </div>
                  </div>";

        } catch (PDOException $erro) {
            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-erro'>
                        <h3>❌ Erro ao criar equipe:</h3>
                        <p>Já existe uma equipe com este nome ou ocorreu uma falha no banco.</p>
                    </div>
                    <a href='cadastro_equipe.php' class='btn btn-cinza'>Tentar Novamente</a>
                  </div>";
        }
    }
} else {
    header('Location: listar_equipes.php');
    exit;
}

require_once 'footer.php';
?>