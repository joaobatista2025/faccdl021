<?php
/**
 * ==========================================================
 * FORMULÁRIO DE EDIÇÃO DE PESSOA (editar_pessoa.php)
 * Busca os dados atuais da pessoa pelo ID e permite alterá-los.
 * ==========================================================
 */

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: listar_pessoas.php');
    exit;
}

try {
    // 1. Busca os dados atuais da pessoa
    $stmt = $pdo->prepare("SELECT * FROM tbPessoas WHERE pessoa_id = ?");
    $stmt->execute([$id]);
    $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pessoa) {
        die("Pessoa não encontrada!");
    }

    // 2. Busca a lista de papéis disponíveis
    $tipos = $pdo->query("SELECT * FROM tbPessoaTipo ORDER BY descricao ASC")->fetchAll();

} catch (PDOException $erro) {
    die("Erro ao carregar dados para edição: " . $erro->getMessage());
}

require_once 'header.php';
?>

<div class="card formulario-box">
    <div class="card-titulo">
        <span>✏️ Editar Dados da Pessoa</span>
    </div>

    <form action="salvar_pessoa_edicao.php" method="POST">
        <!-- Campo oculto guardando o ID que será editado -->
        <input type="hidden" name="pessoa_id" value="<?php echo $pessoa['pessoa_id']; ?>">

        <div class="form-grupo">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($pessoa['nome']); ?>" required>
        </div>

        <div class="form-grupo">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="14" value="<?php echo htmlspecialchars($pessoa['cpf']); ?>" required>
        </div>

        <div class="form-grupo">
            <label for="nascimento">Data de Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $pessoa['nascimento']; ?>" required>
        </div>

        <div class="form-grupo">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($pessoa['telefone']); ?>" required>
        </div>

        <div class="form-grupo">
            <label for="pessoa_tipo_id">Papel / Função:</label>
            <select id="pessoa_tipo_id" name="pessoa_tipo_id" required>
                <?php foreach ($tipos as $t): ?>
                    <option value="<?php echo $t['pessoa_tipo_id']; ?>" <?php if ($t['pessoa_tipo_id'] == $pessoa['pessoa_tipo_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($t['descricao']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-acoes">
            <input type="submit" value="Salvar Alterações" class="btn btn-azul">
            <a href="listar_pessoas.php" class="btn btn-cinza">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
