<?php
/**
 * ==========================================================
 * PROCESSA A ATUALIZAÇÃO DA PESSOA (salvar_pessoa_edicao.php)
 * Executa o UPDATE no MySQL com PDO.
 * ==========================================================
 */

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pessoa_id      = (int)$_POST['pessoa_id'];
    $nome           = trim($_POST['nome']);
    $cpf            = trim($_POST['cpf']);
    $nascimento     = $_POST['nascimento'];
    $telefone       = trim($_POST['telefone']);
    $pessoa_tipo_id = (int)$_POST['pessoa_tipo_id'];
    $atualizado_por = 1;
    $atualizado_em  = date('Y-m-d');

    try {
        $sql = "UPDATE tbPessoas 
                SET nome = ?, cpf = ?, nascimento = ?, telefone = ?, pessoa_tipo_id = ?, atualizado_por = ?, atualizado_em = ?
                WHERE pessoa_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $cpf, $nascimento, $telefone, $pessoa_tipo_id, $atualizado_por, $atualizado_em, $pessoa_id]);

        header('Location: listar_pessoas.php?msg=editado');
        exit;

    } catch (PDOException $erro) {
        die("Erro ao atualizar pessoa: " . $erro->getMessage());
    }
} else {
    header('Location: listar_pessoas.php');
    exit;
}
?>