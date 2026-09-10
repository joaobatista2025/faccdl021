<?php
/**
 * ==========================================================
 * CADASTRO DE NOVO PAPEL / TIPO (cadastro_tipo.php)
 * ==========================================================
 */

require_once 'header.php';
?>

<div class="card formulario-box">
    <div class="card-titulo">
        <span>🏷️ Cadastrar Novo Papel / Cargo</span>
    </div>

    <form action="salvar_tipo.php" method="POST">
        <div class="form-grupo">
            <label for="descricao">Nome do Papel / Função:</label>
            <input type="text" id="descricao" name="descricao" required placeholder="Ex: Designer UI/UX, Tester, DevOps">
        </div>

        <div class="form-acoes">
            <input type="submit" value="Salvar Papel" class="btn btn-cinza">
            <a href="listar_tipos.php" class="btn btn-azul">Voltar</a>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
