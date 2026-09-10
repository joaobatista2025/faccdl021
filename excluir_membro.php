<?php
/**
 * ==========================================================
 * EXCLUSÃO DE VÍNCULO DE MEMBRO (excluir_membro.php)
 * ==========================================================
 */

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tbMembros WHERE membros_id = ?");
        $stmt->execute([$id]);

        header('Location: listar_membros.php?msg=excluido');
        exit;
    } catch (PDOException $erro) {
        die("Erro ao excluir vínculo: " . $erro->getMessage());
    }
} else {
    header('Location: listar_membros.php');
    exit;
}
?>