<?php
/**
 * ==========================================================
 * EXCLUSÃO DE PESSOA (excluir_pessoa.php)
 * Recebe o ID via GET e remove do banco de dados.
 * ==========================================================
 */

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tbPessoas WHERE pessoa_id = ?");
        $stmt->execute([$id]);

        header('Location: listar_pessoas.php?msg=excluido');
        exit;
    } catch (PDOException $erro) {
        die("Erro ao excluir pessoa: " . $erro->getMessage());
    }
} else {
    header('Location: listar_pessoas.php');
    exit;
}
?>