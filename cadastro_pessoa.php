<?php
/**
 * ==========================================================
 * FORMULÁRIO DE CADASTRO DE PESSOA (cadastro_pessoa.php)
 * Carrega os papéis/cargos dinamicamente do banco de dados.
 * ==========================================================
 */

// 1. Conecta ao banco de dados
require_once 'conexao.php';

try {
    // 2. Busca todos os papéis disponíveis para preencher a seleção (<select>)
    $stmt = $pdo->query("SELECT * FROM tbPessoaTipo ORDER BY descricao ASC");
    $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    die("Erro ao carregar tipos de pessoa: " . $erro->getMessage());
}

// 3. Inclui o cabeçalho padrão
require_once 'header.php';
?>

<div class="card formulario-box">
    <div class="card-titulo">
        <span>👤 Cadastrar Nova Pessoa</span>
    </div>

    <form action="salvar_pessoa.php" method="POST">
        <!-- Campo: Nome Completo -->
        <div class="form-grupo">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required placeholder="Ex: João da Silva">
        </div>

        <!-- Campo: CPF -->
        <div class="form-grupo">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="14" required placeholder="Ex: 123.456.789-00">
        </div>

        <!-- Campo: Data de Nascimento (Com validação: não aceita datas no futuro) -->
        <div class="form-grupo">
            <label for="nascimento">Data de Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" max="<?php echo date('Y-m-d'); ?>" min="1920-01-01" required>
        </div>

        <!-- Campo: Telefone -->
        <div class="form-grupo">
            <label for="telefone">Telefone / Celular:</label>
            <input type="text" id="telefone" name="telefone" required placeholder="Ex: (11) 98888-7777">
        </div>

        <!-- Campo: Papel / Cargo (Carregado dinamicamente do MySQL) -->
        <div class="form-grupo">
            <label for="pessoa_tipo_id">Papel / Função no Sistema:</label>
            <select id="pessoa_tipo_id" name="pessoa_tipo_id" required>
                <option value="">-- Selecione um papel --</option>
                <?php foreach ($tipos as $t): ?>
                    <option value="<?php echo $t['pessoa_tipo_id']; ?>">
                        <?php echo htmlspecialchars($t['descricao']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Botões de Ação -->
        <div class="form-acoes">
            <input type="submit" value="Salvar Pessoa" class="btn btn-laranja">
            <a href="listar_pessoas.php" class="btn btn-cinza">Voltar / Cancelar</a>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
