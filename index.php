<?php
/**
 * ==========================================================
 * PÁGINA INICIAL / DASHBOARD (index.php)
 * Exibe os indicadores gerais de pessoas, equipes e alocação.
 * ==========================================================
 */

// 1. Inclui o arquivo de conexão com o MySQL
require_once 'conexao.php';

try {
    // 2. Consulta contadores gerais para os cartões de estatísticas
    $totalPessoas = $pdo->query("SELECT COUNT(*) FROM tbPessoas")->fetchColumn();
    $totalEquipes = $pdo->query("SELECT COUNT(*) FROM tbEquipe")->fetchColumn();
    $totalUsuarios = $pdo->query("SELECT COUNT(*) FROM tbUsuarios")->fetchColumn();

    // 3. Pessoas que estão em pelo menos uma equipe
    $pessoasAlocadas = $pdo->query("SELECT COUNT(DISTINCT membro_id) FROM tbMembros")->fetchColumn();
    $pessoasLivres = $totalPessoas - $pessoasAlocadas;
    if ($pessoasLivres < 0) { $pessoasLivres = 0; }

    // 4. Consulta a lista das equipes com a lista de membros de cada uma usando GROUP_CONCAT
    $sqlEquipes = "SELECT e.equipe_id, e.nome AS equipe_nome,
                          COUNT(m.membros_id) AS total_membros,
                          GROUP_CONCAT(p.nome ORDER BY p.nome SEPARATOR ', ') AS nomes_membros
                   FROM tbEquipe e
                   LEFT JOIN tbMembros m ON e.equipe_id = m.equipe_id
                   LEFT JOIN tbPessoas p ON m.membro_id = p.pessoa_id
                   GROUP BY e.equipe_id
                   ORDER BY e.nome ASC";
    $listaEquipes = $pdo->query($sqlEquipes)->fetchAll();

} catch (PDOException $erro) {
    die("Erro ao carregar o painel: " . $erro->getMessage());
}

// 5. Inclui o cabeçalho padrão
require_once 'header.php';
?>

<!-- Cartões de Indicadores Numéricos -->
<div class="dashboard-grid">
    <div class="stat-card laranja">
        <h3>Pessoas Cadastradas</h3>
        <div class="numero"><?php echo $totalPessoas; ?></div>
    </div>
    <div class="stat-card verde">
        <h3>Equipes Ativas</h3>
        <div class="numero"><?php echo $totalEquipes; ?></div>
    </div>
    <div class="stat-card roxo">
        <h3>Pessoas em Equipes</h3>
        <div class="numero"><?php echo $pessoasAlocadas; ?></div>
    </div>
    <div class="stat-card cinza">
        <h3>Pessoas Disponíveis</h3>
        <div class="numero"><?php echo $pessoasLivres; ?></div>
    </div>
    <div class="stat-card azul">
        <h3>Usuários do Sistema</h3>
        <div class="numero"><?php echo $totalUsuarios; ?></div>
    </div>
</div>

<!-- Painel de Ações Rápidas de Cadastro -->
<div class="card">
    <div class="card-titulo">
        <span>⚡ Ações Rápidas de Cadastro</span>
    </div>
    <p style="color: #666; margin-bottom: 15px;">Clique para cadastrar ou vincular rapidamente:</p>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="cadastro_pessoa.php" class="btn btn-laranja">+ Cadastrar Pessoa</a>
        <a href="cadastro_equipe.php" class="btn btn-verde">+ Nova Equipe</a>
        <a href="cadastro_membro.php" class="btn btn-roxo">+ Vincular Membro à Equipe</a>
        <a href="cadastro_tipo.php" class="btn btn-cinza">+ Novo Papel / Função</a>
        <a href="cadastro_usuario.php" class="btn btn-azul">+ Novo Usuário</a>
    </div>
</div>

<!-- Tabela de Visão Geral das Equipes -->
<div class="card">
    <div class="card-titulo">
        <span>💼 Visão Geral das Equipes e Integrantes</span>
        <a href="listar_equipes.php" class="btn btn-sm btn-verde">Ver Todas as Equipes</a>
    </div>

    <?php if (count($listaEquipes) > 0): ?>
        <div class="tabela-container">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>Equipe</th>
                        <th>Total de Membros</th>
                        <th>Integrantes Alocados</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaEquipes as $eq): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($eq['equipe_nome']); ?></strong></td>
                            <td>
                                <span class="badge badge-ativo"><?php echo $eq['total_membros']; ?> membro(s)</span>
                            </td>
                            <td>
                                <?php if (!empty($eq['nomes_membros'])): ?>
                                    <span style="color: #2b6cb0; font-size: 13px;"><?php echo htmlspecialchars($eq['nomes_membros']); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-disponivel">Nenhum membro alocado ainda</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="ver_equipe.php?id=<?php echo $eq['equipe_id']; ?>" class="btn btn-sm btn-ciano">Ver Time</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p style="color: #777; padding: 15px 0;">Nenhuma equipe cadastrada ainda. Clique no botão acima para criar a primeira!</p>
    <?php endif; ?>
</div>

<?php
// Inclui o rodapé padrão
require_once 'footer.php';
?>
