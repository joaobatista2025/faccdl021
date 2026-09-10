<?php
/**
 * ==========================================================
 * LISTAGEM DE USUÁRIOS (listar_usuarios.php)
 * ==========================================================
 */

require_once 'conexao.php';

try {
    $sql = "SELECT usuario_id, nome, login, atualizado_em FROM tbUsuarios ORDER BY nome ASC";
    $usuarios = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    die("Erro ao buscar usuários: " . $erro->getMessage());
}

require_once 'header.php';
?>

<div class="card">
    <div class="card-titulo">
        <span>🔒 Usuários de Acesso ao Sistema</span>
        <a href="cadastro_usuario.php" class="btn btn-azul">+ Novo Usuário</a>
    </div>

    <?php if (count($usuarios) > 0): ?>
        <div class="tabela-container">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Completo</th>
                        <th>Login de Acesso</th>
                        <th>Data de Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?php echo $u['usuario_id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($u['nome']); ?></strong></td>
                            <td><code><?php echo htmlspecialchars($u['login']); ?></code></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($u['atualizado_em'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p style="color: #666; padding: 20px 0;">Nenhum usuário cadastrado.</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>