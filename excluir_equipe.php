<?php
/**
 * ==========================================================
 * EXCLUSÃO DE EQUIPE (excluir_equipe.php)
 * ==========================================================
 */

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tbEquipe WHERE equipe_id = ?");
        $stmt->execute([$id]);

        header('Location: listar_equipes.php?msg=excluido');
        exit;
    } catch (PDOException $erro) {
        die("Erro ao excluir equipe: " . $erro->getMessage());
    }
} else {
    header('Location: listar_equipes.php');
    exit;
}
?>