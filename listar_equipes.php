<?php
/**
 * ==========================================================
 * LISTAGEM DE EQUIPES (listar_equipes.php)
 * Exibe todas as equipes cadastradas no sistema.
 * ==========================================================
 */

// 1. Inclui o arquivo de conexão com o MySQL
require_once 'conexao.php';

try {
    // 2. Consulta as equipes e conta quantos membros estão em cada uma
    $sql = "SELECT e.equipe_id, e.nome, e.atualizado_em, COUNT(m.membros_id) AS total_membros
            FROM tbEquipe e
            LEFT JOIN tbMembros m ON e.equipe_id = m.equipe_id
            GROUP BY e.equipe_id
            ORDER BY e.nome ASC";

    $stmt = $pdo->query($sql);
    $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    die("Erro ao buscar equipes: " . $erro->getMessage());
}

require_once 'header.php';
?>

<div class="card">
    <div class="card-titulo">
        <span>💼 Equipes de Trabalho</span>
        <a href="cadastro_equipe.php" class="btn btn-verde">+ Nova Equipe</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'excluido'): ?>
        <div class="alerta alerta-sucesso">✅ Equipe excluída com sucesso!</div>
    <?php endif; ?>

    <?php if (count($equipes) > 0): ?>
        <div class="tabela-container">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Equipe</th>
                        <th>Total de Membros</th>
                        <th>Data de Registro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipes as $eq): ?>
                        <tr>
                            <td><?php echo $eq['equipe_id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($eq['nome']); ?></strong></td>
                            <td><span class="badge badge-ativo"><?php echo $eq['total_membros']; ?> membro(s)</span></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($eq['atualizado_em'])); ?></td>
                            <td>
                                <a href="ver_equipe.php?id=<?php echo $eq['equipe_id']; ?>" class="btn btn-sm btn-ciano">Ver Time</a>
                                <a href="excluir_equipe.php?id=<?php echo $eq['equipe_id']; ?>" 
                                   class="btn btn-sm btn-vermelho"
                                   onclick="return confirm('Tem certeza que deseja excluir esta equipe? Os vínculos também serão removidos.');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p style="color: #666; padding: 20px 0;">Nenhuma equipe cadastrada no sistema.</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>