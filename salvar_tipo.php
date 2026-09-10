<?php
/**
 * ==========================================================
 * PROCESSA O CADASTRO DE PAPEL (salvar_tipo.php)
 * ==========================================================
 */

require_once 'conexao.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = trim($_POST['descricao']);

    try {
        $sql = $pdo->prepare("INSERT INTO tbPessoaTipo (descricao) VALUES (?)");
        $sql->execute([$descricao]);

        echo "<div class='card formulario-box'>
                <div class='alerta alerta-sucesso'>
                    <h3>✅ Papel Cadastrado com Sucesso!</h3>
                    <p>O papel <strong>" . htmlspecialchars($descricao) . "</strong> já pode ser selecionado nos cadastros de pessoas.</p>
                </div>
                <div style='display:flex; gap:10px;'>
                    <a href='cadastro_tipo.php' class='btn btn-cinza'>+ Cadastrar Outro</a>
                    <a href='listar_tipos.php' class='btn btn-azul'>Ver Lista de Papéis</a>
                </div>
              </div>";

    } catch (PDOException $erro) {
        echo "<div class='card formulario-box'>
                <div class='alerta alerta-erro'>
                    <h3>❌ Erro ao cadastrar papel:</h3>
                    <p>" . $erro->getMessage() . "</p>
                </div>
                <a href='cadastro_tipo.php' class='btn btn-cinza'>Tentar Novamente</a>
              </div>";
    }
} else {
    header('Location: listar_tipos.php');
    exit;
}

require_once 'footer.php';
?>