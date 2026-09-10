<?php
/**
 * ==========================================================
 * VISÃO DETALHADA DA EQUIPE (ver_equipe.php)
 * Exibe os integrantes que fazem parte da equipe selecionada.
 * ==========================================================
 */

require_once 'conexao.php';

$equipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($equipe_id <= 0) {
    header('Location: listar_equipes.php');
    exit;
}

try {
    // 1. Busca os dados da equipe
    $stmtEquipe = $pdo->prepare("SELECT * FROM tbEquipe WHERE equipe_id = ?");
    $stmtEquipe->execute([$equipe_id]);
    $equipe = $stmtEquipe->fetch(PDO::FETCH_ASSOC);

    if (!$equipe) {
        die("Equipe não encontrada!");
    }

    // 2. Busca os membros vinculados a essa equipe
    $sqlMembros = "SELECT m.membros_id, p.pessoa_id, p.nome, p.telefone, p.cpf, t.descricao AS papel
                   FROM tbMembros m
                   JOIN tbPessoas p ON m.membro_id = p.pessoa_id
                   LEFT JOIN tbPessoaTipo t ON p.pessoa_tipo_id = t.pessoa_tipo_id
                   WHERE m.equipe_id = ?
                   ORDER BY p.nome ASC";
    $stmtMembros = $pdo->prepare($sqlMembros);
    $stmtMembros->execute([$equipe_id]);
    $membros = $stmtMembros->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    die("Erro ao carregar detalhes da equipe: " . $erro->getMessage());
}

require_once 'header.php';
?>

<div class="card">
    <div class="card-titulo">
        <span>💼 Quadro da Equipe: <strong><?php echo htmlspecialchars($equipe['nome']); ?></strong></span>
        <div>
            <a href="cadastro_membro.php" class="btn btn-sm btn-roxo">+ Adicionar Integrante</a>
            <a href="listar_equipes.php" class="btn btn-sm btn-cinza">Voltar para Equipes</a>
        </div>
    </div>

    <p style="color: #666; margin-bottom: 20px;">
        Esta equipe conta atualmente com <strong><?php echo count($membros); ?> integrante(s)</strong>.
    </p>

    <?php if (count($membros) > 0): ?>
        <div class="tabela-container">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>Nome do Membro</th>
                        <th>Papel / Cargo</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membros as $m): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($m['nome']); ?></strong></td>
                            <td><span class="badge badge-papel"><?php echo htmlspecialchars($m['papel']); ?></span></td>
                            <td><?php echo htmlspecialchars($m['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($m['cpf']); ?></td>
                            <td>
                                <a href="excluir_membro.php?id=<?php echo $m['membros_id']; ?>" 
                                   class="btn btn-sm btn-vermelho"
                                   onclick="return confirm('Deseja desvincular este membro da equipe?');">Remover da Equipe</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alerta alerta-info">
            Nenhum membro vinculado a esta equipe ainda. Clique no botão roxo acima para adicionar participantes!
        </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
