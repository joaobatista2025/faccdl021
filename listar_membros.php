<?php
/**
 * ==========================================================
 * LISTAGEM DE MEMBROS VINCULADOS (listar_membros.php)
 * Realiza JOIN entre tbMembros, tbEquipe, tbPessoas e tbPessoaTipo.
 * ==========================================================
 */

require_once 'conexao.php';

$filtroEquipe = isset($_GET['equipe_id']) ? (int)$_GET['equipe_id'] : 0;

try {
    // 1. Busca todas as equipes para o filtro suspenso
    $todasEquipes = $pdo->query("SELECT equipe_id, nome FROM tbEquipe ORDER BY nome ASC")->fetchAll();

    // 2. Consulta os membros
    if ($filtroEquipe > 0) {
        $sql = "SELECT m.membros_id, m.atualizado_em, e.nome AS equipe_nome, p.nome AS pessoa_nome, p.telefone, t.descricao AS papel
                FROM tbMembros m
                JOIN tbEquipe e ON m.equipe_id = e.equipe_id
                JOIN tbPessoas p ON m.membro_id = p.pessoa_id
                LEFT JOIN tbPessoaTipo t ON p.pessoa_tipo_id = t.pessoa_tipo_id
                WHERE m.equipe_id = ?
                ORDER BY p.nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$filtroEquipe]);
        $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sql = "SELECT m.membros_id, m.atualizado_em, e.nome AS equipe_nome, p.nome AS pessoa_nome, p.telefone, t.descricao AS papel
                FROM tbMembros m
                JOIN tbEquipe e ON m.equipe_id = e.equipe_id
                JOIN tbPessoas p ON m.membro_id = p.pessoa_id
                LEFT JOIN tbPessoaTipo t ON p.pessoa_tipo_id = t.pessoa_tipo_id
                ORDER BY e.nome ASC, p.nome ASC";
        $membros = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $erro) {
    die("Erro ao buscar vínculos: " . $erro->getMessage());
}

require_once 'header.php';
?>

<div class="card">
    <div class="card-titulo">
        <span>🔗 Membros Associados às Equipes</span>
        <a href="cadastro_membro.php" class="btn btn-roxo">+ Vincular Novo Membro</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'excluido'): ?>
        <div class="alerta alerta-sucesso">✅ Vínculo removido com sucesso!</div>
    <?php endif; ?>

    <!-- Filtro por Equipe -->
    <form action="listar_membros.php" method="GET" class="filtro-container">
        <select name="equipe_id" onchange="this.form.submit()">
            <option value="">-- Filtrar por Equipe (Mostrar Todas) --</option>
            <?php foreach ($todasEquipes as $eq): ?>
                <option value="<?php echo $eq['equipe_id']; ?>" <?php if ($filtroEquipe == $eq['equipe_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($eq['nome']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if ($filtroEquipe > 0): ?>
            <a href="listar_membros.php" class="btn btn-cinza">Limpar Filtro</a>
        <?php endif; ?>
    </form>

    <?php if (count($membros) > 0): ?>
        <div class="tabela-container">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>ID Vínculo</th>
                        <th>Equipe</th>
                        <th>Nome do Membro</th>
                        <th>Papel / Função</th>
                        <th>Telefone</th>
                        <th>Data de Vinculação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membros as $m): ?>
                        <tr>
                            <td><?php echo $m['membros_id']; ?></td>
                            <td><strong style="color: #2b6cb0;"><?php echo htmlspecialchars($m['equipe_nome']); ?></strong></td>
                            <td><?php echo htmlspecialchars($m['pessoa_nome']); ?></td>
                            <td><span class="badge badge-papel"><?php echo htmlspecialchars($m['papel']); ?></span></td>
                            <td><?php echo htmlspecialchars($m['telefone']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($m['atualizado_em'])); ?></td>
                            <td>
                                <a href="excluir_membro.php?id=<?php echo $m['membros_id']; ?>" 
                                   class="btn btn-sm btn-vermelho"
                                   onclick="return confirm('Tem certeza que deseja desvincular este membro da equipe?');">Remover</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p style="color: #666; padding: 20px 0;">Nenhum membro vinculado encontrado para os critérios selecionados.</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>