<?php
/**
 * ==========================================================
 * LISTAGEM DE PAPÉIS / TIPOS DE PESSOA (listar_tipos.php)
 * Gerencia os papéis da tabela tbPessoaTipo.
 * ==========================================================
 */

require_once 'conexao.php';

try {
    $sql = "SELECT t.pessoa_tipo_id, t.descricao, COUNT(p.pessoa_id) AS total_pessoas
            FROM tbPessoaTipo t
            LEFT JOIN tbPessoas p ON t.pessoa_tipo_id = p.pessoa_tipo_id
            GROUP BY t.pessoa_tipo_id
            ORDER BY t.pessoa_tipo_id ASC";
    $tipos = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    die("Erro ao buscar papéis: " . $erro->getMessage());
}

require_once 'header.php';
?>

<div class="card">
    <div class="card-titulo">
        <span>🏷️ Papéis e Cargos no Sistema (tbPessoaTipo)</span>
        <a href="cadastro_tipo.php" class="btn btn-cinza">+ Novo Papel</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'sucesso'): ?>
        <div class="alerta alerta-sucesso">✅ Papel cadastrado com sucesso!</div>
    <?php endif; ?>

    <?php if (count($tipos) > 0): ?>
        <div class="tabela-container">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição do Papel / Cargo</th>
                        <th>Profissionais Alocados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tipos as $t): ?>
                        <tr>
                            <td><?php echo $t['pessoa_tipo_id']; ?></td>
                            <td><span class="badge badge-papel"><?php echo htmlspecialchars($t['descricao']); ?></span></td>
                            <td><?php echo $t['total_pessoas']; ?> pessoa(s)</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
