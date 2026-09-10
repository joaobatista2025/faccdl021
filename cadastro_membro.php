<?php
/**
 * ==========================================================
 * FORMULÁRIO DE VÍNCULO DE MEMBRO (cadastro_membro.php)
 * Carrega dinamicamente os nomes das equipes e das pessoas
 * para o usuário selecionar com facilidade no dropdown.
 * ==========================================================
 */

require_once 'conexao.php';

try {
    // 1. Busca todas as equipes cadastradas
    $equipes = $pdo->query("SELECT equipe_id, nome FROM tbEquipe ORDER BY nome ASC")->fetchAll();

    // 2. Busca todas as pessoas cadastradas
    $pessoas = $pdo->query("SELECT pessoa_id, nome FROM tbPessoas ORDER BY nome ASC")->fetchAll();

} catch (PDOException $erro) {
    die("Erro ao carregar dados: " . $erro->getMessage());
}

require_once 'header.php';
?>

<div class="card formulario-box">
    <div class="card-titulo">
        <span>🔗 Vincular Pessoa a uma Equipe</span>
    </div>

    <?php if (count($equipes) === 0 || count($pessoas) === 0): ?>
        <div class="alerta alerta-erro">
            <p><strong>Atenção:</strong> Você precisa ter pelo menos uma equipe e uma pessoa cadastrada antes de fazer um vínculo.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="cadastro_equipe.php" class="btn btn-verde">+ Cadastrar Equipe</a>
            <a href="cadastro_pessoa.php" class="btn btn-laranja">+ Cadastrar Pessoa</a>
        </div>
    <?php else: ?>
        <form action="salvar_membro.php" method="POST">
            
            <!-- Seleção da Equipe -->
            <div class="form-grupo">
                <label for="equipe_id">Selecione a Equipe:</label>
                <select id="equipe_id" name="equipe_id" required>
                    <option value="">-- Escolha a Equipe --</option>
                    <?php foreach ($equipes as $eq): ?>
                        <option value="<?php echo $eq['equipe_id']; ?>">
                            <?php echo htmlspecialchars($eq['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Seleção do Membro -->
            <div class="form-grupo">
                <label for="membro_id">Selecione a Pessoa / Membro:</label>
                <select id="membro_id" name="membro_id" required>
                    <option value="">-- Escolha a Pessoa --</option>
                    <?php foreach ($pessoas as $pes): ?>
                        <option value="<?php echo $pes['pessoa_id']; ?>">
                            <?php echo htmlspecialchars($pes['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-acoes">
                <input type="submit" value="Salvar Vínculo" class="btn btn-roxo">
                <a href="listar_membros.php" class="btn btn-cinza">Voltar / Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
