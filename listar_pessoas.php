<?php
/**
 * ==========================================================
 * LISTAGEM DE PESSOAS COM CARGO E EQUIPE ATUAL (listar_pessoas.php)
 * Mostra todas as pessoas, seu papel no sistema e em qual
 * equipe ela está trabalhando no momento.
 * ==========================================================
 */

// 1. Conexão com o banco de dados
require_once 'conexao.php';

// 2. Filtro de busca (caso o usuário tenha digitado algo na busca)
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

try {
    // 3. Monta o comando SQL com GROUP_CONCAT para juntar os nomes das equipes em que a pessoa atua
    $sql = "SELECT p.pessoa_id, p.nome, p.cpf, p.nascimento, p.telefone, 
                   t.descricao AS papel_nome,
                   GROUP_CONCAT(e.nome ORDER BY e.nome SEPARATOR ', ') AS equipes_alocadas
            FROM tbPessoas p
            LEFT JOIN tbPessoaTipo t ON p.pessoa_tipo_id = t.pessoa_tipo_id
            LEFT JOIN tbMembros m ON p.pessoa_id = m.membro_id
            LEFT JOIN tbEquipe e ON m.equipe_id = e.equipe_id";

    // Se houver busca, filtra pelo nome da pessoa ou papel
    if (!empty($busca)) {
        $sql .= " WHERE p.nome LIKE ? OR t.descricao LIKE ? OR p.cpf LIKE ?";
        $sql .= " GROUP BY p.pessoa_id ORDER BY p.nome ASC";
        $stmt = $pdo->prepare($sql);
        $termo = "%$busca%";
        $stmt->execute([$termo, $termo, $termo]);
    } else {
        $sql .= " GROUP BY p.pessoa_id ORDER BY p.nome ASC";
        $stmt = $pdo->query($sql);
    }

    $pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    die("Erro ao carregar lista de pessoas: " . $erro->getMessage());
}

// 4. Inclui o cabeçalho padrão
require_once 'header.php';
?>

<div class="card">
    <div class="card-titulo">
        <span>👤 Lista Geral de Pessoas, Cargos e Equipes</span>
        <a href="cadastro_pessoa.php" class="btn btn-laranja">+ Cadastrar Nova Pessoa</a>
    </div>

    <!-- Mensagens de Alerta -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'excluido'): ?>
        <div class="alerta alerta-sucesso">✅ Pessoa excluída com sucesso!</div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'editado'): ?>
        <div class="alerta alerta-sucesso">✅ Cadastro atualizado com sucesso!</div>
    <?php endif; ?>

    <!-- Formulário de Filtro / Pesquisa -->
    <form action="listar_pessoas.php" method="GET" class="filtro-container">
        <input type="text" name="busca" placeholder="🔍 Buscar por nome, cargo ou CPF..." value="<?php echo htmlspecialchars($busca); ?>">
        <button type="submit" class="btn btn-azul">Pesquisar</button>
        <?php if (!empty($busca)): ?>
            <a href="listar_pessoas.php" class="btn btn-cinza">Limpar Filtro</a>
        <?php endif; ?>
    </form>

    <?php if (count($pessoas) > 0): ?>
        <div class="tabela-container">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Completo</th>
                        <th>Cargo / Papel</th>
                        <th>Equipe(s) Atual</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pessoas as $p): ?>
                        <tr>
                            <td><?php echo $p['pessoa_id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($p['nome']); ?></strong></td>
                            <td><span class="badge badge-papel"><?php echo htmlspecialchars($p['papel_nome']); ?></span></td>
                            <td>
                                <?php if (!empty($p['equipes_alocadas'])): ?>
                                    <span class="badge badge-equipe"><?php echo htmlspecialchars($p['equipes_alocadas']); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-disponivel">Sem equipe (Disponível)</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($p['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($p['cpf']); ?></td>
                            <td>
                                <a href="editar_pessoa.php?id=<?php echo $p['pessoa_id']; ?>" class="btn btn-sm btn-azul">Editar</a>
                                <a href="excluir_pessoa.php?id=<?php echo $p['pessoa_id']; ?>" 
                                   class="btn btn-sm btn-vermelho"
                                   onclick="return confirm('Tem certeza que deseja excluir esta pessoa?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p style="color: #777; padding: 20px 0;">Nenhuma pessoa encontrada com os critérios informados.</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>